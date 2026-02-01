<?php

/**
 * Locale Configuration
 *
 * Detailed configuration for each supported locale.
 */

return [
    'en' => [
        'name' => 'English',
        'native' => 'English',
        'direction' => 'ltr',
        'timezone' => 'UTC',
        'currency' => 'USD',
        'date_format' => 'm/d/Y',
        'first_day_of_week' => 0, // Sunday
    ],

    'fr' => [
        'name' => 'French',
        'native' => 'Français',
        'direction' => 'ltr',
        'timezone' => 'Europe/Paris',
        'currency' => 'EUR',
        'date_format' => 'd/m/Y',
        'first_day_of_week' => 1, // Monday
    ],

    'de' => [
        'name' => 'German',
        'native' => 'Deutsch',
        'direction' => 'ltr',
        'timezone' => 'Europe/Berlin',
        'currency' => 'EUR',
        'date_format' => 'd.m.Y',
        'first_day_of_week' => 1,
    ],

    'es' => [
        'name' => 'Spanish',
        'native' => 'Español',
        'direction' => 'ltr',
        'timezone' => 'Europe/Madrid',
        'currency' => 'EUR',
        'date_format' => 'd/m/Y',
        'first_day_of_week' => 1,
    ],

    'ar' => [
        'name' => 'Arabic',
        'native' => 'العربية',
        'direction' => 'rtl',
        'timezone' => 'Asia/Dubai',
        'currency' => 'AED',
        'date_format' => 'd/m/Y',
        'first_day_of_week' => 6, // Saturday
    ],

    'zh' => [
        'name' => 'Chinese',
        'native' => '中文',
        'direction' => 'ltr',
        'timezone' => 'Asia/Shanghai',
        'currency' => 'CNY',
        'date_format' => 'Y-m-d',
        'first_day_of_week' => 1,
    ],
];
