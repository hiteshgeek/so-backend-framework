<?php

/**
 * Profiler Configuration
 *
 * Configure application profiling and debugging features.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Profiler Enabled
    |--------------------------------------------------------------------------
    |
    | Enable the profiler to track queries, execution time, and memory usage.
    | Should be enabled in development and disabled in production.
    |
    */
    'enabled' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Show Profiler Bar
    |--------------------------------------------------------------------------
    |
    | Display the profiler toolbar at the bottom of pages.
    | Only works when profiler is enabled.
    |
    */
    'show_toolbar' => env('PROFILER_TOOLBAR', true),

    /*
    |--------------------------------------------------------------------------
    | Slow Query Threshold
    |--------------------------------------------------------------------------
    |
    | Queries taking longer than this threshold (in milliseconds) will be
    | highlighted in the profiler.
    |
    */
    'slow_query_threshold' => env('PROFILER_SLOW_QUERY', 100),

    /*
    |--------------------------------------------------------------------------
    | Query Count Warning
    |--------------------------------------------------------------------------
    |
    | If query count exceeds this number, a warning will be displayed.
    | Helps identify N+1 query problems.
    |
    */
    'query_count_warning' => env('PROFILER_QUERY_WARNING', 20),

    /*
    |--------------------------------------------------------------------------
    | Memory Limit Warning
    |--------------------------------------------------------------------------
    |
    | If memory usage exceeds this percentage of the PHP memory limit,
    | a warning will be displayed.
    |
    */
    'memory_warning_percent' => env('PROFILER_MEMORY_WARNING', 80),

    /*
    |--------------------------------------------------------------------------
    | Exclude Paths
    |--------------------------------------------------------------------------
    |
    | Paths that should not be profiled.
    |
    */
    'exclude_paths' => [
        '/profiler',
        '/debug',
        '/_healthcheck',
    ],

    /*
    |--------------------------------------------------------------------------
    | Track Timeline Events
    |--------------------------------------------------------------------------
    |
    | Automatically track key framework events in the timeline.
    |
    */
    'track_events' => true,

    /*
    |--------------------------------------------------------------------------
    | Collect Data
    |--------------------------------------------------------------------------
    |
    | Configure what data should be collected by the profiler.
    |
    */
    'collect' => [
        'queries' => true,         // Database queries
        'timeline' => true,        // Execution timeline
        'memory' => true,          // Memory usage
        'route' => true,           // Route information
        'session' => true,         // Session data
        'request' => true,         // Request data
    ],
];
