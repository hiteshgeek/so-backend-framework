<?php

namespace Core\Cache;

/**
 * Cache Repository
 *
 * Main interface for cache operations
 */
class Repository
{
    protected $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    /**
     * Get an item from the cache
     */
    public function get(string $key, $default = null)
    {
        $value = $this->store->get($key);
        return $value !== null ? $value : $default;
    }

    /**
     * Store an item in the cache for a given number of seconds
     */
    public function put(string $key, $value, int $seconds): bool
    {
        return $this->store->put($key, $value, $seconds);
    }

    /**
     * Store an item in the cache indefinitely
     */
    public function forever(string $key, $value): bool
    {
        return $this->store->forever($key, $value);
    }

    /**
     * Remove an item from the cache
     */
    public function forget(string $key): bool
    {
        return $this->store->forget($key);
    }

    /**
     * Remove all items from the cache
     */
    public function flush(): bool
    {
        return $this->store->flush();
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result
     */
    public function remember(string $key, int $seconds, \Closure $callback)
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }

        $value = $callback();
        $this->put($key, $value, $seconds);

        return $value;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever
     */
    public function rememberForever(string $key, \Closure $callback)
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }

        $value = $callback();
        $this->forever($key, $value);

        return $value;
    }

    /**
     * Determine if an item exists in the cache
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Increment the value of an item in the cache
     */
    public function increment(string $key, int $value = 1): int
    {
        return $this->store->increment($key, $value);
    }

    /**
     * Decrement the value of an item in the cache
     */
    public function decrement(string $key, int $value = 1): int
    {
        return $this->store->decrement($key, $value);
    }

    /**
     * Get the underlying cache store
     */
    public function getStore()
    {
        return $this->store;
    }
}
