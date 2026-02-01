# Localization Implementation Guide

## Overview

This guide provides step-by-step instructions for implementing and extending the internationalization (i18n) and localization (l10n) system in the SO Backend Framework.

**What You'll Learn:**
- Complete system architecture
- Implementing multi-language support
- Adding new locales and translations
- Currency and number formatting
- Date/time localization
- Integration patterns
- Testing and validation

---

## Requirements

**PHP Intl Extension is Required**

The localization system requires the PHP Intl extension for accurate currency, number, and date formatting. Before implementing localization features, ensure php-intl is installed:

```bash
php -m | grep intl
```

**Installation:**

```bash
# Ubuntu/Debian
sudo apt-get install php8.3-intl
sudo service apache2 restart

# CentOS/RHEL
sudo yum install php-intl
sudo systemctl restart httpd

# macOS (Homebrew)
brew install php
# Intl is included by default
```

The framework validates this requirement during service provider registration and will throw a `MissingExtensionException` with installation instructions if the extension is not loaded.

---

## Architecture Overview

### Core Components

```
core/Localization/
├── Translator.php              # Translation engine
├── LocaleManager.php           # Locale detection & management
├── TranslationLoader.php       # File loading & caching
├── LocaleServiceProvider.php   # DI container registration
├── Middleware/
│   └── SetLocaleMiddleware.php # Request-level locale detection
└── Formatters/
    ├── CurrencyFormatter.php   # Currency formatting
    ├── NumberFormatter.php     # Number formatting
    └── DateTimeFormatter.php   # Date/time formatting
```

### Data Flow

```
HTTP Request
    ↓
SetLocaleMiddleware
    ↓ (Detects locale from: query → user → session → header → default)
LocaleManager::setLocale()
    ↓
Translator loaded with locale
    ↓
Controller/View calls trans()
    ↓
TranslationLoader loads files
    ↓
Translator processes & returns translation
    ↓
Response
```

---

## Step 1: Core Translation System

### 1.1 Create the Translator Class

**File:** `core/Localization/Translator.php`

```php
<?php

namespace Core\Localization;

class Translator
{
    private string $locale;
    private string $fallbackLocale;
    private array $loaded = [];
    private TranslationLoader $loader;

    public function __construct(
        TranslationLoader $loader,
        string $locale = 'en',
        string $fallbackLocale = 'en'
    ) {
        $this->loader = $loader;
        $this->locale = $locale;
        $this->fallbackLocale = $fallbackLocale;
    }

    /**
     * Translate a key
     *
     * @param string $key Translation key (e.g., 'validation.required')
     * @param array $replace Parameters to replace (e.g., ['attribute' => 'email'])
     * @param string|null $locale Override locale
     * @return string Translated string
     */
    public function trans(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?? $this->locale;

        // Get translation
        $translation = $this->get($key, $locale);

        // Fallback to default locale
        if ($translation === $key && $locale !== $this->fallbackLocale) {
            $translation = $this->get($key, $this->fallbackLocale);
        }

        // Replace parameters
        return $this->replaceParameters($translation, $replace);
    }

    /**
     * Get translation from loaded files
     */
    private function get(string $key, string $locale): string
    {
        [$group, $item] = $this->parseKey($key);

        // Load group if not loaded
        if (!isset($this->loaded[$locale][$group])) {
            $this->loaded[$locale][$group] = $this->loader->load($locale, $group);
        }

        // Navigate nested array
        $translation = $this->loaded[$locale][$group] ?? [];
        foreach (explode('.', $item) as $segment) {
            if (!is_array($translation) || !isset($translation[$segment])) {
                return $key; // Return key if not found
            }
            $translation = $translation[$segment];
        }

        return is_string($translation) ? $translation : $key;
    }

    /**
     * Parse translation key into group and item
     *
     * @param string $key (e.g., 'validation.required.string')
     * @return array ['validation', 'required.string']
     */
    private function parseKey(string $key): array
    {
        $segments = explode('.', $key, 2);
        return [
            $segments[0],
            $segments[1] ?? ''
        ];
    }

    /**
     * Replace parameters in translation
     *
     * @param string $translation String with :parameter placeholders
     * @param array $replace ['parameter' => 'value']
     * @return string Processed string
     */
    private function replaceParameters(string $translation, array $replace): string
    {
        if (empty($replace)) {
            return $translation;
        }

        foreach ($replace as $key => $value) {
            $translation = str_replace(
                [':' . $key, ':' . strtoupper($key)],
                [$value, strtoupper($value)],
                $translation
            );
        }

        return $translation;
    }

    /**
     * Pluralization support
     *
     * @param string $key Translation key
     * @param int $count Count for pluralization
     * @param array $replace Parameters
     * @return string Translated string
     */
    public function transChoice(string $key, int $count, array $replace = []): string
    {
        $replace['count'] = $count;

        $translation = $this->trans($key, $replace);

        // If translation is an array, choose based on count
        if (is_array($translation)) {
            if ($count === 0 && isset($translation['zero'])) {
                return $this->replaceParameters($translation['zero'], $replace);
            } elseif ($count === 1 && isset($translation['one'])) {
                return $this->replaceParameters($translation['one'], $replace);
            } elseif (isset($translation['many'])) {
                return $this->replaceParameters($translation['many'], $replace);
            }
        }

        return $translation;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
```

