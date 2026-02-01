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
    |
    | Languages that use Right-to-Left text direction.
    | Used by LocaleManager::isRtl() and is_rtl() helper.
    |
    */

    'rtl_locales' => ['ar', 'he', 'fa', 'ur', 'ps', 'ku', 'yi', 'dv', 'sd', 'ug'],

    /*
    |--------------------------------------------------------------------------
    | Missing Translation Handling
    |--------------------------------------------------------------------------
    |
    | Configure how missing translations are logged and displayed.
    |
    */

    'log_missing' => env('LOG_MISSING_TRANSLATIONS', true),

    'missing_log_channel' => 'translations',

    'missing_log_file' => storage_path('logs/missing_translations.json'),

    'missing_marker' => '[[%s]]', // How to display missing keys in debug mode

    'missing_max_entries' => 1000, // Maximum entries to keep in memory

    /*
    |--------------------------------------------------------------------------
    | ICU MessageFormat
    |--------------------------------------------------------------------------
    |
    | Enable advanced ICU MessageFormat patterns for complex translations.
    | Requires php-intl extension for full support.
    |
    */

    'icu_enabled' => extension_loaded('intl'),

    /*
    |--------------------------------------------------------------------------
    | Locale-Specific Settings
    |--------------------------------------------------------------------------
    |
    | Per-locale configuration for country, number format, date format, etc.
    | Used by validation rules and formatting helpers.
    |
    */

    'locales' => [
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'country' => 'US',
            'currency' => 'USD',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'M j, Y',
            'time_format' => 'g:i A',
        ],
        'en_GB' => [
            'name' => 'English (UK)',
            'native' => 'English',
            'country' => 'GB',
            'currency' => 'GBP',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'j M Y',
            'time_format' => 'H:i',
        ],
        'fr' => [
            'name' => 'French',
            'native' => 'Français',
            'country' => 'FR',
            'currency' => 'EUR',
            'number_format' => ['decimal' => ',', 'thousands' => ' '],
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
        ],
        'de' => [
            'name' => 'German',
            'native' => 'Deutsch',
            'country' => 'DE',
            'currency' => 'EUR',
            'number_format' => ['decimal' => ',', 'thousands' => '.'],
            'date_format' => 'd.m.Y',
            'time_format' => 'H:i',
        ],
        'es' => [
            'name' => 'Spanish',
            'native' => 'Español',
            'country' => 'ES',
            'currency' => 'EUR',
            'number_format' => ['decimal' => ',', 'thousands' => '.'],
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
        ],
        'ar' => [
            'name' => 'Arabic',
            'native' => 'العربية',
            'country' => 'SA',
            'currency' => 'SAR',
            'number_format' => ['decimal' => ',', 'thousands' => '.'],
            'date_format' => 'Y/m/d',
            'time_format' => 'H:i',
            'rtl' => true,
        ],
        'zh' => [
            'name' => 'Chinese',
            'native' => '中文',
            'country' => 'CN',
            'currency' => 'CNY',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'Y年m月d日',
            'time_format' => 'H:i',
        ],
        'ja' => [
            'name' => 'Japanese',
            'native' => '日本語',
            'country' => 'JP',
            'currency' => 'JPY',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'Y年m月d日',
            'time_format' => 'H:i',
        ],
        'ru' => [
            'name' => 'Russian',
            'native' => 'Русский',
            'country' => 'RU',
            'currency' => 'RUB',
            'number_format' => ['decimal' => ',', 'thousands' => ' '],
            'date_format' => 'd.m.Y',
            'time_format' => 'H:i',
        ],
        'hi' => [
            'name' => 'Hindi',
            'native' => 'हिन्दी',
            'country' => 'IN',
            'currency' => 'INR',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'd/m/Y',
            'time_format' => 'h:i A',
        ],
        'pt' => [
            'name' => 'Portuguese',
            'native' => 'Português',
            'country' => 'BR',
            'currency' => 'BRL',
            'number_format' => ['decimal' => ',', 'thousands' => '.'],
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
        ],
        'ko' => [
            'name' => 'Korean',
            'native' => '한국어',
            'country' => 'KR',
            'currency' => 'KRW',
            'number_format' => ['decimal' => '.', 'thousands' => ','],
            'date_format' => 'Y년 m월 d일',
            'time_format' => 'H:i',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pluralization
    |--------------------------------------------------------------------------
    |
    | Configuration for CLDR-based pluralization rules.
    |
    */

    'pluralization' => [
        // Use CLDR rules for complex pluralization
        'use_cldr' => true,

        // Supported plural forms (for validation)
        'forms' => ['zero', 'one', 'two', 'few', 'many', 'other'],
    ],
];
