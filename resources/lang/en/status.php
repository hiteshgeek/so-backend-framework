<?php

/**
 * English Status Labels
 *
 * Status labels for various models and entities.
 * Used for translating numeric status codes to human-readable text.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Order Status Labels
    |--------------------------------------------------------------------------
    */

    'order' => [
        '1' => 'Pending',
        '2' => 'Processing',
        '3' => 'Shipped',
        '4' => 'Delivered',
        '5' => 'Cancelled',
        '6' => 'Refunded',
        '7' => 'On Hold',
        '8' => 'Failed',
        '9' => 'Completed',
    ],

    /*
    |--------------------------------------------------------------------------
    | User Status Labels
    |--------------------------------------------------------------------------
    */

    'user' => [
        '1' => 'Active',
        '2' => 'Inactive',
        '3' => 'Suspended',
        '4' => 'Pending',
        '5' => 'Banned',
        '6' => 'Deleted',
    ],

    /*
    |--------------------------------------------------------------------------
    | Product Status Labels
    |--------------------------------------------------------------------------
    */

    'product' => [
        '1' => 'Available',
        '2' => 'Out of Stock',
        '3' => 'Discontinued',
        '4' => 'Coming Soon',
        '5' => 'Pre-Order',
        '6' => 'Draft',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Status Labels
    |--------------------------------------------------------------------------
    */

    'payment' => [
        '1' => 'Pending',
        '2' => 'Authorized',
        '3' => 'Paid',
        '4' => 'Failed',
        '5' => 'Refunded',
        '6' => 'Partially Refunded',
        '7' => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Shipping Status Labels
    |--------------------------------------------------------------------------
    */

    'shipping' => [
        '1' => 'Not Shipped',
        '2' => 'Preparing',
        '3' => 'Shipped',
        '4' => 'In Transit',
        '5' => 'Out for Delivery',
        '6' => 'Delivered',
        '7' => 'Returned',
        '8' => 'Failed Delivery',
    ],

    /*
    |--------------------------------------------------------------------------
    | Generic Status
    |--------------------------------------------------------------------------
    */

    'active' => 'Active',
    'inactive' => 'Inactive',
    'enabled' => 'Enabled',
    'disabled' => 'Disabled',
    'published' => 'Published',
    'draft' => 'Draft',
    'archived' => 'Archived',
    'unknown' => 'Unknown',
];
