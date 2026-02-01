<?php

/**
 * Localization Configuration
 *
 * Configuration for internationalization (i18n) and localization (l10n).
 * Supports multi-language, multi-currency, and multi-country ERP deployments.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Application Locale
    |--------------------------------------------------------------------------
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    */

    'available_locales' => [
        'en' => 'English',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'es' => 'Español',
        'ar' => 'العربية',
        'zh' => '中文',
        'ja' => '日本語',
        'pt' => 'Português',
        'it' => 'Italiano',
        'ru' => 'Русский',
        'hi' => 'हिन्दी',
        'ko' => '한국어',
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale Detection
    |--------------------------------------------------------------------------
    */

    'detection' => [
        'enabled' => env('LOCALE_DETECTION_ENABLED', true),
        'sources' => ['query', 'user', 'session', 'header', 'default'],
        'query_parameter' => 'locale',
        'session_key' => 'locale',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    */

    'currencies' => [
        'default' => env('DEFAULT_CURRENCY', 'USD'),
        'available' => [
            'USD', 'EUR', 'GBP', 'JPY', 'CNY', 'AED', 'SAR', 'INR',
            'CAD', 'AUD', 'CHF', 'RUB', 'BRL', 'MXN', 'KRW',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Date/Time Formatting
    |--------------------------------------------------------------------------
    */

    'datetime' => [
        'timezone' => env('APP_TIMEZONE', 'UTC'),
        'formats' => [
            'date' => [
                'short' => 'm/d/Y',
                'medium' => 'M j, Y',
                'long' => 'F j, Y',
                'full' => 'l, F j, Y',
            ],
            'time' => [
                'short' => 'g:i A',
                'medium' => 'g:i:s A',
                'long' => 'g:i:s A T',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | RTL Locales
    |--------------------------------------------------------------------------
    */

    'rtl_locales' => ['ar', 'he', 'fa', 'ur'],
];