### 1.2 Create the Translation Loader

**File:** `core/Localization/TranslationLoader.php`

```php
<?php

namespace Core\Localization;

class TranslationLoader
{
    private string $path;
    private array $cache = [];

    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/');
    }

    /**
     * Load translation file
     *
     * @param string $locale (e.g., 'en', 'fr')
     * @param string $group (e.g., 'validation', 'auth')
     * @return array Translation array
     */
    public function load(string $locale, string $group): array
    {
        $cacheKey = "{$locale}.{$group}";

        // Return cached if available
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        // Build file path
        $file = "{$this->path}/{$locale}/{$group}.php";

        // Load file
        if (!file_exists($file)) {
            $this->cache[$cacheKey] = [];
            return [];
        }

        $translations = require $file;
        $this->cache[$cacheKey] = is_array($translations) ? $translations : [];

        return $this->cache[$cacheKey];
    }

    /**
     * Clear cache (useful for testing)
     */
    public function clearCache(): void
    {
        $this->cache = [];
    }
}
```

### 1.3 Create the Locale Manager

**File:** `core/Localization/LocaleManager.php`

```php
<?php

namespace Core\Localization;

use Core\Http\Request;

class LocaleManager
{
    private string $currentLocale;
    private string $defaultLocale;
    private array $availableLocales;
    private ?string $currentTimezone = null;

    public function __construct(
        string $defaultLocale = 'en',
        array $availableLocales = ['en']
    ) {
        $this->defaultLocale = $defaultLocale;
        $this->availableLocales = $availableLocales;
        $this->currentLocale = $defaultLocale;
    }

    /**
     * Detect locale from request
     *
     * Priority: Query param > User preference > Session > Accept-Language > Default
     */
    public function detectLocale(Request $request): string
    {
        // 1. Query parameter (?locale=fr)
        $queryLocale = $request->get('locale');
        if ($queryLocale && $this->isAvailable($queryLocale)) {
            return $queryLocale;
        }

        // 2. Authenticated user preference
        if ($user = auth()->user()) {
            if (method_exists($user, 'getLocale') && $user->getLocale()) {
                $userLocale = $user->getLocale();
                if ($this->isAvailable($userLocale)) {
                    return $userLocale;
                }
            }
        }

        // 3. Session
        $sessionLocale = session()->get('locale');
        if ($sessionLocale && $this->isAvailable($sessionLocale)) {
            return $sessionLocale;
        }

        // 4. Accept-Language header
        $headerLocale = $this->parseAcceptLanguage($request->header('Accept-Language'));
        if ($headerLocale && $this->isAvailable($headerLocale)) {
            return $headerLocale;
        }

        // 5. Default
        return $this->defaultLocale;
    }

    /**
     * Parse Accept-Language header
     *
     * @param string|null $header (e.g., 'fr-FR,fr;q=0.9,en;q=0.8')
     * @return string|null First supported locale
     */
    private function parseAcceptLanguage(?string $header): ?string
    {
        if (!$header) {
            return null;
        }

        $languages = [];
        foreach (explode(',', $header) as $lang) {
            $parts = explode(';q=', $lang);
            $code = trim(explode('-', $parts[0])[0]);
            $quality = isset($parts[1]) ? (float)$parts[1] : 1.0;
            $languages[$code] = $quality;
        }

        arsort($languages);

        foreach (array_keys($languages) as $code) {
            if ($this->isAvailable($code)) {
                return $code;
            }
        }

        return null;
    }

    public function setLocale(string $locale): void
    {
        if ($this->isAvailable($locale)) {
            $this->currentLocale = $locale;
            session()->put('locale', $locale);
        }
    }

    public function getLocale(): string
    {
        return $this->currentLocale;
    }

    public function isAvailable(string $locale): bool
    {
        return in_array($locale, $this->availableLocales, true);
    }

    public function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }

    public function setTimezone(string $timezone): void
    {
        $this->currentTimezone = $timezone;
        date_default_timezone_set($timezone);
    }

    public function getTimezone(): string
    {
        return $this->currentTimezone ?? date_default_timezone_get();
    }
}
```

