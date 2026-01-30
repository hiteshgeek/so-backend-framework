<?php

namespace Core\Cache\Drivers;

/**
 * File Cache Driver
 *
 * Stores cache entries as serialized files in the filesystem.
 * Each cache entry is stored with its expiration timestamp.
 *
 * Storage format:
 * - Directory: storage/cache/
 * - Filename: {hashed_key}.cache
 * - Content: serialized array ['value' => mixed, 'expiration' => int|null]
 */
class FileCache
{
    /**
     * Cache storage directory
     */
    protected string $directory;

    /**
     * File extension for cache files
     */
    protected string $extension = '.cache';

    /**
     * Constructor
     *
     * @param string|null $directory Cache storage directory (default: storage/cache)
     */
    public function __construct(?string $directory = null)
    {
        $this->directory = $directory ?? $this->getDefaultDirectory();

        // Create directory if it doesn't exist
        if (!is_dir($this->directory)) {
            @mkdir($this->directory, 0755, true);
        }
    }

    /**
     * Get default cache directory
     */
    protected function getDefaultDirectory(): string
    {
        $base = dirname(__DIR__, 3); // Go up to framework root
        return $base . '/storage/cache';
    }

    /**
     * Retrieve an item from the cache
     *
     * @param string $key Cache key
     * @return mixed|null Cached value or null if not found/expired
     */
    public function get(string $key)
    {
        $path = $this->getPath($key);

        if (!file_exists($path)) {
            return null;
        }

        try {
            $contents = @file_get_contents($path);

            if ($contents === false) {
                return null;
            }

            $item = unserialize($contents);

            if (!is_array($item) || !isset($item['value'])) {
                @unlink($path);
                return null;
            }

            // Check expiration
            if ($item['expiration'] !== null && $item['expiration'] < time()) {
                @unlink($path);
                return null;
            }

            return $item['value'];
        } catch (\Throwable $e) {
            // Corrupt cache file
            @unlink($path);
            return null;
        }
    }

    /**
     * Store an item in the cache with TTL
     *
     * @param string $key Cache key
     * @param mixed $value Value to cache
     * @param int $seconds TTL in seconds (0 = no expiration)
     * @return bool Success status
     */
    public function put(string $key, $value, int $seconds): bool
    {
        $path = $this->getPath($key);

        $item = [
            'value' => $value,
            'expiration' => $seconds > 0 ? time() + $seconds : null,
        ];

        $contents = serialize($item);

        // Write to temp file first, then rename (atomic operation)
        $tempPath = $path . '.' . uniqid('tmp', true);

        if (@file_put_contents($tempPath, $contents, LOCK_EX) === false) {
            return false;
        }

        return @rename($tempPath, $path);
    }

    /**
     * Store an item in the cache indefinitely
     *
     * @param string $key Cache key
     * @param mixed $value Value to cache
     * @return bool Success status
     */
    public function forever(string $key, $value): bool
    {
        return $this->put($key, $value, 0);
    }

    /**
     * Remove an item from the cache
     *
     * @param string $key Cache key
     * @return bool Success status
     */
    public function forget(string $key): bool
    {
        $path = $this->getPath($key);

        if (!file_exists($path)) {
            return true;
        }

        return @unlink($path);
    }

    /**
     * Remove all items from the cache
     *
     * @return bool Success status
     */
    public function flush(): bool
    {
        if (!is_dir($this->directory)) {
            return true;
        }

        // Remove all cache files from subdirectories
        $files = glob($this->directory . '/*/*.cache');

        if ($files === false) {
            return false;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        // Remove empty subdirectories
        $subdirs = glob($this->directory . '/*', GLOB_ONLYDIR);
        if ($subdirs !== false) {
            foreach ($subdirs as $subdir) {
                @rmdir($subdir);
            }
        }

        return true;
    }

    /**
     * Increment a numeric cache value
     *
     * @param string $key Cache key
     * @param int $value Amount to increment by
     * @return int New value
     */
    public function increment(string $key, int $value = 1): int
    {
        $current = (int) $this->get($key);
        $new = $current + $value;

        $this->forever($key, $new);

        return $new;
    }

    /**
     * Decrement a numeric cache value
     *
     * @param string $key Cache key
     * @param int $value Amount to decrement by
     * @return int New value
     */
    public function decrement(string $key, int $value = 1): int
    {
        return $this->increment($key, -$value);
    }

    /**
     * Get the full file path for a cache key
     *
     * @param string $key Cache key
     * @return string File path
     */
    protected function getPath(string $key): string
    {
        // Hash the key to create a safe filename
        $hash = sha1($key);

        // Use first 2 characters for subdirectory (prevents too many files in one dir)
        $subdir = substr($hash, 0, 2);
        $dir = $this->directory . '/' . $subdir;

        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return $dir . '/' . $hash . $this->extension;
    }

    /**
     * Clean up expired cache entries (garbage collection)
     *
     * @return int Number of files deleted
     */
    public function garbageCollect(): int
    {
        if (!is_dir($this->directory)) {
            return 0;
        }

        $deleted = 0;
        $pattern = $this->directory . '/*/*' . $this->extension;
        $files = glob($pattern);

        if ($files === false) {
            return 0;
        }

        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }

            try {
                $contents = @file_get_contents($file);

                if ($contents === false) {
                    continue;
                }

                $item = unserialize($contents);

                if (!is_array($item) || !isset($item['expiration'])) {
                    @unlink($file);
                    $deleted++;
                    continue;
                }

                // Delete if expired
                if ($item['expiration'] !== null && $item['expiration'] < time()) {
                    @unlink($file);
                    $deleted++;
                }
            } catch (\Throwable $e) {
                // Corrupt file - delete it
                @unlink($file);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Get cache directory path
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }
}
