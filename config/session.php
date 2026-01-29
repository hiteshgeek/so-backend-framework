<?php

/**
 * Session Configuration
 *
 * Configure session behavior and storage
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session driver used by the application.
    | For ERP systems with multiple servers, 'database' is required.
    |
    */
    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime of sessions in minutes.
    |
    */
    'lifetime' => env('SESSION_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | Table name for database session storage.
    |
    */
    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | The name of the session cookie.
    |
    */
    'cookie' => env('SESSION_COOKIE', 'so_session'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookie
    |--------------------------------------------------------------------------
    |
    | Set to true to only send cookie over HTTPS.
    |
    */
    'secure' => env('SESSION_SECURE_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Only Cookie
    |--------------------------------------------------------------------------
    |
    | Set to true to prevent JavaScript access to session cookie.
    |
    */
    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same Site Cookie
    |--------------------------------------------------------------------------
    |
    | Options: lax, strict, none
    |
    */
    'same_site' => 'lax',

    /*
    |--------------------------------------------------------------------------
    | Session Garbage Collection
    |--------------------------------------------------------------------------
    |
    | Lottery for triggering garbage collection [chance, total].
    | [2, 100] means 2% chance.
    |
    */
    'lottery' => [2, 100],
];