---

## Step 2: Middleware for Locale Detection

**File:** `core/Localization/Middleware/SetLocaleMiddleware.php`

```php
<?php

namespace Core\Localization\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Localization\LocaleManager;
use Core\Localization\Translator;

class SetLocaleMiddleware
{
    private LocaleManager $localeManager;
    private Translator $translator;

    public function __construct(LocaleManager $localeManager, Translator $translator)
    {
        $this->localeManager = $localeManager;
        $this->translator = $translator;
    }

    public function handle(Request $request, callable $next): Response
    {
        // Detect locale
        $locale = $this->localeManager->detectLocale($request);

        // Set locale
        $this->localeManager->setLocale($locale);
        $this->translator->setLocale($locale);

        // Set timezone if user is authenticated
        if ($user = auth()->user()) {
            if (method_exists($user, 'getTimezone') && $timezone = $user->getTimezone()) {
                $this->localeManager->setTimezone($timezone);
            }
        }

        return $next($request);
    }
}
```

**Register Middleware:** Add to `bootstrap/middleware.php`

```php
use Core\Localization\Middleware\SetLocaleMiddleware;

return [
    'global' => [
        // ... other middleware
        SetLocaleMiddleware::class,
    ],
];
```

---

## Step 3: Currency and Number Formatters

### 3.1 Currency Formatter

**File:** `core/Localization/Formatters/CurrencyFormatter.php`

```php
<?php

namespace Core\Localization\Formatters;

use NumberFormatter;

class CurrencyFormatter
{
    protected array $zeroDecimalCurrencies = ['JPY', 'KRW', 'VND', 'CLP'];

    /**
     * Format amount as currency
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code (USD, EUR, GBP, etc.)
     * @param string $locale Locale for formatting (en, fr, de, etc.)
     * @return string Formatted currency string
     */
    public function format(float $amount, string $currency = 'USD', string $locale = 'en'): string
    {
        $localeMap = [
            'en' => 'en_US',
            'fr' => 'fr_FR',
            'de' => 'de_DE',
            'es' => 'es_ES',
            'ar' => 'ar_AE',
            'zh' => 'zh_CN',
            'ja' => 'ja_JP',
            'hi' => 'hi_IN',
        ];

        $fullLocale = $localeMap[$locale] ?? 'en_US';

        $formatter = new NumberFormatter($fullLocale, NumberFormatter::CURRENCY);

        // Handle zero-decimal currencies (JPY, KRW, etc.)
        if (in_array($currency, $this->zeroDecimalCurrencies)) {
            $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        }

        $formatted = $formatter->formatCurrency($amount, $currency);

        if ($formatted === false) {
            throw new \RuntimeException(
                "Failed to format currency. Currency: {$currency}, Locale: {$fullLocale}"
            );
        }

        return $formatted;
    }
}
```

