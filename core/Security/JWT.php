<?php

namespace Core\Security;

/**
 * JSON Web Token (JWT) Implementation
 *
 * Provides stateless authentication using JWT tokens with HS256 algorithm.
 * Tokens are signed and verified using a secret key. Supports token
 * blacklisting/revocation via JwtBlacklist for individual token and
 * per-user invalidation.
 *
 * Usage:
 *   $jwt = new JWT($secret);
 *   $token = $jwt->encode(['user_id' => 1], 3600);  // Encode with 1 hour TTL
 *   $payload = $jwt->decode($token);                 // Decode and verify
 *   $jwt->invalidate($token);                        // Revoke a single token
 *   $jwt->invalidateUser(1);                         // Revoke all tokens for user
 */
class JWT
{
    /**
     * Secret key for signing tokens
     */
    protected string $secret;

    /**
     * Algorithm used for signing (only HS256 supported)
     */
    protected string $algorithm = 'HS256';

    /**
     * Token blacklist instance
     */
    protected ?JwtBlacklist $blacklist = null;

    /**
     * Constructor
     *
     * @param string|null $secret Secret key (from config if not provided)
     * @param string $algorithm Algorithm to use (default: HS256)
     */
    public function __construct(?string $secret = null, string $algorithm = 'HS256')
    {
        $this->secret = $secret ?? config('security.jwt.secret', '');
        $this->algorithm = $algorithm;

        $insecureDefaults = ['', 'test-secret-key-change-in-production'];
        if (in_array($this->secret, $insecureDefaults, true)) {
            throw new \RuntimeException(
                'JWT secret key is not configured or uses an insecure default. Set a strong JWT_SECRET in your .env file.'
            );
        }

        if (strlen($this->secret) < 32) {
            throw new \RuntimeException(
                'JWT secret key is too short (minimum 32 characters). Set a strong JWT_SECRET in your .env file.'
            );
        }

        // Initialise the blacklist (gracefully handles missing cache)
        try {
            $this->blacklist = new JwtBlacklist();
        } catch (\Throwable $e) {
            // Blacklist not available -- token operations continue without it
            $this->blacklist = null;
        }
    }

    /**
     * Encode payload into JWT token
     *
     * @param array $payload Data to encode
     * @param int|null $ttl Time-to-live in seconds (null = no expiration)
     * @return string JWT token
     */
    public function encode(array $payload, ?int $ttl = null): string
    {
        // Add standard claims
        $payload['iat'] = time(); // Issued at

        // Auto-generate a unique JWT ID if not already present
        if (!isset($payload['jti'])) {
            $payload['jti'] = bin2hex(random_bytes(16));
        }

        if ($ttl !== null) {
            $payload['exp'] = time() + $ttl; // Expiration
        }

        // Build header
        $header = [
            'typ' => 'JWT',
            'alg' => $this->algorithm
        ];

        // Encode header and payload
        $segments = [
            $this->base64UrlEncode(json_encode($header)),
            $this->base64UrlEncode(json_encode($payload))
        ];

        // Sign
        $signature = $this->sign(implode('.', $segments));
        $segments[] = $signature;

        return implode('.', $segments);
    }

    /**
     * Decode and verify JWT token
     *
     * @param string $token JWT token to decode
     * @return array Decoded payload
     * @throws \Exception If token is invalid or expired
     */
    public function decode(string $token): array
    {
        $segments = explode('.', $token);

        if (count($segments) !== 3) {
            throw new \Exception('Invalid token format');
        }

        [$headerEncoded, $payloadEncoded, $signature] = $segments;

        // Verify signature
        $expected = $this->sign($headerEncoded . '.' . $payloadEncoded);
        if (!hash_equals($expected, $signature)) {
            throw new \Exception('Invalid signature');
        }

        // Decode header and payload
        $header = json_decode($this->base64UrlDecode($headerEncoded), true);
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);

        // Verify JSON decoded correctly
        if (!is_array($header) || !is_array($payload)) {
            throw new \Exception('Invalid token: malformed JSON');
        }

        // Verify algorithm
        if (!isset($header['alg']) || $header['alg'] !== $this->algorithm) {
            throw new \Exception('Invalid algorithm');
        }

