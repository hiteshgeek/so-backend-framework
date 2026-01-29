<?php

/**
 * Cache Configuration
 *
 * Configure cache stores and behavior
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store used by the application.
    | For ERP systems, 'database' is recommended for sharing across servers.
    |
    */
    'default' => env('CACHE_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Configure different cache stores.
    |
    */
    'stores' => [
        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM or database based store, there might be other
    | applications using the same cache. Set a prefix to avoid collisions.
    |
    */
    'prefix' => env('CACHE_PREFIX', 'so_cache'),
];