### 3.2 Date/Time Formatter

**File:** `core/Localization/Formatters/DateTimeFormatter.php`

```php
<?php

namespace Core\Localization\Formatters;

use DateTime;
use DateTimeZone;
use IntlDateFormatter;

class DateTimeFormatter
{
    /**
     * Format date/time with locale and timezone
     *
     * @param DateTime|string $datetime Date to format
     * @param string $format Format string or preset (short, medium, long)
     * @param string $locale Locale
     * @param string|null $timezone Timezone
     * @return string Formatted date/time
     */
    public function format(
        $datetime,
        string $format = 'medium',
        string $locale = 'en',
        ?string $timezone = null
    ): string {
        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        }

        if ($timezone) {
            $datetime->setTimezone(new DateTimeZone($timezone));
        }

        $localeMap = [
            'en' => 'en_US',
            'fr' => 'fr_FR',
            'de' => 'de_DE',
            'es' => 'es_ES',
            'ja' => 'ja_JP',
            'hi' => 'hi_IN',
        ];

        $fullLocale = $localeMap[$locale] ?? 'en_US';

        $formatMap = [
            'short' => [IntlDateFormatter::SHORT, IntlDateFormatter::SHORT],
            'medium' => [IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM],
            'long' => [IntlDateFormatter::LONG, IntlDateFormatter::LONG],
        ];

        [$dateFormat, $timeFormat] = $formatMap[$format] ?? $formatMap['medium'];

        $formatter = new IntlDateFormatter(
            $fullLocale,
            $dateFormat,
            $timeFormat,
            $datetime->getTimezone()
        );

        $result = $formatter->format($datetime);

        if ($result === false) {
            throw new \RuntimeException(
                "Failed to format datetime. Locale: {$fullLocale}, Format: {$format}"
            );
        }

        return $result;
    }
}
```

---

## Step 4: Helper Functions

**Add to:** `core/Support/Helpers.php`

```php
/**
 * Translate a key
 *
 * @param string $key Translation key
 * @param array $replace Parameters to replace
 * @param string|null $locale Override locale
 * @return string Translated string
 */
function trans(string $key, array $replace = [], ?string $locale = null): string
{
    static $translator;
    if (!$translator) {
        $translator = app(Core\Localization\Translator::class);
    }
    return $translator->trans($key, $replace, $locale);
}

/**
 * Alias for trans()
 */
function __(string $key, array $replace = [], ?string $locale = null): string
{
    return trans($key, $replace, $locale);
}

/**
 * Pluralization
 */
function trans_choice(string $key, int $count, array $replace = [], ?string $locale = null): string
{
    static $translator;
    if (!$translator) {
        $translator = app(Core\Localization\Translator::class);
    }
    return $translator->transChoice($key, $count, $replace, $locale);
}

/**
 * Get or set current locale
 */
function locale(?string $locale = null): string
{
    static $manager;
    if (!$manager) {
        $manager = app(Core\Localization\LocaleManager::class);
    }

    if ($locale !== null) {
        $manager->setLocale($locale);
    }

    return $manager->getLocale();
}

/**
 * Format currency
 */
function format_currency(float $amount, string $currency = 'USD', ?string $locale = null): string
{
    static $formatter;
    if (!$formatter) {
        $formatter = app(Core\Localization\Formatters\CurrencyFormatter::class);
    }

    $locale = $locale ?? locale();
    return $formatter->format($amount, $currency, $locale);
}

/**
 * Format date/time
 */
function format_datetime($datetime, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
{
    static $formatter;
    if (!$formatter) {
        $formatter = app(Core\Localization\Formatters\DateTimeFormatter::class);
    }

    $locale = $locale ?? locale();
    $timezone = $timezone ?? (auth()->user()?->getTimezone() ?? null);

    return $formatter->format($datetime, $format, $locale, $timezone);
}
```

---

## Step 5: Create Translation Files

### 5.1 Directory Structure

