<?php

namespace Core\Notifications;

/**
 * Notifiable Trait
 *
 * Add this trait to models that should receive notifications
 * Essential for ERP workflow communication (approvals, alerts, tasks)
 *
 * Usage:
 * class User extends Model {
 *     use Notifiable;
 * }
 *
 * Then:
 * $user->notify(new OrderApprovalNotification($order));
 */
trait Notifiable
{
    /**
     * Send a notification to this notifiable entity
     */
    public function notify(Notification $notification): void
    {
        app('notification')->send($this, $notification);
    }

    /**
     * Get all notifications for this entity
     */
    public function notifications(): array
    {
        $channel = app('notification')->channel('database');
        return $channel->getNotifications(get_class($this), $this->id);
    }

    /**
     * Get unread notifications
     */
    public function unreadNotifications(): array
    {
        $channel = app('notification')->channel('database');
        return $channel->getUnreadNotifications(get_class($this), $this->id);
    }

    /**
     * Get count of unread notifications
     */
    public function unreadNotificationsCount(): int
    {
        $channel = app('notification')->channel('database');
        return $channel->getUnreadCount(get_class($this), $this->id);
    }

    /**
     * Mark a notification as read
     */
    public function markNotificationAsRead(string $notificationId): void
    {
        $channel = app('notification')->channel('database');
        $channel->markAsRead($notificationId);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead(): void
    {
        $channel = app('notification')->channel('database');
        $channel->markAllAsRead(get_class($this), $this->id);
    }

    /**
     * Delete a notification
     */
    public function deleteNotification(string $notificationId): void
    {
        $channel = app('notification')->channel('database');
        $channel->delete($notificationId);
    }
}
