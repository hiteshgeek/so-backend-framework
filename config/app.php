<?php

return [
    'name' => env('APP_NAME', 'SO Backend Framework'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'key' => env('APP_KEY'),
    'timezone' => 'UTC',
    'locale' => 'en',

    'providers' => [
        // Activity logging for audit trails (ERP compliance)
        \App\Providers\ActivityLogServiceProvider::class,

        // Queue system for background job processing
        \App\Providers\QueueServiceProvider::class,

        // Notification system for workflow communication
        \App\Providers\NotificationServiceProvider::class,

        // Cache system for performance optimization
        \App\Providers\CacheServiceProvider::class,

        // Session system for horizontal scaling
        \App\Providers\SessionServiceProvider::class,
    ],
];