```
resources/lang/
├── en/
│   ├── validation.php
│   ├── auth.php
│   ├── messages.php
│   ├── status.php
│   └── notifications.php
├── fr/
│   ├── validation.php
│   ├── auth.php
│   └── ...
└── de/
    └── ...
```

### 5.2 English Validation Translations

**File:** `resources/lang/en/validation.php`

```php
<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',

    // Attribute names
    'attributes' => [
        'email' => 'email address',
        'password' => 'password',
        'name' => 'name',
        'phone' => 'phone number',
    ],
];
```

### 5.3 French Validation Translations

**File:** `resources/lang/fr/validation.php`

```php
<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'min' => [
        'numeric' => 'Le champ :attribute doit être au moins :min.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'max' => [
        'numeric' => 'Le champ :attribute ne peut pas être supérieur à :max.',
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],
    'unique' => 'Le :attribute a déjà été pris.',
    'confirmed' => 'La confirmation du :attribute ne correspond pas.',

    'attributes' => [
        'email' => 'adresse e-mail',
        'password' => 'mot de passe',
        'name' => 'nom',
        'phone' => 'numéro de téléphone',
    ],
];
```

### 5.4 Status Labels

**File:** `resources/lang/en/status.php`

```php
<?php

return [
    'order' => [
        '1' => 'Pending',
        '2' => 'Processing',
        '3' => 'Shipped',
        '4' => 'Delivered',
        '5' => 'Cancelled',
        '6' => 'Refunded',
    ],
    'user' => [
        '1' => 'Active',
        '2' => 'Inactive',
        '3' => 'Suspended',
    ],
    'product' => [
        '1' => 'Available',
        '2' => 'Out of Stock',
        '3' => 'Discontinued',
    ],
    'unknown' => 'Unknown',
];
```

---

## Step 6: Integration with Existing Code

### 6.1 Update Validator

**File:** `core/Validation/Validator.php`

**Before:**
```php
protected array $messages = [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    // ... hardcoded messages
];
```

**After:**
```php
protected array $messages = [];

protected function getMessage(string $rule, string $field): string
{
    // Check custom messages first
    if (isset($this->customMessages["{$field}.{$rule}"])) {
        return $this->customMessages["{$field}.{$rule}"];
    }
    if (isset($this->customMessages[$rule])) {
        return $this->customMessages[$rule];
    }

    // Get from translation files
    $message = trans("validation.{$rule}");

    // Handle nested rules (min.string, max.numeric, etc.)
    if (is_array($message)) {
        $type = $this->getFieldType($field);
        $message = $message[$type] ?? reset($message);
    }

    // Translate attribute name
    $attribute = trans("validation.attributes.{$field}", [], $field);

    return str_replace(':attribute', $attribute, $message);
}
```

### 6.2 Update Models

**File:** `app/Models/Order.php`

**Before:**
```php
public function getStatusName(): string
{
    return match ($this->getStatusValue()) {
        1 => 'Pending',
        2 => 'Processing',
        3 => 'Shipped',
        4 => 'Delivered',
        5 => 'Cancelled',
        6 => 'Refunded',
        default => 'Unknown',
    };
}
```

**After:**
```php
public function getStatusName(): string
{
    $statusId = $this->getStatusValue();
    return trans("status.order.{$statusId}", [], trans('status.unknown'));
}
```

### 6.3 Update API Responses

**File:** `app/Controllers/Auth/AuthApiController.php`

**Before:**
```php
return JsonResponse::error('Invalid email or password', 401);
return JsonResponse::success($data, 'Registration successful!');
```

**After:**
```php
return JsonResponse::error(trans('auth.failed'), 401);
return JsonResponse::success($data, trans('auth.registration_success'));
```

---

## Step 7: Database Migration

**Create migration:** `database/migrations/2026_02_01_000001_add_locale_to_users.php`

```php
<?php

use Core\Database\Migration;

class AddLocaleToUsers extends Migration
{
    public function up(): void
    {
        $sql = "
            ALTER TABLE auser
            ADD COLUMN locale VARCHAR(10) DEFAULT 'en' AFTER email,
            ADD COLUMN timezone VARCHAR(50) DEFAULT 'UTC' AFTER locale,
            ADD INDEX idx_locale (locale)
        ";
        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = "
            ALTER TABLE auser
            DROP COLUMN locale,
            DROP COLUMN timezone,
            DROP INDEX idx_locale
        ";
        $this->execute($sql);
    }
}
```

