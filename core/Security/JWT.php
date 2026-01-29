<?php

namespace Core\Security;

/**
 * JSON Web Token (JWT) Implementation
 *
 * Provides stateless authentication using JWT tokens with HS256 algorithm.
 * Tokens are signed and verified using a secret key.
 *
 * Usage:
 *   $jwt = new JWT($secret);
 *   $token = $jwt->encode(['user_id' => 1], 3600);  // Encode with 1 hour TTL
 *   $payload = $jwt->decode($token);                 // Decode and verify
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
     * Constructor
     *
     * @param string|null $secret Secret key (from config if not provided)
     * @param string $algorithm Algorithm to use (default: HS256)
     */
    public function __construct(?string $secret = null, string $algorithm = 'HS256')
    {
        $this->secret = $secret ?? config('security.jwt.secret', '');
        $this->algorithm = $algorithm;

        if (empty($this->secret)) {
            throw new \Exception('JWT secret key is not configured. Set JWT_SECRET in .env');
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

        // Verify algorithm
        if (!isset($header['alg']) || $header['alg'] !== $this->algorithm) {
            throw new \Exception('Invalid algorithm');
        }

        // Check expiration
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
