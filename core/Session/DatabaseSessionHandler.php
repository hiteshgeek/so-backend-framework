<?php

namespace Core\Session;

use Core\Database\Connection;
use Core\Security\Encrypter;
use Core\Exceptions\EncryptionException;

/**
 * Database Session Handler
 *
 * Implements PHP's SessionHandlerInterface to store sessions in database.
 * Essential for ERP horizontal scaling across multiple servers.
 *
 * When encryption is enabled, session payloads are encrypted with AES-256-CBC
 * and protected with HMAC-SHA256 before being written to the database.
 * On read, payloads are verified and decrypted. If HMAC verification fails
 * (indicating tampering), the session is destroyed and an empty string is returned.
 */
class DatabaseSessionHandler implements \SessionHandlerInterface
{
    protected Connection $connection;
    protected string $table;
    protected int $lifetime;
    protected ?Encrypter $encrypter;
    protected bool $encrypt;

    /**
     * Create a new database session handler.
     *
     * @param Connection $connection The database connection
     * @param string $table The sessions table name
     * @param int $lifetime Session lifetime in minutes
     * @param Encrypter|null $encrypter The encrypter instance (null if encryption disabled)
     * @param bool $encrypt Whether encryption is enabled
     */
    public function __construct(
        Connection $connection,
        string $table = 'sessions',
        int $lifetime = 120,
        ?Encrypter $encrypter = null,
        bool $encrypt = false
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->lifetime = $lifetime * 60; // Convert minutes to seconds
        $this->encrypter = $encrypter;
        $this->encrypt = $encrypt && $encrypter !== null;
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
     *
     * If encryption is enabled, the payload is decrypted and its HMAC verified.
     * If HMAC verification fails (tampered data), the session is destroyed
     * and an empty string is returned to force a fresh session.
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

        $payload = $result[0]['payload'] ?? '';

        if ($payload === '') {
            return '';
        }

        // Decrypt if encryption is enabled
        if ($this->encrypt) {
            try {
                $payload = $this->encrypter->decrypt($payload);
            } catch (EncryptionException $e) {
                // HMAC mismatch or corrupted payload — treat as tampered
                // Destroy the session to prevent use of compromised data
                $this->destroy($id);
                return '';
            }
        }

        return $payload;
    }

    /**
     * Write session data
     *
     * If encryption is enabled, the payload is encrypted with AES-256-CBC
     * and signed with HMAC-SHA256 before being stored.
     */
    public function write(string $id, string $data): bool
    {
        // Encrypt the payload if encryption is enabled
        $payload = $data;

        if ($this->encrypt) {
            try {
                $payload = $this->encrypter->encrypt($data);
            } catch (EncryptionException $e) {
                return false;
            }
        }

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
                $id, $userId, $ipAddress, $userAgent, $payload, $lastActivity,
                $userId, $ipAddress, $userAgent, $payload, $lastActivity
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

    /**
     * Check if session encryption is currently active.
     *
     * @return bool
     */
    public function isEncrypted(): bool
    {
        return $this->encrypt;
    }
}
