<?php

namespace Core\Cache\Drivers;

use Core\Database\Connection;

/**
 * Database Cache Driver
 *
 * Stores cache data in database for sharing across servers
 */
class DatabaseCache
{
    protected Connection $connection;
    protected string $table;
    protected string $prefix;

    public function __construct(Connection $connection, string $table = 'cache', string $prefix = '')
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->prefix = $prefix;
    }

    /**
     * Get an item from the cache
     */
    public function get(string $key)
    {
        try {
            $key = $this->prefix . $key;

            $sql = "SELECT value, expiration FROM {$this->table} WHERE `key` = ?";
            $stmt = $this->connection->query($sql, [$key]);

            $result = ($stmt instanceof \PDOStatement)
                ? $stmt->fetchAll(\PDO::FETCH_ASSOC)
                : $stmt;

            if (empty($result)) {
                return null;
            }

            $item = $result[0];

            // Check if expired
            if ($item['expiration'] < time()) {
                $this->forget($key);
                return null;
            }

            return json_decode($item['value'], true);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Store an item in the cache
     */
    public function put(string $key, $value, int $seconds): bool
    {
        try {
            $key = $this->prefix . $key;
            $value = json_encode($value);
            $expiration = time() + $seconds;

            $sql = "INSERT INTO {$this->table} (`key`, value, expiration)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE value = ?, expiration = ?";

            return $this->connection->execute($sql, [$key, $value, $expiration, $value, $expiration]) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Store an item in the cache indefinitely
     */
    public function forever(string $key, $value): bool
    {
        return $this->put($key, $value, 315360000); // 10 years
    }

    /**
     * Remove an item from the cache
     */
    public function forget(string $key): bool
    {
        try {
            $key = $this->prefix . $key;
            $sql = "DELETE FROM {$this->table} WHERE `key` = ?";
            return $this->connection->execute($sql, [$key]) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove all items from the cache
     */
    public function flush(): bool
    {
        try {
            if ($this->prefix) {
                $sql = "DELETE FROM {$this->table} WHERE `key` LIKE ?";
                return $this->connection->execute($sql, [$this->prefix . '%']) >= 0;
            }

            $sql = "DELETE FROM {$this->table}";
            return $this->connection->execute($sql, []) >= 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Increment the value of an item in the cache
     */
    public function increment(string $key, int $value = 1): int
    {
        $current = (int)$this->get($key);
        $new = $current + $value;
        $this->forever($key, $new);
        return $new;
    }

    /**
     * Decrement the value of an item in the cache
     */
    public function decrement(string $key, int $value = 1): int
    {
        return $this->increment($key, -$value);
    }

    /**
     * Remove expired items from the cache
     */
    public function gc(): int
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE expiration < ?";
            return $this->connection->execute($sql, [time()]);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
