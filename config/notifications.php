<?php

/**
 * Notification Configuration
 *
 * Configure notification channels and behavior
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Notification Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification channel that will be used
    | to send notifications when no specific channel is defined.
    |
    */
    'default' => env('NOTIFICATION_CHANNEL', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Configure available notification channels.
    |
    */
    'channels' => [
        'database' => [
            'driver' => 'database',
            'table' => 'notifications',
        ],

        'mail' => [
            'driver' => 'mail',
            // Mail configuration would go here
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Queue
    |--------------------------------------------------------------------------
    |
    | Should notifications be queued by default?
    |
    */
    'queue_notifications' => env('QUEUE_NOTIFICATIONS', false),

    /*
    |--------------------------------------------------------------------------
    | Prune Notifications
    |--------------------------------------------------------------------------
    |
    | Automatically delete read notifications older than X days.
    | Set to null to keep all notifications.
    |
    */
    'prune_read_after_days' => env('NOTIFICATION_PRUNE_DAYS', 30),
];
