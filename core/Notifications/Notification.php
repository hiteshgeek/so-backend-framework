<?php

namespace Core\Notifications;

/**
 * Notification Base Class
 *
 * Abstract base class for all notifications
 * Essential for ERP workflow communication (approvals, alerts, tasks)
 */
abstract class Notification
{
    /**
     * Unique notification ID
     */
    public string $id;

    /**
     * Get the notification's delivery channels
     *
     * @return array Array of channel names (e.g., ['database', 'mail'])
     */
    abstract public function via(): array;

    /**
     * Get the array representation of the notification for database storage
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return $this->toArray($notifiable);
    }

    /**
     * Get the array representation of the notification
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [];
    }

    /**
     * Generate a unique ID for the notification
     */
    protected function generateId(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Get notification ID (generate if not set)
     */
    public function getId(): string
    {
        if (!isset($this->id)) {
            $this->id = $this->generateId();
        }

        return $this->id;
    }
}
