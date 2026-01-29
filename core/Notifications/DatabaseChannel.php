<?php

namespace Core\Notifications;

use Core\Database\Connection;

/**
 * Database Notification Channel
 *
 * Stores notifications in the database for in-app display
 */
class DatabaseChannel
{
    protected Connection $connection;
    protected string $table = 'notifications';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Send the given notification
     *
     * @param mixed $notifiable The model receiving the notification
     * @param Notification $notification The notification to send
     */
    public function send($notifiable, Notification $notification): void
    {
        try {
            $data = $notification->toDatabase($notifiable);

            $sql = "INSERT INTO {$this->table} (id, type, notifiable_type, notifiable_id, data, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $now = date('Y-m-d H:i:s');

            $this->connection->execute($sql, [
                $notification->getId(),
                get_class($notification),
                get_class($notifiable),
                $notifiable->id,
                json_encode($data),
                $now,
                $now,
            ]);
        } catch (\Exception $e) {
            // Log error if logger available
            if (function_exists('logger')) {
                logger()->error('Notification failed', [
                    'notifiable' => get_class($notifiable),
                    'notification' => get_class($notification),
                    'error' => $e->getMessage()
                ]);
            }
            // Fail silently - notifications should not break the application
        }
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(string $notificationId): void
    {
        try {
            $sql = "UPDATE {$this->table} SET read_at = ? WHERE id = ?";
            $this->connection->execute($sql, [date('Y-m-d H:i:s'), $notificationId]);
        } catch (\Exception $e) {
            // Fail silently
        }
    }

    /**
     * Mark all notifications as read for a notifiable
     */
    public function markAllAsRead(string $notifiableType, int $notifiableId): void
    {
        try {
            $sql = "UPDATE {$this->table}
                    SET read_at = ?
                    WHERE notifiable_type = ?
                    AND notifiable_id = ?
                    AND read_at IS NULL";

            $this->connection->execute($sql, [
                date('Y-m-d H:i:s'),
                $notifiableType,
                $notifiableId,
            ]);
        } catch (\Exception $e) {
            // Fail silently
        }
    }

    /**
     * Delete a notification
     */
    public function delete(string $notificationId): void
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $this->connection->execute($sql, [$notificationId]);
        } catch (\Exception $e) {
            // Fail silently
        }
    }

    /**
     * Get all notifications for a notifiable
     */
    public function getNotifications(string $notifiableType, int $notifiableId): array
    {
        try {
            $sql = "SELECT * FROM {$this->table}
                    WHERE notifiable_type = ? AND notifiable_id = ?
                    ORDER BY created_at DESC";

            $stmt = $this->connection->query($sql, [$notifiableType, $notifiableId]);

            if ($stmt instanceof \PDOStatement) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $stmt;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get unread notifications for a notifiable
     */
    public function getUnreadNotifications(string $notifiableType, int $notifiableId): array
    {
        try {
            $sql = "SELECT * FROM {$this->table}
                    WHERE notifiable_type = ?
                    AND notifiable_id = ?
                    AND read_at IS NULL
                    ORDER BY created_at DESC";

            $stmt = $this->connection->query($sql, [$notifiableType, $notifiableId]);

            if ($stmt instanceof \PDOStatement) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $stmt;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get count of unread notifications
     */
    public function getUnreadCount(string $notifiableType, int $notifiableId): int
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table}
                    WHERE notifiable_type = ?
                    AND notifiable_id = ?
                    AND read_at IS NULL";

            $stmt = $this->connection->query($sql, [$notifiableType, $notifiableId]);

            if ($stmt instanceof \PDOStatement) {
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return (int)($result[0]['count'] ?? 0);
            }

            return (int)($stmt[0]['count'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
