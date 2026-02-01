<?php

namespace Core\Localization\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\MiddlewareInterface;
use Core\Localization\LocaleManager;

/**
 * SetLocaleMiddleware
 *
 * Automatically detects and sets the locale for each request.
 * Detection priority: query parameter > user preference > session > header > default
 *
 * Supports:
 * - ?locale=fr query parameter for explicit override
 * - Per-user locale preferences from database
 * - Session-based locale storage
 * - Accept-Language header parsing
 * - Default locale from configuration
 */
class SetLocaleMiddleware implements MiddlewareInterface
{
    /**
     * LocaleManager instance
     */
    protected LocaleManager $localeManager;

    /**
     * Constructor
     *
     * @param LocaleManager $localeManager
     */
    public function __construct(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    /**
     * Handle the request
     *
     * @param Request $request HTTP request
     * @param callable $next Next middleware
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        // Detect locale from multiple sources
        $locale = $this->localeManager->detectLocale($request);

        // Set the locale
        $this->localeManager->setLocale($locale);

        // Store in session for future requests (if available)
        if ($request->has('locale') && function_exists('session')) {
            session()->put('locale', $locale);
        }

        // Set PHP's locale for native functions (strftime, money_format, etc.)
        $this->setPhpLocale($locale);

        // Set timezone if user has preference
        if (function_exists('auth') && auth()->check()) {
            $userTimezone = $this->getUserTimezone(auth()->id());
            if ($userTimezone) {
                $this->localeManager->setTimezone($userTimezone);
            }
        }

        // Continue to next middleware
        return $next($request);
    }

    /**
     * Set PHP's internal locale
     *
     * @param string $locale Locale code
     * @return void
     */
    protected function setPhpLocale(string $locale): void
    {
        // Map application locale codes to PHP locale codes
        $phpLocale = $this->getPhpLocaleCode($locale);

        // Try to set locale (may not be available on all systems)
        if ($phpLocale) {
            try {
                setlocale(LC_ALL, $phpLocale);
            } catch (\Exception $e) {
                // Silently fail if locale not available
                // System will continue using default locale
            }
        }
    }

    /**
     * Get PHP locale code from application locale code
     *
     * @param string $locale Application locale code
     * @return string|null PHP locale code
     */
    protected function getPhpLocaleCode(string $locale): ?string
    {
        // Map application locales to PHP locales
        // Multiple variants provided for maximum compatibility
        $localeMap = [
            'en' => ['en_US.UTF-8', 'en_US', 'en'],
            'fr' => ['fr_FR.UTF-8', 'fr_FR', 'fr'],
            'de' => ['de_DE.UTF-8', 'de_DE', 'de'],
            'es' => ['es_ES.UTF-8', 'es_ES', 'es'],
            'it' => ['it_IT.UTF-8', 'it_IT', 'it'],
            'pt' => ['pt_BR.UTF-8', 'pt_BR', 'pt'],
            'ru' => ['ru_RU.UTF-8', 'ru_RU', 'ru'],
            'ar' => ['ar_AE.UTF-8', 'ar_AE', 'ar'],
            'zh' => ['zh_CN.UTF-8', 'zh_CN', 'zh'],
            'ja' => ['ja_JP.UTF-8', 'ja_JP', 'ja'],
            'ko' => ['ko_KR.UTF-8', 'ko_KR', 'ko'],
            'hi' => ['hi_IN.UTF-8', 'hi_IN', 'hi'],
        ];

        // Return first available variant or default
        return $localeMap[$locale][0] ?? 'en_US.UTF-8';
    }

    /**
     * Get user's saved timezone preference
     *
     * @param int|null $userId User ID
     * @return string|null Timezone identifier
     */
    protected function getUserTimezone(?int $userId): ?string
    {
        if (!$userId) {
            return null;
        }

        try {
            // Check if User model exists and has timezone attribute
            if (class_exists('\App\Models\User')) {
                $user = \App\Models\User::find($userId);
                if ($user && isset($user->timezone)) {
                    return $user->timezone;
                }
            }
        } catch (\Exception $e) {
            // Silently fail if User model not available or database issue
        }

        return null;
    }
}
