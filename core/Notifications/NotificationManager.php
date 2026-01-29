<?php

namespace Core\Notifications;

/**
 * Notification Manager
 *
 * Dispatches notifications to appropriate channels
 */
class NotificationManager
{
    protected array $channels = [];

    /**
     * Register a notification channel
     */
    public function registerChannel(string $name, $channel): void
    {
        $this->channels[$name] = $channel;
    }

    /**
     * Get a channel by name
     */
    public function channel(string $name)
    {
        if (!isset($this->channels[$name])) {
            throw new \InvalidArgumentException("Notification channel [{$name}] not found.");
        }

        return $this->channels[$name];
    }

    /**
     * Send a notification to a notifiable entity
     *
     * @param mixed $notifiable The model receiving the notification (e.g., User)
     * @param Notification $notification The notification to send
     */
    public function send($notifiable, Notification $notification): void
    {
        $channels = $notification->via();

        foreach ($channels as $channelName) {
            $channel = $this->channel($channelName);
            $channel->send($notifiable, $notification);
        }
    }

    /**
     * Send a notification to multiple notifiable entities
     */
    public function sendMultiple(array $notifiables, Notification $notification): void
    {
        foreach ($notifiables as $notifiable) {
            $this->send($notifiable, $notification);
        }
    }
}
