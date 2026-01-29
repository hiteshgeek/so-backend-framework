<?php

namespace Core\Cache;

use Core\Database\Connection;

/**
 * Cache Lock
 *
 * Implements cache locking using cache_locks table
 * Prevents race conditions in cache operations
 */
class Lock
{
    protected Connection $connection;
    protected string $table = 'cache_locks';
    protected string $name;
    protected ?string $owner = null;
    protected int $seconds;

    public function __construct(Connection $connection, string $name, int $seconds = 0)
    {
        $this->connection = $connection;
        $this->name = $name;
        $this->seconds = $seconds;
        $this->owner = $this->generateOwner();
    }

    /**
     * Attempt to acquire the lock
     */
    public function acquire(): bool
    {
        $expiration = $this->seconds > 0 ? time() + $this->seconds : null;

        $sql = "INSERT INTO {$this->table} (`key`, owner, expiration)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    owner = IF(expiration IS NULL OR expiration < UNIX_TIMESTAMP(), VALUES(owner), owner),
                    expiration = IF(expiration IS NULL OR expiration < UNIX_TIMESTAMP(), VALUES(expiration), expiration)";

        try {
            $this->connection->execute($sql, [$this->name, $this->owner, $expiration]);

            // Verify we actually acquired the lock
            $stmt = $this->connection->query(
                "SELECT owner FROM {$this->table} WHERE `key` = ?",
                [$this->name]
            );

            $result = ($stmt instanceof \PDOStatement)
                ? $stmt->fetchAll(\PDO::FETCH_ASSOC)
                : $stmt;

            return !empty($result) && $result[0]['owner'] === $this->owner;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Release the lock
     */
    public function release(): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE `key` = ? AND owner = ?";

        try {
            $this->connection->execute($sql, [$this->name, $this->owner]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Force release the lock (admin)
     */
    public function forceRelease(): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE `key` = ?";

        try {
            $this->connection->execute($sql, [$this->name]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if the lock is currently acquired
     */
    public function isAcquired(): bool
    {
        $sql = "SELECT owner FROM {$this->table} WHERE `key` = ? AND (expiration IS NULL OR expiration > UNIX_TIMESTAMP())";

        $stmt = $this->connection->query($sql, [$this->name]);

        $result = ($stmt instanceof \PDOStatement)
            ? $stmt->fetchAll(\PDO::FETCH_ASSOC)
            : $stmt;

        return !empty($result);
    }

    /**
     * Generate a unique owner identifier
     */
    protected function generateOwner(): string
    {
        return md5(uniqid('lock', true) . getmypid());
    }
}
