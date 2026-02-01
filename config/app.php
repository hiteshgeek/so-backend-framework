<?php

return [
    'name' => env('APP_NAME', 'SO Backend Framework'),
    'version' => env('APP_VERSION', '1.0.0'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'key' => env('APP_KEY'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'available_locales' => ['en', 'fr', 'de', 'es', 'ar', 'zh'],

    // Asset management
    'asset_url' => env('ASSET_URL', ''),              // Empty = use app.url. Set CDN: 'https://cdn.example.com'
    'asset_versioning' => env('ASSET_VERSIONING', true), // Cache busting via file modification time

    'providers' => [
        // Localization system for multi-country ERP support
        \Core\Localization\LocaleServiceProvider::class,

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

        // Mail system for sending emails
        \Core\Mail\MailServiceProvider::class,
    ],
];
