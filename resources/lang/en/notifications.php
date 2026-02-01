<?php

/**
 * English Notification Templates
 *
 * Templates for notification messages sent via database, email, SMS, etc.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Welcome Notification
    |--------------------------------------------------------------------------
    */

    'welcome' => [
        'title' => 'Welcome to the System!',
        'message' => 'Hello :name, welcome to our ERP system!',
        'action' => 'Get Started',
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Notifications
    |--------------------------------------------------------------------------
    */

    'order' => [
        'created' => [
            'title' => 'Order Placed',
            'message' => 'Your order #:order_id has been placed successfully.',
            'action' => 'View Order',
        ],
        'approved' => [
            'title' => 'Order Approved',
            'message' => 'Your order #:order_id has been approved.',
            'action' => 'View Order',
        ],
        'shipped' => [
            'title' => 'Order Shipped',
            'message' => 'Your order #:order_id has been shipped.',
            'action' => 'Track Shipment',
        ],
        'delivered' => [
            'title' => 'Order Delivered',
            'message' => 'Your order #:order_id has been delivered.',
            'action' => 'View Order',
        ],
        'cancelled' => [
            'title' => 'Order Cancelled',
            'message' => 'Your order #:order_id has been cancelled.',
            'action' => 'View Order',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Notifications
    |--------------------------------------------------------------------------
    */

    'payment' => [
        'received' => [
            'title' => 'Payment Received',
            'message' => 'We have received your payment of :amount for order #:order_id.',
            'action' => 'View Receipt',
        ],
        'failed' => [
            'title' => 'Payment Failed',
            'message' => 'Payment failed for order #:order_id. Please try again.',
            'action' => 'Retry Payment',
        ],
        'refunded' => [
            'title' => 'Payment Refunded',
            'message' => 'Your payment of :amount for order #:order_id has been refunded.',
            'action' => 'View Details',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Account Notifications
    |--------------------------------------------------------------------------
    */

    'account' => [
        'created' => [
            'title' => 'Account Created',
            'message' => 'Your account has been created successfully.',
            'action' => 'Login Now',
        ],
        'updated' => [
            'title' => 'Account Updated',
            'message' => 'Your account information has been updated.',
            'action' => 'View Profile',
        ],
        'password_changed' => [
            'title' => 'Password Changed',
            'message' => 'Your password has been changed successfully.',
            'action' => null,
        ],
        'login_alert' => [
            'title' => 'New Login Detected',
            'message' => 'A new login was detected on your account from :location at :time.',
            'action' => 'Review Activity',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | System Notifications
    |--------------------------------------------------------------------------
    */

    'system' => [
        'maintenance' => [
            'title' => 'Scheduled Maintenance',
            'message' => 'The system will be under maintenance from :start to :end.',
            'action' => null,
        ],
        'update' => [
            'title' => 'System Update',
            'message' => 'A new system update is available.',
            'action' => 'Learn More',
        ],
    ],
];
