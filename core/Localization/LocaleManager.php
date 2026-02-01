<?php

namespace Core\Localization;

use Core\Http\Request;

/**
 * LocaleManager
 *
 * Manages locale detection, user preferences, and timezone configuration.
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
     * Constructor
     *
     * @param Translator $translator Translator instance
     * @param array $availableLocales Available locales
     * @param string $defaultLocale Default locale
     */
    public function __construct(Translator $translator, array $availableLocales, string $defaultLocale)
    {
        $this->translator = $translator;
        $this->availableLocales = $availableLocales;
        $this->defaultLocale = $defaultLocale;
        $this->timezone = config('app.timezone', 'UTC');
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
}