**Update User Model:** `app/Models/User.php`

```php
protected array $fillable = [
    'name',
    'email',
    'password',
    'locale',      // Add
    'timezone',    // Add
];

public function getLocale(): string
{
    return $this->attributes['locale'] ?? config('app.locale', 'en');
}

public function setLocale(string $locale): void
{
    $this->attributes['locale'] = $locale;
    $this->save();
}

public function getTimezone(): string
{
    return $this->attributes['timezone'] ?? config('app.timezone', 'UTC');
}

public function setTimezone(string $timezone): void
{
    $this->attributes['timezone'] = $timezone;
    $this->save();
}
```

---

## Step 8: Service Provider Registration

**File:** `core/Localization/LocaleServiceProvider.php`

```php
<?php

namespace Core\Localization;

use Core\Container\Container;

class LocaleServiceProvider
{
    public function register(Container $container): void
    {
        // Register TranslationLoader
        $container->singleton(TranslationLoader::class, function () {
            return new TranslationLoader(
                __DIR__ . '/../../resources/lang'
            );
        });

        // Register Translator
        $container->singleton(Translator::class, function ($container) {
            $loader = $container->make(TranslationLoader::class);
            return new Translator(
                $loader,
                config('app.locale', 'en'),
                config('app.fallback_locale', 'en')
            );
        });

        // Register LocaleManager
        $container->singleton(LocaleManager::class, function () {
            return new LocaleManager(
                config('app.locale', 'en'),
                config('app.available_locales', ['en'])
            );
        });

        // Register Formatters
        $container->singleton(Formatters\CurrencyFormatter::class);
        $container->singleton(Formatters\NumberFormatter::class);
        $container->singleton(Formatters\DateTimeFormatter::class);
    }
}
```

**Register in:** `config/app.php`

```php
'providers' => [
    // ... existing providers
    \Core\Localization\LocaleServiceProvider::class,
],
```

---

## Step 9: Configuration

**File:** `config/app.php`

```php
// Localization
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'available_locales' => ['en', 'fr', 'de', 'es', 'ar', 'zh'],
'timezone' => env('APP_TIMEZONE', 'Asia/Kolkata'),
```

**File:** `.env`

```bash
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_TIMEZONE=Asia/Kolkata
DEFAULT_CURRENCY=INR
LOCALE_DETECTION_ENABLED=true
```

---

## Step 10: Testing

### 10.1 Unit Test for Translator

**File:** `tests/Unit/Localization/TranslatorTest.php`

```php
<?php

namespace Tests\Unit\Localization;

use Core\Localization\Translator;
use Core\Localization\TranslationLoader;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
    private Translator $translator;

    protected function setUp(): void
    {
        $loader = new TranslationLoader(__DIR__ . '/../../resources/lang');
        $this->translator = new Translator($loader, 'en', 'en');
    }

    public function testBasicTranslation(): void
    {
        $result = $this->translator->trans('validation.required');
        $this->assertEquals('The :attribute field is required.', $result);
    }

    public function testParameterReplacement(): void
    {
        $result = $this->translator->trans('validation.required', [
            'attribute' => 'email'
        ]);
        $this->assertStringContainsString('email', $result);
    }

    public function testLocaleSwitch(): void
    {
        $this->translator->setLocale('fr');
        $result = $this->translator->trans('validation.required');
        $this->assertStringContainsString('obligatoire', $result);
    }

    public function testFallbackToDefault(): void
    {
        $this->translator->setLocale('xx'); // Invalid locale
        $result = $this->translator->trans('validation.required');
        $this->assertStringContainsString('required', $result);
    }

    public function testNestedTranslation(): void
    {
        $result = $this->translator->trans('validation.min.string');
        $this->assertStringContainsString('characters', $result);
    }
}
```

### 10.2 Integration Test