        // Check expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            throw new \Exception('Token expired');
        }

        // Check individual token blacklist (by JTI)
        if ($this->blacklist !== null && isset($payload['jti'])) {
            if ($this->blacklist->isBlacklisted($payload['jti'])) {
                throw new \Exception('Token has been revoked');
            }
        }

        // Check user-level invalidation (compare iat with revocation timestamp)
        if ($this->blacklist !== null && isset($payload['sub']) && isset($payload['iat'])) {
            $userId = (int) $payload['sub'];
            if ($this->blacklist->isUserInvalidated($userId, $payload['iat'])) {
                throw new \Exception('Token has been revoked (user invalidated)');
            }
        }

        // Also support user_id as an alternative to the standard sub claim
        if ($this->blacklist !== null && isset($payload['user_id']) && !isset($payload['sub']) && isset($payload['iat'])) {
            $userId = (int) $payload['user_id'];
            if ($this->blacklist->isUserInvalidated($userId, $payload['iat'])) {
                throw new \Exception('Token has been revoked (user invalidated)');
            }
        }

        return $payload;
    }

    /**
     * Invalidate (blacklist) a specific token
     *
     * Decodes the token to extract its JTI and expiration, then adds
     * it to the blacklist. The token signature is verified before
     * blacklisting to prevent cache pollution with invalid JTIs.
     *
     * @param string $token The JWT token to revoke
     * @return void
     * @throws \Exception If the token cannot be decoded
     */
    public function invalidate(string $token): void
    {
        if ($this->blacklist === null) {
            return;
        }

        // Decode without blacklist check to get payload for a token that
        // is still valid (signature + expiry are still verified).
        $payload = $this->decodeRaw($token);

        if (!isset($payload['jti'])) {
            throw new \Exception('Cannot invalidate token: missing jti claim');
        }

        $expiresAt = $payload['exp'] ?? 0;
        $this->blacklist->add($payload['jti'], $expiresAt);
    }

    /**
     * Invalidate all tokens for a specific user
     *
     * Any token with an iat before the current timestamp (minus the
     * configured grace period) will be rejected on decode.
     *
     * @param int $userId The user ID whose tokens should be revoked
     * @return void
     */
    public function invalidateUser(int $userId): void
    {
        if ($this->blacklist === null) {
            return;
        }

        $this->blacklist->invalidateUser($userId);
    }

    /**
     * Get the blacklist instance
     *
     * @return JwtBlacklist|null
     */
    public function getBlacklist(): ?JwtBlacklist
    {
        return $this->blacklist;
    }

    /**
     * Decode and verify a token without checking the blacklist
     *
     * Used internally by invalidate() to extract payload claims from
     * a token that needs to be revoked. All other validation (signature,
     * structure, algorithm, expiry) is still performed.
     *
     * @param string $token JWT token to decode
     * @return array Decoded payload
     * @throws \Exception If token is invalid or expired
     */
    protected function decodeRaw(string $token): array
    {
        $segments = explode('.', $token);

        if (count($segments) !== 3) {
            throw new \Exception('Invalid token format');
        }

        [$headerEncoded, $payloadEncoded, $signature] = $segments;

        // Verify signature
        $expected = $this->sign($headerEncoded . '.' . $payloadEncoded);
        if (!hash_equals($expected, $signature)) {
            throw new \Exception('Invalid signature');
        }

        // Decode header and payload
        $header = json_decode($this->base64UrlDecode($headerEncoded), true);
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);

        if (!is_array($header) || !is_array($payload)) {
            throw new \Exception('Invalid token: malformed JSON');
        }

        if (!isset($header['alg']) || $header['alg'] !== $this->algorithm) {
            throw new \Exception('Invalid algorithm');
        }

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            throw new \Exception('Token expired');
        }

        return $payload;
    }

    /**
     * Sign a message using HMAC SHA256
     *
     * @param string $message Message to sign
     * @return string Base64 URL-encoded signature
     */
    protected function sign(string $message): string
    {
        $signature = hash_hmac('sha256', $message, $this->secret, true);
        return $this->base64UrlEncode($signature);
    }

    /**
     * Base64 URL-safe encoding
     *
     * @param string $data Data to encode
     * @return string Base64 URL-encoded string
     */
    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64 URL-safe decoding
     *
     * @param string $data Data to decode
     * @return string Decoded string
     */
    protected function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Create JWT instance from configuration
     *
     * @return self
     */
    public static function fromConfig(): self
    {
        return new self(
            config('security.jwt.secret'),
            config('security.jwt.algorithm', 'HS256')
        );
    }

    /**
     * Get default TTL from configuration
     *
     * @return int TTL in seconds
     */
    public static function getDefaultTtl(): int
    {
        return config('security.jwt.ttl', 3600); // Default: 1 hour
    }
}
