<?php

/**
 * Mail Configuration
 *
 * Configure mail transport and default sender settings
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer used by the application.
    | Currently only SMTP is supported via native socket connection.
    |
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Default From Address
    |--------------------------------------------------------------------------
    |
    | The default sender address and name used for all outgoing emails
    | unless explicitly overridden per message.
    |
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'SO Framework')),
    ],

    /*
    |--------------------------------------------------------------------------
    | SMTP Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the SMTP server connection details. TLS encryption is
    | recommended for production environments.
    |
    */
    'smtp' => [
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'timeout' => 30,
    ],
];