**File:** `tests/Integration/Localization/LocaleMiddlewareTest.php`

```php
<?php

namespace Tests\Integration\Localization;

use Tests\TestCase;

class LocaleMiddlewareTest extends TestCase
{
    public function testLocaleDetectionFromQueryParameter(): void
    {
        $response = $this->get('/docs?locale=fr');

        $this->assertEquals(200, $response->statusCode());
        // Verify locale was set to 'fr'
        $this->assertEquals('fr', locale());
    }

    public function testLocaleDetectionFromUser(): void
    {
        // Create user with locale preference
        $user = $this->createUser(['locale' => 'de']);

        $response = $this->actingAs($user)->get('/dashboard');

        $this->assertEquals('de', locale());
    }

    public function testValidationMessagesInFrench(): void
    {
        $response = $this->post('/api/auth/login?locale=fr', [
            'email' => 'invalid',
            'password' => '123'
        ]);

        $data = $response->json();
        $this->assertStringContainsString('obligatoire', $data['errors']['email'][0] ?? '');
    }
}
```

---

## Step 11: Adding a New Language

### Example: Adding Spanish

**1. Create translation files:**

```bash
mkdir -p resources/lang/es
```

**2. Copy and translate files:**

```bash
cp resources/lang/en/validation.php resources/lang/es/validation.php
cp resources/lang/en/auth.php resources/lang/es/auth.php
cp resources/lang/en/messages.php resources/lang/es/messages.php
```

**3. Translate content:**

**File:** `resources/lang/es/validation.php`

```php
<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser una dirección de correo válida.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    // ... more translations
];
```

**4. Add to config:**

```php
// config/app.php
'available_locales' => ['en', 'fr', 'de', 'es', 'ar', 'zh'],
```

**5. Test:**

```php
locale('es');
echo trans('validation.required', ['attribute' => 'email']);
// Output: "El campo email es obligatorio."
```

---

## Usage Examples

### In Controllers

```php
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:auser',
    ]);

    if ($validator->fails()) {
        // Validation messages automatically translated
        return JsonResponse::error(
            trans('messages.validation_failed'),
            422,
            ['errors' => $validator->errors()]
        );
    }

    // Success message translated
    return JsonResponse::success(
        $data,
        trans('messages.created_successfully')
    );
}
```

### In Views

```php
<h1><?= trans('dashboard.welcome', ['name' => $user->name]) ?></h1>

<p><?= trans('dashboard.orders_count', ['count' => $ordersCount]) ?></p>

<!-- Currency formatting -->
<span><?= format_currency($order->total, 'USD') ?></span>

<!-- Date formatting -->
<span><?= format_datetime($order->created_at, 'long') ?></span>
```

### In Models

```php
class Order extends Model
{
    public function getStatusName(): string
    {
        return trans("status.order.{$this->status}");
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_name' => $this->getStatusName(),
            'total' => format_currency($this->total, 'USD'),
            'created_at' => format_datetime($this->created_at),
        ];
    }
}
```

### In Notifications

```php
public function toDatabase($notifiable): array
{
    return [
        'title' => trans('notifications.order_shipped.title'),
        'message' => trans('notifications.order_shipped.message', [
            'order_id' => $this->order->id
        ]),
        'action_text' => trans('notifications.order_shipped.action'),
    ];
}
```

---

## Performance Optimization

### 1. OpCode Caching

Translation files are PHP arrays and benefit from OpCode caching automatically.

### 2. Lazy Loading

The system only loads translation groups when needed:

```php
// Only loads 'validation' group
trans('validation.required');

// Only loads 'auth' group
trans('auth.failed');
```

### 3. Per-Request Caching

Translations are cached in memory for the current request.

### 4. Production Optimization

In production, consider pre-compiling translations:

```bash
./sixorbit localize:cache
```

This creates a single cached file per locale.

---

## Troubleshooting

### Translation Not Found

**Symptom:** Key returned instead of translation

```php
echo trans('validation.required');
// Output: "validation.required" (wrong)
```

