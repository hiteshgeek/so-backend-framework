<?php

/**
 * API Configuration
 *
 * Configure API settings including versioning, context detection, and permissions
 */
return [
    /*
    |--------------------------------------------------------------------------
    | API Versioning
    |--------------------------------------------------------------------------
    */

    // Default API version when none is specified
    'default_version' => env('API_DEFAULT_VERSION', 'v1'),

    // List of supported API versions
    'supported_versions' => ['v1', 'v2'],

    // List of deprecated versions (still functional, but with warnings)
    'deprecated_versions' => [],

    // API route prefix (e.g., "/api")
    'prefix' => env('API_PREFIX', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Internal API Layer
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | Signature Authentication
    |--------------------------------------------------------------------------
    |
    | Secret key for signature-based authentication (cron jobs, internal services)
    */
    'signature_secret' => env('INTERNAL_API_SIGNATURE_KEY', 'change-this-in-production'),

    // Maximum age of signature timestamp (in seconds)
    'signature_max_age' => env('INTERNAL_API_SIGNATURE_MAX_AGE', 300), // 5 minutes

    /*
    |--------------------------------------------------------------------------
    | Context-based Permissions
    |--------------------------------------------------------------------------
    |
    | Define permissions for each request context
    | Supports wildcard notation (e.g., 'users.*' = all user operations)
    */
    'permissions' => [
        // Web context - Full UI access
        'web' => [
            'users.*',
            'posts.*',
            'comments.*',
            'settings.*',
            'dashboard.*',
            'reports.*',
        ],

        // Mobile app context - Limited operations
        'mobile' => [
            'users.read',
            'users.update',      // Own profile only
            'posts.read',
            'posts.create',
            'posts.update',      // Own posts only
            'posts.delete',      // Own posts only
            'comments.read',
            'comments.create',
            'comments.update',   // Own comments only
            'comments.delete',   // Own comments only
            'notifications.read',
        ],

        // Cron/CLI context - System operations
        'cron' => [
            'system.*',
            'reports.generate',
            'cleanup.*',
            'notifications.send',
            'cache.clear',
            'sessions.cleanup',
            'activity.prune',
        ],

        // External API context - Read-only by default
        'external' => [
            'users.read',
            'posts.read',
            'comments.read',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limits per Context
    |--------------------------------------------------------------------------
    |
    | Define different rate limits for each context
    | Format: "requests,minutes"
    */
    'rate_limits' => [
        'web' => '100,1',      // 100 requests per minute
        'mobile' => '60,1',    // 60 requests per minute
        'cron' => null,        // No rate limit for cron jobs
        'external' => '30,1',  // 30 requests per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | API Client Settings
    |--------------------------------------------------------------------------
    */
    'client' => [
        // Default timeout for API calls (seconds)
        'timeout' => env('API_CLIENT_TIMEOUT', 30),

        // Retry failed requests
        'retry_attempts' => env('API_CLIENT_RETRY', 3),

        // Retry delay (seconds)
        'retry_delay' => 1,
    ],
];
