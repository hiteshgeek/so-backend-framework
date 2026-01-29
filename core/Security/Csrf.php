<?php

namespace Core\Security;

/**
 * CSRF Protection
 *
 * Provides Cross-Site Request Forgery protection using session-based tokens.
 * Tokens are generated once per session and verified on state-changing requests.
 *
 * Usage:
 *   $token = Csrf::token();           // Get current token
 *   Csrf::verify($token);             // Verify token
 *   Csrf::regenerate();               // Generate new token
 */
class Csrf
{
    /**
     * Current CSRF token (cached)
     */
    protected static ?string $token = null;

    /**
     * Session key for storing CSRF token
     */
    protected const SESSION_KEY = '_csrf_token';

    /**
     * Get or generate CSRF token
     *
     * @return string The CSRF token
     */
    public static function token(): string
    {
        if (self::$token === null) {
            // Try to get token from session
            self::$token = session()->get(self::SESSION_KEY);

            // Generate new token if none exists
            if (!self::$token) {
                self::$token = self::generate();
                session()->set(self::SESSION_KEY, self::$token);
            }
        }

        return self::$token;
    }

    /**
     * Verify CSRF token
     *
     * Uses timing-safe comparison to prevent timing attacks
     *
     * @param string $token Token to verify
     * @return bool True if token is valid
     */
    public static function verify(string $token): bool
    {
        $expected = self::token();

        // Both tokens must be non-empty
        if (empty($token) || empty($expected)) {
            return false;
        }

        // Timing-safe comparison
        return hash_equals($expected, $token);
    }

    /**
     * Regenerate CSRF token
     *
     * Useful after login or other security-sensitive operations
     *
     * @return string The new token
     */
    public static function regenerate(): string
    {
        self::$token = self::generate();
        session()->set(self::SESSION_KEY, self::$token);

        return self::$token;
    }

    /**
     * Generate a new random token
     *
     * @return string 64-character hexadecimal token
     */
    protected static function generate(): string
    {
        return bin2hex(random_bytes(32)); // 32 bytes = 64 hex characters
    }

    /**
     * Check if CSRF protection is enabled
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return config('security.csrf.enabled', true);
    }

    /**
     * Check if current request should be excluded from CSRF verification
     *
     * @param string $uri Request URI
     * @return bool True if request should be excluded
     */
    public static function isExcluded(string $uri): bool
    {
        $except = config('security.csrf.except', []);

        foreach ($except as $pattern) {
            // Convert wildcard pattern to regex
            $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . '$#';

            if (preg_match($regex, $uri)) {
                return true;
            }
        }

        return false;
    }
}
