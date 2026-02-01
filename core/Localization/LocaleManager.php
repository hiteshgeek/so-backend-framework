<?php

namespace Core\Localization;

use Core\Http\Request;

/**
 * LocaleManager
 *
 * Manages locale detection, user preferences, timezone configuration, and RTL support.
 * Detects locale from: query parameter, user preference, session, Accept-Language header, or default.
 */
class LocaleManager
{
    /**
     * Translator instance
     */
    protected Translator $translator;

    /**
     * Available locales
     */
    protected array $availableLocales;

    /**
     * Default locale
     */
    protected string $defaultLocale;

    /**
     * Current timezone
     */
    protected string $timezone;

    /**
     * RTL (Right-to-Left) language codes
     * Based on ISO 639-1 codes
     */
    protected static array $rtlLanguages = [
        'ar',  // Arabic
        'he',  // Hebrew
        'fa',  // Persian (Farsi)
        'ur',  // Urdu
        'ps',  // Pashto
        'ku',  // Kurdish (Sorani)
        'yi',  // Yiddish
        'dv',  // Divehi (Maldivian)
        'sd',  // Sindhi
        'ug',  // Uyghur
    ];

    /**
     * Constructor
     *
     * @param Translator $translator Translator instance
     * @param array $availableLocales Available locales
     * @param string $defaultLocale Default locale
     * @param string|null $timezone Timezone (for testing, defaults to config value)
     */
    public function __construct(Translator $translator, array $availableLocales, string $defaultLocale, ?string $timezone = null)
    {
        $this->translator = $translator;
        $this->availableLocales = $availableLocales;
        $this->defaultLocale = $defaultLocale;
        $this->timezone = $timezone ?? config('app.timezone', 'UTC');
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->translator->getLocale();
    }

    /**
     * Set current locale
     *
     * @param string $locale Locale code
     * @return void
     */
    public function setLocale(string $locale): void
    {
        if (!$this->isLocaleAvailable($locale)) {
            $locale = $this->defaultLocale;
        }

        $this->translator->setLocale($locale);
    }

    /**
     * Detect locale from request
     *
     * Priority order:
     * 1. Query parameter (?locale=fr)
     * 2. Authenticated user preference
     * 3. Session locale
     * 4. Accept-Language header
     * 5. Default locale
     *
     * @param Request $request HTTP request
     * @return string Detected locale
     */
    public function detectLocale(Request $request): string
    {
        // 1. Check query parameter
        if ($request->has('locale')) {
            $locale = $request->input('locale');
            if ($this->isLocaleAvailable($locale)) {
                return $locale;
            }
        }

        // 2. Check authenticated user preference
        if (function_exists('auth') && auth()->check()) {
            $userLocale = $this->getUserLocale(auth()->id());
            if ($userLocale && $this->isLocaleAvailable($userLocale)) {
                return $userLocale;
            }
        }

        // 3. Check session
        if (function_exists('session') && session()->has('locale')) {
            $locale = session()->get('locale');
            if ($this->isLocaleAvailable($locale)) {
                return $locale;
            }
        }

        // 4. Check Accept-Language header
        $headerLocale = $this->parseAcceptLanguage($request->header('Accept-Language'));
        if ($headerLocale && $this->isLocaleAvailable($headerLocale)) {
            return $headerLocale;
        }

        // 5. Return default
        return $this->defaultLocale;
    }

    /**
     * Get available locales
     *
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }

    /**
     * Check if locale is available
     *
     * @param string $locale Locale code
     * @return bool
     */
    public function isLocaleAvailable(string $locale): bool
    {
        return in_array($locale, $this->availableLocales) ||
               array_key_exists($locale, $this->availableLocales);
    }

