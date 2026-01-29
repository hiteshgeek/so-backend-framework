<?php

/**
 * Security Configuration
 *
 * Configure CSRF protection, JWT authentication, and rate limiting
 */
return [
    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    | Enable/disable CSRF protection and configure excluded routes
    */
    'csrf' => [
        // Enable CSRF protection globally
        'enabled' => env('CSRF_ENABLED', true),

        // Routes excluded from CSRF verification (wildcard patterns supported)
        'except' => [
            'api/*',          // All API routes
            'webhooks/*',     // Webhook endpoints
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication
    |--------------------------------------------------------------------------
    |
    | Configure JSON Web Token settings for stateless authentication
    */
    'jwt' => [
        // Secret key for signing tokens (MUST be set in .env)
        'secret' => env('JWT_SECRET', 'test-secret-key-change-in-production'),

        // Algorithm for signing (only HS256 supported)
        'algorithm' => env('JWT_ALGORITHM', 'HS256'),

        // Default token time-to-live in seconds (1 hour)
        'ttl' => env('JWT_TTL', 3600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for API endpoints
    */
    'rate_limit' => [
        // Enable rate limiting globally
        'enabled' => env('RATE_LIMIT_ENABLED', true),

        // Default rate limit: "requests,minutes"
        // Example: "60,1" = 60 requests per 1 minute
        'default' => env('RATE_LIMIT_DEFAULT', '60,1'),

        // Store rate limit data in cache
        'cache_prefix' => 'rate_limit:',
    ],
];
