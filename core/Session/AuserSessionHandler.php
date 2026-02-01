<?php

namespace Core\Session;

use Core\Database\Connection;
use Core\Security\Encrypter;
use Core\Exceptions\EncryptionException;
use App\Constants\DatabaseTables;

/**
 * Custom Session Handler for existing auser_session table
 *
 * Adapts the DatabaseSessionHandler to work with existing auser_session table structure
 */
class AuserSessionHandler implements \SessionHandlerInterface
{
    protected Connection $connection;
    protected string $table;
    protected int $lifetime;
    protected ?Encrypter $encrypter;
    protected bool $encrypt;

    public function __construct(
        Connection $connection,
        string $table = DatabaseTables::AUSER_SESSION,
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

    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    /**
     * Read session data from auser_session table
     * Columns: sid, data, last_logged_in
     */
    public function read(string $id): string|false
    {
        $sql = "SELECT data FROM {$this->table} WHERE sid = ? AND last_logged_in >= FROM_UNIXTIME(?)";
        $expiration = time() - $this->lifetime;

        $stmt = $this->connection->query($sql, [$id, $expiration]);

        $result = ($stmt instanceof \PDOStatement)
            ? $stmt->fetchAll(\PDO::FETCH_ASSOC)
            : $stmt;

        if (empty($result)) {
            return '';
        }

        $payload = $result[0]['data'] ?? '';

        if ($payload === '') {
            return '';
        }

        // Decrypt if encryption is enabled
        if ($this->encrypt) {
            try {
                $payload = $this->encrypter->decrypt($payload);
            } catch (EncryptionException $e) {
                error_log("Session decryption failed: " . $e->getMessage());
                $this->destroy($id);
                return '';
            }
        }

        return $payload;
    }

    /**
     * Write session data to auser_session table
     * Columns: sid, uid, data, ipaddress, ussid, company_id, last_logged_in, updated_ts
     */
    public function write(string $id, string $data): bool
    {
        // Parse session data to get user ID
        $sessionData = $this->unserializeSessionData($data);
        $userId = $sessionData['user_id'] ?? $sessionData['auth_user_id'] ?? null;

        // Debug logging
        error_log("Session write - ID: $id, UserID: " . ($userId ?? 'null'));
        error_log("Session data: " . print_r($sessionData, true));

        // Only persist to database for logged-in users
        // auser_session has FK to auser, so anonymous sessions can't be stored
        if ($userId === null || $userId <= 0) {
            error_log("Session write skipped - anonymous user");
            return true; // Let PHP handle anonymous sessions with file storage
        }

        error_log("Session write - persisting to database for user $userId");

        // Encrypt the payload if encryption is enabled
        $payload = $data;

        if ($this->encrypt) {
            try {
                $payload = $this->encrypter->encrypt($data);
            } catch (EncryptionException $e) {
                return false;
            }
        }

        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $macAddr = '';  // Not tracking MAC address
        $companyId = $sessionData['company_id'] ?? 2018;  // Default company ID

        // Check if session exists
        $checkSql = "SELECT usid FROM {$this->table} WHERE sid = ?";
        $checkStmt = $this->connection->query($checkSql, [$id]);
        $exists = ($checkStmt instanceof \PDOStatement)
            ? $checkStmt->fetch(\PDO::FETCH_ASSOC)
            : null;

        try {
            if ($exists) {
                // Update existing session
                $sql = "UPDATE {$this->table}
                        SET uid = ?,
                            data = ?,
                            ipaddress = ?,
                            updated_ts = NOW(),
                            last_logged_in = NOW()
                        WHERE sid = ?";

                $this->connection->execute($sql, [
                    $userId,
                    $payload,
                    $ipAddress,
                    $id
                ]);
            } else {
                // Insert new session
                $sql = "INSERT INTO {$this->table}
                        (uid, sid, data, ipaddress, mac_addr, ussid, company_id, login_type, fcmskid, outlet_chkid, licid, last_logged_bit, fcm_token)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $this->connection->execute($sql, [
                    $userId,
                    $id,
                    $payload,
                    $ipAddress,
                    $macAddr,
                    1,  // ussid - active session status
                    $companyId,
                    1,  // login_type - default
                    0,  // fcmskid - default
                    0,  // outlet_chkid - default
                    0,  // licid - default
                    1,  // last_logged_bit - default
                    ''  // fcm_token - empty for web sessions
                ]);
            }
            return true;
        } catch (\Exception $e) {
            error_log("Session write error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Destroy a session
     */
    public function destroy(string $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE sid = ?";
        $this->connection->execute($sql, [$id]);
        return true;
    }

    /**
     * Garbage collection - remove expired sessions
     */
    public function gc(int $max_lifetime): int|false
    {
        $expiration = time() - $max_lifetime;
        $sql = "DELETE FROM {$this->table} WHERE UNIX_TIMESTAMP(last_logged_in) < ?";
        return $this->connection->execute($sql, [$expiration]);
    }

    public function isEncrypted(): bool
    {
        return $this->encrypt;
    }

    /**
     * Unserialize PHP session data
     *
     * @param string $data Serialized session data
     * @return array Unserialized session data
     */
    protected function unserializeSessionData(string $data): array
    {
        if (empty($data)) {
            return [];
        }

        $result = [];

        // Use PHP's session_decode in a temporary session
        $oldSession = $_SESSION ?? [];
        $_SESSION = [];

        if (@session_decode($data)) {
            $result = $_SESSION;
        } else {
            // Fallback: manual parsing for testing/when session not available
            // Format: key|type:value; where type can be i: (int), s:length:"value" (string), etc.
            $result = $this->manualSessionParse($data);
        }

        $_SESSION = $oldSession;

        return $result;
    }

    /**
     * Manual session data parser (fallback when session_decode not available)
     */
    protected function manualSessionParse(string $data): array
    {
        $result = [];

        // Split by semicolons to get individual entries
        $entries = explode(';', $data);

        foreach ($entries as $entry) {
            if (empty(trim($entry))) {
                continue;
            }

            // Format: key|type:value
            if (preg_match('/^([^|]+)\|([^:]+):(.+)$/', $entry, $matches)) {
                $key = $matches[1];
                $type = $matches[2];
                $value = $matches[3];

                if ($type === 'i') {
                    // Integer
                    $result[$key] = (int)$value;
                } elseif (preg_match('/^s:(\d+):"(.+)"$/', $type . ':' . $value, $strMatch)) {
                    // String with length
                    $result[$key] = $strMatch[2];
                }
            }
        }

        return $result;
    }
}
