<?php

namespace Core\Session;

use Core\Database\Connection;

/**
 * Database Session Handler
 *
 * Implements PHP's SessionHandlerInterface to store sessions in database
 * Essential for ERP horizontal scaling across multiple servers
 */
class DatabaseSessionHandler implements \SessionHandlerInterface
{
    protected Connection $connection;
    protected string $table;
    protected int $lifetime;

    public function __construct(Connection $connection, string $table = 'sessions', int $lifetime = 120)
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->lifetime = $lifetime * 60; // Convert minutes to seconds
    }

    /**
     * Open session
     */
    public function open(string $path, string $name): bool
    {
        return true;
    }

    /**
     * Close session
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * Read session data
     */
    public function read(string $id): string|false
    {
        $sql = "SELECT payload FROM {$this->table} WHERE id = ? AND last_activity >= ?";
        $expiration = time() - $this->lifetime;

        $stmt = $this->connection->query($sql, [$id, $expiration]);

        $result = ($stmt instanceof \PDOStatement)
            ? $stmt->fetchAll(\PDO::FETCH_ASSOC)
            : $stmt;

        if (empty($result)) {
            return '';
        }

        return $result[0]['payload'] ?? '';
    }

    /**
     * Write session data
     */
    public function write(string $id, string $data): bool
    {
        $userId = $_SESSION['user_id'] ?? null;
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $lastActivity = time();

        $sql = "INSERT INTO {$this->table} (id, user_id, ip_address, user_agent, payload, last_activity)
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    user_id = ?,
                    ip_address = ?,
                    user_agent = ?,
                    payload = ?,
                    last_activity = ?";

        try {
            $this->connection->execute($sql, [
                $id, $userId, $ipAddress, $userAgent, $data, $lastActivity,
                $userId, $ipAddress, $userAgent, $data, $lastActivity
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Destroy a session
     */
    public function destroy(string $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->connection->execute($sql, [$id]);
        return true;
    }

    /**
     * Garbage collection - remove expired sessions
     */
    public function gc(int $max_lifetime): int|false
    {
        $expiration = time() - $max_lifetime;
        $sql = "DELETE FROM {$this->table} WHERE last_activity < ?";
        return $this->connection->execute($sql, [$expiration]);
    }
}