    /**
     * Get user's saved locale preference
     *
     * @param int|null $userId User ID
     * @return string|null
     */
    public function getUserLocale(?int $userId = null): ?string
    {
        if (!$userId) {
            return null;
        }

        try {
            // Check if User model exists and has locale attribute
            if (class_exists('\App\Models\User')) {
                $user = \App\Models\User::find($userId);
                if ($user && isset($user->locale)) {
                    return $user->locale;
                }
            }
        } catch (\Exception $e) {
            // Silently fail if User model not available or database issue
        }

        return null;
    }

    /**
     * Set user's locale preference
     *
     * @param int $userId User ID
     * @param string $locale Locale code
     * @return bool Success status
     */
    public function setUserLocale(int $userId, string $locale): bool
    {
        if (!$this->isLocaleAvailable($locale)) {
            return false;
        }

        try {
            // Check if User model exists
            if (class_exists('\App\Models\User')) {
                $user = \App\Models\User::find($userId);
                if ($user) {
                    $user->locale = $locale;
                    $user->save();
                    return true;
                }
            }
        } catch (\Exception $e) {
            // Silently fail if User model not available or database issue
        }

        return false;
    }

    /**
     * Get current timezone
     *
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * Set timezone
     *
     * @param string $timezone Timezone identifier (e.g., 'America/New_York')
     * @return void
     */
    public function setTimezone(string $timezone): void
    {
        // Validate timezone
        $validTimezones = \DateTimeZone::listIdentifiers();
        if (in_array($timezone, $validTimezones)) {
            $this->timezone = $timezone;
            date_default_timezone_set($timezone);
        }
    }

    /**
     * Parse Accept-Language header
     *
     * Example: "en-US,en;q=0.9,fr;q=0.8" -> "en"
     *
     * @param string|null $header Accept-Language header value
     * @return string|null Best matching locale
     */
    protected function parseAcceptLanguage(?string $header): ?string
    {
        if (!$header) {
            return null;
        }

        $languages = [];

        // Parse each language with quality factor
        foreach (explode(',', $header) as $lang) {
            $parts = explode(';', $lang);
            $locale = trim($parts[0]);
            $quality = 1.0;

            // Parse quality factor (q=0.9)
            if (isset($parts[1]) && str_starts_with(trim($parts[1]), 'q=')) {
                $quality = (float) substr(trim($parts[1]), 2);
            }

            // Extract base locale (en-US -> en)
            $baseLocale = explode('-', $locale)[0];
            $languages[$baseLocale] = $quality;
        }

        // Sort by quality descending
        arsort($languages);

        // Return first available locale
        foreach (array_keys($languages) as $locale) {
            if ($this->isLocaleAvailable($locale)) {
                return $locale;
            }
        }

        return null;
    }

    /**
     * Get locale configuration
     *
     * @param string|null $locale Locale code (null = current)
     * @return array|null Locale configuration
     */
    public function getLocaleConfig(?string $locale = null): ?array
    {
        $locale = $locale ?? $this->getCurrentLocale();

        // Try to load from resources/lang/locales.php
        $localesConfig = $this->loadLocalesConfig();

        return $localesConfig[$locale] ?? null;
    }

    /**
     * Load locales configuration
     *
     * @return array
     */
    protected function loadLocalesConfig(): array
    {
        $path = base_path('resources/lang/locales.php');

        if (file_exists($path)) {
            return require $path;
        }

        return [];
    }

    /**
     * Check if locale is RTL (Right-to-Left)
     *
     * @param string|null $locale Locale code (null = current locale)
     * @return bool True if RTL language
     */
    public function isRtl(?string $locale = null): bool
    {
        $locale = $locale ?? $this->getCurrentLocale();
        $languageCode = $this->getLanguageCode($locale);

        // Check config override first
        $rtlLocales = config('localization.rtl_locales', self::$rtlLanguages);

        return in_array($languageCode, $rtlLocales);
    }

    /**
     * Get text direction for locale
     *
     * @param string|null $locale Locale code (null = current locale)
     * @return string 'rtl' or 'ltr'
     */
    public function getDirection(?string $locale = null): string
    {
        return $this->isRtl($locale) ? 'rtl' : 'ltr';
    }

