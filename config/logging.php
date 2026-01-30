<?php

/**
 * Logging Configuration
 *
 * Configure log channels, levels, and retention policies.
 * Each channel can use a different driver (single, daily, syslog, stderr).
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | The default channel used by the logger() helper function.
    */
    'default' => env('LOG_CHANNEL', 'daily'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Available channels for logging. Each channel has its own driver and config.
    |
    | Supported drivers: "single", "daily", "syslog", "stderr"
    | Supported levels: "emergency", "alert", "critical", "error",
    |                   "warning", "notice", "info", "debug"
    */
    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/app.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => LOG_USER,
            'ident' => env('APP_NAME', 'so-framework'),
        ],

        'stderr' => [
            'driver' => 'stderr',
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],
];