**Solutions:**
1. Check file exists: `resources/lang/en/validation.php`
2. Check key exists in array
3. Check file returns array: `return [ ... ];`
4. Clear cache if using caching

### Wrong Locale Applied

**Symptom:** English shown instead of French

**Solutions:**
1. Check middleware is registered
2. Verify locale is available in config
3. Check query parameter: `?locale=fr`
4. Debug locale detection:

```php
dd(locale()); // Should show 'fr'
```

### Currency Not Formatting

**Symptom:** Application throws MissingExtensionException or RuntimeException

**Solutions:**
1. Install `php-intl` extension (required): `sudo apt-get install php8.3-intl`
2. Restart your web server: `sudo service apache2 restart`
3. Verify installation: `php -m | grep intl`
4. Check that locale code is valid (must be in localeMap)
5. Check that currency code is valid (3-letter ISO code)

---

## Best Practices

- **Organize translations by domain:**
   - `validation.php` - Validation messages
   - `auth.php` - Authentication messages
   - `messages.php` - General API messages
   - `status.php` - Status labels

- **Use descriptive keys:**

```php
// Good
trans('order.status.shipped')

// Bad
trans('msg1')
```

- **Keep translations DRY:**

```php
// Reuse common phrases
'success' => 'Operation successful',
'created' => 'Created successfully',
```

- **Always provide fallback:**

```php
trans('status.order.' . $id, [], trans('status.unknown'))
```

- **Test all locales:**
   - Create integration tests for each supported language
   - Verify parameter replacement works
   - Check pluralization rules

---

## API Endpoints

### Change User Locale

**Endpoint:** `PUT /api/user/locale`

```php
// routes/api.php
Router::put('/user/locale', [UserApiController::class, 'updateLocale'])
    ->middleware([AuthMiddleware::class]);

// app/Controllers/User/UserApiController.php
public function updateLocale(Request $request): Response
{
    $locale = $request->get('locale');

    if (!in_array($locale, config('app.available_locales'))) {
        return JsonResponse::error(trans('messages.invalid_locale'), 400);
    }

    $user = auth()->user();
    $user->setLocale($locale);

    if ($timezone = $request->get('timezone')) {
        $user->setTimezone($timezone);
    }

    return JsonResponse::success([
        'locale' => $user->getLocale(),
        'timezone' => $user->getTimezone(),
    ], trans('messages.locale_updated'));
}
```

**Usage:**

```bash
curl -X PUT http://localhost:8000/api/user/locale \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"locale":"fr","timezone":"Europe/Paris"}'
```

---

## Checklist

- [ ] Core classes created (Translator, LocaleManager, TranslationLoader)
- [ ] Middleware registered and working
- [ ] Translation files created for all locales
- [ ] Helper functions added
- [ ] Validator integrated with translations
- [ ] Models using translated status labels
- [ ] API responses using translations
- [ ] Database migration for user locale/timezone
- [ ] User model updated with locale methods
- [ ] Service provider registered
- [ ] Configuration updated
- [ ] Unit tests written (10+ tests)
- [ ] Integration tests written (5+ tests)
- [ ] Documentation updated
- [ ] All locales tested

---

## Next Steps

1. **Add more languages:** Follow "Adding a New Language" section
2. **Implement RTL support:** For Arabic, Hebrew
3. **Add locale switcher UI:** Dropdown in header
4. **Implement translation caching:** For production performance
5. **Create translation management tool:** For non-technical translators

---

## Resources

- [PHP Intl Extension](https://www.php.net/manual/en/book.intl.php)
- [ICU Date/Time Patterns](http://userguide.icu-project.org/formatparse/datetime)
- [Currency Codes (ISO 4217)](https://en.wikipedia.org/wiki/ISO_4217)
- [Locale Codes (BCP 47)](https://tools.ietf.org/html/bcp47)
- [CLDR Data](http://cldr.unicode.org/)

---

**Need Help?**

- Check the [main localization documentation](/docs/localization) for user guide
- Review existing translation files in `resources/lang/`
- See [validation system documentation](/docs/validation-system) for validation integration
- Consult [API versioning](/docs/api-versioning) for API integration patterns
