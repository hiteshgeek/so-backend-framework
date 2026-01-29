<?php

namespace Core\Security;

use Core\Cache\CacheManager;

/**
 * Rate Limiter
 *
 * Implements rate limiting using cache storage to prevent API abuse.
 * Tracks requests by key (IP address, user ID, etc.) and enforces limits.
 *
 * Usage:
 *   $limiter = new RateLimiter($cache);
 *   if ($limiter->tooManyAttempts($key, $maxAttempts)) {
 *       // Rate limit exceeded
 *   }
 *   $limiter->hit($key, $decayMinutes);
 */
class RateLimiter
{
    /**
     * Cache manager instance
     */
    protected CacheManager $cache;

    /**
     * Constructor
     *
     * @param CacheManager $cache
     */
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Determine if the key has been accessed too many times
     *
     * @param string $key Unique identifier (IP, user ID, etc.)
     * @param int $maxAttempts Maximum allowed attempts
     * @return bool
     */
    public function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        if ($this->attempts($key) >= $maxAttempts) {
            if ($this->cache->has($this->timeoutKey($key))) {
                return true;
            }

            $this->resetAttempts($key);
        }

        return false;
    }

    /**
     * Increment the counter for a given key
     *
     * @param string $key Unique identifier
     * @param int $decayMinutes Time window in minutes
     * @return int New attempt count
     */
    public function hit(string $key, int $decayMinutes = 1): int
    {
        $cacheKey = $this->key($key);

        $this->cache->put(
            $this->timeoutKey($key),
            time() + ($decayMinutes * 60),
            $decayMinutes * 60
        );

        $added = $this->cache->remember($cacheKey, $decayMinutes * 60, function () {
            return 0;
        });

        $attempts = (int) $added + 1;

        $this->cache->put($cacheKey, $attempts, $decayMinutes * 60);

        return $attempts;
    }

    /**
     * Get the number of attempts for the given key
     *
     * @param string $key
     * @return int
     */
    public function attempts(string $key): int
    {
        return (int) $this->cache->get($this->key($key), 0);
    }

    /**
     * Reset the number of attempts for the given key
     *
     * @param string $key
     * @return void
     */
    public function resetAttempts(string $key): void
    {
        $this->cache->forget($this->key($key));
    }

    /**
     * Get the number of retries left for the given key
     *
     * @param string $key
     * @param int $maxAttempts
     * @return int
     */
    public function retriesLeft(string $key, int $maxAttempts): int
    {
        $attempts = $this->attempts($key);

        return $maxAttempts - $attempts;
    }

    /**
     * Clear rate limiter for the given key
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key): void
    {
        $this->resetAttempts($key);
        $this->cache->forget($this->timeoutKey($key));
    }

    /**
     * Get the number of seconds until the key is available again
     *
     * @param string $key
     * @return int
     */
    public function availableIn(string $key): int
    {
        $timeout = $this->cache->get($this->timeoutKey($key));

        return $timeout ? max(0, $timeout - time()) : 0;
    }

    /**
     * Get the cache key for rate limit attempts
     *
     * @param string $key
     * @return string
     */
    protected function key(string $key): string
    {
        return 'rate_limit:' . $key;
    }

    /**
     * Get the cache key for rate limit timeout
     *
     * @param string $key
     * @return string
     */
    protected function timeoutKey(string $key): string
    {
        return 'rate_limit:' . $key . ':timeout';
    }
}