    /**
     * Get HTML dir attribute value
     *
     * @param string|null $locale Locale code (null = current locale)
     * @return string HTML dir attribute value
     */
    public function getHtmlDir(?string $locale = null): string
    {
        return $this->getDirection($locale);
    }

    /**
     * Get language code from locale
     *
     * Extracts the language code from a full locale string.
     * Examples: 'en_US' -> 'en', 'ar-SA' -> 'ar', 'zh-Hans' -> 'zh'
     *
     * @param string $locale Full locale string
     * @return string Language code
     */
    public function getLanguageCode(string $locale): string
    {
        // Handle both underscore and hyphen separators
        $parts = preg_split('/[-_]/', $locale);

        return strtolower($parts[0]);
    }

    /**
     * Get region code from locale
     *
     * Extracts the region/country code from a full locale string.
     * Examples: 'en_US' -> 'US', 'ar-SA' -> 'SA'
     *
     * @param string $locale Full locale string
     * @return string|null Region code or null if not present
     */
    public function getRegionCode(string $locale): ?string
    {
        $parts = preg_split('/[-_]/', $locale);

        if (count($parts) > 1) {
            return strtoupper($parts[1]);
        }

        return null;
    }

    /**
     * Get all RTL language codes
     *
     * @return array Array of RTL language codes
     */
    public static function getRtlLanguages(): array
    {
        return config('localization.rtl_locales', self::$rtlLanguages);
    }

    /**
     * Check if current locale uses RTL script
     *
     * @return bool
     */
    public function currentIsRtl(): bool
    {
        return $this->isRtl();
    }

    /**
     * Get CSS class for text direction
     *
     * Returns appropriate CSS class for styling based on text direction.
     *
     * @param string|null $locale Locale code (null = current locale)
     * @return string CSS class ('dir-ltr' or 'dir-rtl')
     */
    public function getDirectionClass(?string $locale = null): string
    {
        return 'dir-' . $this->getDirection($locale);
    }

    /**
     * Get locale display name
     *
     * Uses Intl extension if available, otherwise returns configured name.
     *
     * @param string|null $locale Locale code (null = current locale)
     * @param string|null $displayLocale Locale for display (null = current locale)
     * @return string Locale display name
     */
    public function getLocaleName(?string $locale = null, ?string $displayLocale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        $displayLocale = $displayLocale ?? $this->getCurrentLocale();

        // Try Intl extension first
        if (class_exists('Locale') && method_exists('Locale', 'getDisplayName')) {
            $name = \Locale::getDisplayName($locale, $displayLocale);
            if ($name && $name !== $locale) {
                return $name;
            }
        }

        // Fallback to configuration
        $config = $this->getLocaleConfig($locale);
        if ($config && isset($config['name'])) {
            return $config['name'];
        }

        // Fallback to built-in names
        $names = [
            'en' => 'English',
            'ar' => 'العربية',
            'he' => 'עברית',
            'fa' => 'فارسی',
            'ur' => 'اردو',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'es' => 'Español',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            'ja' => '日本語',
            'ko' => '한국어',
            'hi' => 'हिन्दी',
        ];

        $languageCode = $this->getLanguageCode($locale);
        return $names[$languageCode] ?? $locale;
    }

    /**
     * Get native locale name
     *
     * Returns the locale name in its native language/script.
     *
     * @param string|null $locale Locale code (null = current locale)
     * @return string Native locale name
     */
    public function getNativeName(?string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();

        // Try Intl extension
        if (class_exists('Locale') && method_exists('Locale', 'getDisplayName')) {
            $name = \Locale::getDisplayName($locale, $locale);
            if ($name && $name !== $locale) {
                return $name;
            }
        }

        return $this->getLocaleName($locale, $locale);
    }
}
