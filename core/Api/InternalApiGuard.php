<?php

namespace Core\Api;

use Core\Http\Request;

/**
 * Internal API Guard
 *
 * Provides signature-based authentication for internal API calls (cron jobs, CLI scripts).
 * Uses HMAC-SHA256 signatures with timestamp validation to prevent replay attacks.
 *
 * Usage:
 *   // Generate signature for outgoing request
 *   $guard = new InternalApiGuard($secret);
 *   $signature = $guard->generateSignature($method, $uri, $timestamp, $body);
 *
 *   // Verify signature on incoming request
 *   if ($guard->verify($request)) {
 *       // Request is authenticated
 *   }
 */
class InternalApiGuard
{
    /**
     * Secret key for signing
     */
    protected string $secret;

    /**
     * Max age of timestamp in seconds (default: 5 minutes)
     */
    protected int $maxAge;

    /**
     * Constructor
     *
     * @param string|null $secret Secret key (from config if not provided)
     * @param int $maxAge Maximum age of timestamp in seconds
     */
    public function __construct(?string $secret = null, int $maxAge = 300)
    {
        $this->secret = $secret ?? config('api.signature_secret', '');
        $this->maxAge = $maxAge;

        if (empty($this->secret)) {
            throw new \Exception('API signature secret is not configured. Set INTERNAL_API_SIGNATURE_KEY in .env');
        }
    }

    /**
     * Generate signature for request
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $uri Request URI
     * @param int $timestamp Unix timestamp
     * @param string $body Request body (JSON encoded)
     * @return string HMAC-SHA256 signature
     */
    public function generateSignature(string $method, string $uri, int $timestamp, string $body = ''): string
    {
        // Create signature string: METHOD\nURI\nTIMESTAMP\nBODY
        $signatureString = implode("\n", [
            strtoupper($method),
            $uri,
            $timestamp,
            $body
        ]);

        // Generate HMAC-SHA256 signature
        return hash_hmac('sha256', $signatureString, $this->secret);
    }

    /**
     * Verify request signature
     *
     * @param Request $request Request to verify
     * @return bool True if signature is valid
     */
    public function verify(Request $request): bool
    {
        // Get signature from header
        $signature = $request->header('X-Signature');
        if (!$signature) {
            return false;
        }

        // Get timestamp from header
        $timestamp = (int) $request->header('X-Timestamp');
        if (!$timestamp) {
            return false;
        }

        // Check timestamp is within allowed window
        if (!$this->isTimestampValid($timestamp)) {
            return false;
        }

        // Get request details
        $method = $request->method();
        $uri = $request->uri();
        $body = $request->getContent();

        // Generate expected signature
        $expectedSignature = $this->generateSignature($method, $uri, $timestamp, $body);

        // Compare signatures using timing-safe comparison
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Check if timestamp is valid (not too old)
     *
     * @param int $timestamp Unix timestamp
     * @return bool True if timestamp is valid
     */
    protected function isTimestampValid(int $timestamp): bool
    {
        $now = time();
        $age = abs($now - $timestamp);

        return $age <= $this->maxAge;
    }

    /**
     * Generate authentication headers for request
     *
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @param string $body Request body
     * @return array Headers array ['X-Signature' => ..., 'X-Timestamp' => ...]
     */
    public function generateHeaders(string $method, string $uri, string $body = ''): array
    {
        $timestamp = time();
        $signature = $this->generateSignature($method, $uri, $timestamp, $body);

        return [
            'X-Signature' => $signature,
            'X-Timestamp' => (string) $timestamp,
        ];
    }

    /**
     * Create from config
     *
     * @return self
     */
    public static function fromConfig(): self
    {
        return new self(
            config('api.signature_secret'),
            config('api.signature_max_age', 300)
        );
    }

    /**
     * Get max age
     *
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->maxAge;
    }

    /**
     * Set max age
     *
     * @param int $maxAge
     * @return self
     */
    public function setMaxAge(int $maxAge): self
    {
        $this->maxAge = $maxAge;
        return $this;
    }
}
