<?php

/**
 * Authentication Configuration
 *
 * Configure authentication behavior, session management, and security features
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Login Throttle (Brute Force Protection)
    |--------------------------------------------------------------------------
    |
    | Configure account lockout after too many failed login attempts.
    | This protects against brute force attacks on user accounts.
    |
    */
    'login_throttle' => [
        // Enable/disable login throttling
        'enabled' => env('AUTH_THROTTLE_ENABLED', true),

        // Maximum failed attempts before lockout
        'max_attempts' => env('AUTH_THROTTLE_MAX_ATTEMPTS', 5),

        // Lockout duration in minutes
        'decay_minutes' => env('AUTH_THROTTLE_DECAY_MINUTES', 15),
    ],

    /*
    |--------------------------------------------------------------------------
    | Remember Me Duration
    |--------------------------------------------------------------------------
    |
    | Duration in seconds for the "remember me" cookie.
    | Default: 2592000 seconds (30 days)
    |
    */
    'remember_duration' => env('AUTH_REMEMBER_DURATION', 2592000),

    /*
    |--------------------------------------------------------------------------
    | Session Key
    |--------------------------------------------------------------------------
    |
    | The session key used to store the authenticated user ID.
    |
    */
    'session_key' => 'auth_user_id',

    /*
    |--------------------------------------------------------------------------
    | Remember Token Cookie Name
    |--------------------------------------------------------------------------
    |
    | The cookie name for the "remember me" token.
    |
    */
    'remember_cookie' => 'remember_token',
];
