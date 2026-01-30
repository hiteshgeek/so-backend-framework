<?php

namespace Core\Auth;

use Core\Cache\CacheManager;

/**
 * Login Throttle (Brute Force Protection)
 *
 * Tracks failed login attempts per key (IP + username) using the cache system.
 * Locks out users after exceeding the configurable max attempts threshold
 * for a configurable decay period.
 */
class LoginThrottle
{
    /**
     * Cache prefix for login attempt keys
     */
    protected const CACHE_PREFIX = 'login_attempts:';

    /**
     * Cache prefix for lockout timer keys
     */
    protected const LOCKOUT_PREFIX = 'login_lockout:';

    /**
     * The cache manager instance
     */
    protected ?CacheManager $cache;

    /**
     * Whether lockout is enabled
     */
    protected bool $enabled;

    /**
     * Maximum login attempts before lockout
     */
    protected int $maxAttempts;

    /**
     * Lockout decay time in minutes
     */
    protected int $decayMinutes;

    /**
     * Create a new LoginThrottle instance.
     *
     * @param CacheManager|null $cache The cache manager (null disables throttling gracefully)
     * @param array $config Lockout configuration array
     */
    public function __construct(?CacheManager $cache, array $config = [])
    {
        $this->cache = $cache;
        $this->enabled = (bool) ($config['enabled'] ?? true);
        $this->maxAttempts = (int) ($config['max_attempts'] ?? 5);
        $this->decayMinutes = (int) ($config['decay_minutes'] ?? 15);
    }

    /**
     * Determine if the given key has been locked out (too many attempts).
     *
     * @param string $key The throttle key (typically sha1 of IP + username)
     * @return bool
     */
    public function tooManyAttempts(string $key): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        // Check if there is an active lockout
        if ($this->cache->get($this->lockoutKey($key)) !== null) {
            return true;
        }

        // Check if attempt count exceeds the max
        $attempts = $this->attempts($key);
        if ($attempts >= $this->maxAttempts) {
            // Set the lockout timer
            $this->lockout($key);
            return true;
        }

        return false;
    }

    /**
     * Increment the failed login attempts for the given key.
     * This is the primary method to call on a failed login.
     *
     * @param string $key The throttle key
     * @return void
     */
    public function attempt(string $key): void
    {
        $this->hit($key);
    }

    /**
     * Increment the counter for the given key and return the current count.
     *
     * @param string $key The throttle key
     * @return int The current number of attempts after incrementing
     */
    public function hit(string $key): int
    {
        if (!$this->isAvailable()) {
            return 0;
        }

        $attemptsKey = $this->attemptsKey($key);
        $decaySeconds = $this->decayMinutes * 60;

        $currentAttempts = (int) $this->cache->get($attemptsKey, 0);
        $newCount = $currentAttempts + 1;

        $this->cache->put($attemptsKey, $newCount, $decaySeconds);

        // If this hit crosses the threshold, set the lockout
        if ($newCount >= $this->maxAttempts) {
            $this->lockout($key);
        }

        return $newCount;
    }

    /**
     * Get the number of remaining attempts before lockout.
     *
     * @param string $key The throttle key
     * @return int Remaining attempts (0 if locked out)
     */
    public function attemptsLeft(string $key): int
    {
        if (!$this->isAvailable()) {
            return $this->maxAttempts;
        }

        if ($this->tooManyAttempts($key)) {
            return 0;
        }

        $current = $this->attempts($key);
        $remaining = $this->maxAttempts - $current;

        return max(0, $remaining);
    }

    /**
     * Get the number of seconds until the lockout expires.
     *
     * Returns 0 if the key is not currently locked out.
     *
     * @param string $key The throttle key
     * @return int Seconds remaining on the lockout
     */
    public function lockoutSeconds(string $key): int
    {
        if (!$this->isAvailable()) {
            return 0;
        }

        $lockoutExpiry = $this->cache->get($this->lockoutKey($key));

        if ($lockoutExpiry === null) {
            return 0;
        }

        $remaining = (int) $lockoutExpiry - time();

        return max(0, $remaining);
    }

    /**
     * Clear all login attempts and lockout for the given key.
     * Call this on successful login.
     *
     * @param string $key The throttle key
     * @return void
     */
    public function clear(string $key): void
    {
        if (!$this->isAvailable()) {
            return;
        }

        $this->cache->forget($this->attemptsKey($key));
        $this->cache->forget($this->lockoutKey($key));
    }

    /**
     * Generate a throttle key from an IP address and username/email.
     *
     * @param string $ip The client IP address
     * @param string $username The username or email used in the login attempt
     * @return string The hashed throttle key
     */
    public static function key(string $ip, string $username): string
    {
        return sha1($ip . '|' . mb_strtolower($username));
    }

    /**
     * Get the current number of attempts for the given key.
     *
     * @param string $key The throttle key
     * @return int
     */
    public function attempts(string $key): int
    {
        if (!$this->isAvailable()) {
            return 0;
        }

        return (int) $this->cache->get($this->attemptsKey($key), 0);
    }

    /**
     * Get the maximum number of allowed attempts.
     *
     * @return int
     */
    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }

    /**
     * Get the lockout decay time in minutes.
     *
     * @return int
     */
    public function getDecayMinutes(): int
    {
        return $this->decayMinutes;
    }

    /**
     * Set the lockout marker in cache.
     * Stores the expiry timestamp so lockoutSeconds() can compute remaining time.
     *
     * @param string $key The throttle key
     * @return void
     */
    protected function lockout(string $key): void
    {
        $decaySeconds = $this->decayMinutes * 60;
        $expiresAt = time() + $decaySeconds;

        $this->cache->put($this->lockoutKey($key), $expiresAt, $decaySeconds);
    }

    /**
     * Build the cache key for storing attempt counts.
     *
     * @param string $key The throttle key
     * @return string
     */
    protected function attemptsKey(string $key): string
    {
        return self::CACHE_PREFIX . $key;
    }

    /**
     * Build the cache key for storing lockout expiry timestamps.
     *
     * @param string $key The throttle key
     * @return string
     */
    protected function lockoutKey(string $key): string
    {
        return self::LOCKOUT_PREFIX . $key;
    }

    /**
     * Determine if throttling is available (enabled and cache is present).
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->enabled && $this->cache !== null;
    }
}
