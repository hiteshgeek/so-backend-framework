<?php

/**
 * Activity Logging Configuration
 *
 * Controls the behavior of the activity logging system
 * Essential for ERP compliance and audit trails
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Activity Logging Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable activity logging globally.
    | When disabled, no activities will be logged.
    |
    */
    'enabled' => env('ACTIVITY_LOG_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Default Log Name
    |--------------------------------------------------------------------------
    |
    | The default log name to use when none is specified.
    | You can organize logs by different names (e.g., 'user', 'order', 'invoice')
    |
    */
    'log_name' => env('ACTIVITY_LOG_NAME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Delete Records Older Than (Days)
    |--------------------------------------------------------------------------
    |
    | Automatically delete activity log records older than this many days.
    | Set to 0 to keep records forever.
    | For ERP systems, consider keeping logs for at least 365 days (1 year)
    | or longer for compliance purposes (e.g., 7 years for financial records).
    |
    */
    'delete_records_older_than_days' => env('ACTIVITY_LOG_RETENTION_DAYS', 365),

    /*
    |--------------------------------------------------------------------------
    | Batch UUID Generation
    |--------------------------------------------------------------------------
    |
    | Enable automatic batch UUID generation for grouping related activities.
    | Useful for tracking bulk operations or multi-step workflows.
    |
    */
    'enable_batch_tracking' => env('ACTIVITY_LOG_BATCH_TRACKING', false),
];
