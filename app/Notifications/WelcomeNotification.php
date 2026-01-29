<?php

namespace App\Notifications;

use Core\Notifications\Notification;

/**
 * Welcome Notification
 *
 * Sample notification sent to new users
 */
class WelcomeNotification extends Notification
{
    protected string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Welcome to the System!',
            'message' => "Hello {$this->userName}, welcome to our ERP system!",
            'action_url' => '/dashboard',
            'action_text' => 'Go to Dashboard',
            'type' => 'welcome',
        ];
    }
}
