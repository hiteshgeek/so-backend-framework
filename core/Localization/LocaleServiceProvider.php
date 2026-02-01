<?php

namespace Core\Localization;

use Core\Container\Container;

/**
 * LocaleServiceProvider
 *
 * Registers all localization services in the dependency injection container.
 * Services: Translator, LocaleManager, TranslationLoader, Formatters
 */
class LocaleServiceProvider
{
    /**
     * Container instance
     */
    protected Container $app;

    /**
     * Constructor
     *
     * @param Container $app Application container
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Register services in the container
     *
     * @return void
     */
    public function register(): void
    {
        // Register TranslationLoader
        $this->app->singleton('translation.loader', function ($app) {
            $loader = new TranslationLoader();
            $loader->addNamespace('*', base_path('resources/lang'));
            return $loader;
        });

        // Register Translator
        $this->app->singleton('translator', function ($app) {
            $loader = $app->make('translation.loader');
            $locale = config('app.locale', 'en');
            $fallback = config('app.fallback_locale', 'en');

            return new Translator($loader, $locale, $fallback);
        });

        // Register LocaleManager
        $this->app->singleton('locale', function ($app) {
            $translator = $app->make('translator');

            // Get available locales from config
            $availableLocales = config('localization.available_locales',
                config('app.available_locales', ['en']));

            // Handle both array formats: ['en', 'fr'] or ['en' => 'English', 'fr' => 'Français']
            if (!empty($availableLocales) && is_array(current($availableLocales))) {
                // It's associative array, extract keys
                $availableLocales = array_keys($availableLocales);
            }

            $defaultLocale = config('app.locale', 'en');

            return new LocaleManager($translator, $availableLocales, $defaultLocale);
        });

        // Register formatters (will be added in Phase 2)
        $this->registerFormatters();
    }

    /**
     * Register formatter services
     *
     * @return void
     */
    protected function registerFormatters(): void
    {
        // CurrencyFormatter
        $this->app->singleton('currency.formatter', function ($app) {
            // Check if class exists (Phase 2 implementation)
            if (class_exists('Core\Localization\Formatters\CurrencyFormatter')) {
                return new \Core\Localization\Formatters\CurrencyFormatter(
                    $app->make('locale')
                );
            }
            return null;
        });

        // NumberFormatter
        $this->app->singleton('number.formatter', function ($app) {
            // Check if class exists (Phase 2 implementation)
            if (class_exists('Core\Localization\Formatters\NumberFormatter')) {
                return new \Core\Localization\Formatters\NumberFormatter(
                    $app->make('locale')
                );
            }
            return null;
        });

        // DateTimeFormatter
        $this->app->singleton('datetime.formatter', function ($app) {
            // Check if class exists (Phase 2 implementation)
            if (class_exists('Core\Localization\Formatters\DateTimeFormatter')) {
                return new \Core\Localization\Formatters\DateTimeFormatter(
                    $app->make('locale')
                );
            }
            return null;
        });
    }

    /**
     * Boot the service (called after all providers are registered)
     *
     * @return void
     */
    public function boot(): void
    {
        // Set initial locale from config
        $locale = config('app.locale', 'en');
        $this->app->make('locale')->setLocale($locale);

        // Set initial timezone from config
        $timezone = config('app.timezone', 'UTC');
        $this->app->make('locale')->setTimezone($timezone);
    }
}
