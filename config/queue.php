<?php

/**
 * Queue Configuration
 *
 * Configure queue connections and behavior
 * Essential for background job processing in ERP systems
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection
    |--------------------------------------------------------------------------
    |
    | The default queue connection to use.
    | For production ERP systems, use 'database' for reliability.
    | Use 'sync' for development/testing to execute jobs immediately.
    |
    */
    'default' => env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Configure different queue connections.
    |
    */
    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90, // Seconds before a reserved job is released
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | Configuration for storing failed jobs.
    |
    */
    'failed' => [
        'driver' => 'database',
        'table' => 'failed_jobs',
    ],
];
