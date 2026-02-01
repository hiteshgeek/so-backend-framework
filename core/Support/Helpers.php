<?php

/**
 * Helper Functions
 *
 * Global helper functions for the framework
 */

if (!function_exists('env')) {
    /**
     * Get environment variable value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return \Core\Support\Env::get($key, $default);
    }
}

if (!function_exists('config')) {
    /**
     * Get configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config(string $key, mixed $default = null): mixed
    {
        return app('config')->get($key, $default);
    }
}

if (!function_exists('app')) {
    /**
     * Get application instance or resolve from container
     *
     * @param string|null $abstract
     * @return mixed
     */
    function app(?string $abstract = null): mixed
    {
        $app = \Core\Application::getInstance();

        if ($abstract === null) {
            return $app;
        }

        return $app->make($abstract);
    }
}

if (!function_exists('base_path')) {
    /**
     * Get base path
     *
     * @param string $path
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return app()->basePath($path);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get storage path
     *
     * @param string $path
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        return base_path('storage' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (!function_exists('public_path')) {
    /**
     * Get public path
     *
     * @param string $path
     * @return string
     */
    function public_path(string $path = ''): string
    {
        return base_path('public' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (!function_exists('config_path')) {
    /**
     * Get config path
     *
     * @param string $path
     * @return string
     */
    function config_path(string $path = ''): string
    {
        return base_path('config' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (!function_exists('auth')) {
    /**
     * Get authentication instance
     *
     * @return \Core\Auth\Auth
     */
    function auth(): \Core\Auth\Auth
    {
        return app('auth');
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token
     *
     * @return string
     */
    function csrf_token(): string
    {
        return \Core\Security\Csrf::token();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input field
     *
     * @return string
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('jwt')) {
    /**
     * Get JWT instance from configuration
     *
     * @return \Core\Security\JWT
     */
    function jwt(): \Core\Security\JWT
    {
        return \Core\Security\JWT::fromConfig();
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function old(string $key, mixed $default = null): mixed
    {
        return session()->getOld($key, $default);
    }
}

if (!function_exists('session')) {
    /**
     * Get session instance or value
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function session(?string $key = null, mixed $default = null): mixed
    {
        $session = app('session');

        if ($key === null) {
            return $session;
        }

        return $session->get($key, $default);
    }
}

if (!function_exists('cache')) {
    /**
     * Get cache instance or value
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function cache(?string $key = null, mixed $default = null): mixed
    {
        $cache = app('cache');

        if ($key === null) {
            return $cache;
        }

        return $cache->get($key, $default);
    }
}

if (!function_exists('activity')) {
    /**
     * Get activity logger instance
     *
     * @param string|null $logName
     * @return \Core\ActivityLog\ActivityLogger
     */
    function activity(?string $logName = null): \Core\ActivityLog\ActivityLogger
    {
        $logger = app('activity.logger');

        if ($logName !== null) {
            return $logger->inLog($logName);
        }

        return $logger;
    }
}

if (!function_exists('queue')) {
    /**
     * Get queue manager instance or connection
     *
     * @param string|null $connection
     * @return \Core\Queue\QueueManager|\Core\Queue\DatabaseQueue
     */
    function queue(?string $connection = null)
    {
        $manager = app('queue');

        if ($connection !== null) {
            return $manager->connection($connection);
        }

        return $manager;
    }
}

if (!function_exists('dispatch')) {
    /**
     * Dispatch a job to the queue
     *
     * @param \Core\Queue\Job $job
     * @param string|null $queue
     * @return string Job ID
     */
    function dispatch(\Core\Queue\Job $job, ?string $queue = null): string
    {
        return app('queue')->push($job, $queue);
    }
}

if (!function_exists('url')) {
    /**
     * Generate URL for path
     *
     * @param string $path
     * @return string
     */
    function url(string $path = ''): string
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $path = ltrim($path, '/');

        return $baseUrl . ($path ? '/' . $path : '');
    }
}

if (!function_exists('route')) {
    /**
     * Generate URL for named route
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    function route(string $name, array $parameters = []): string
    {
        return app('router')->url($name, $parameters);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create redirect response
     *
     * @param string $url
     * @param int $status
     * @return \Core\Http\RedirectResponse
     */
    function redirect(string $url, int $status = 302): \Core\Http\RedirectResponse
    {
        return new \Core\Http\RedirectResponse($url, $status);
    }
}

if (!function_exists('back')) {
    /**
     * Redirect back
     *
     * @return \Core\Http\RedirectResponse
     */
    function back(): \Core\Http\RedirectResponse
    {
        return redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
}

if (!function_exists('response')) {
    /**
     * Create response
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     * @return \Core\Http\Response
     */
    function response(string $content = '', int $status = 200, array $headers = []): \Core\Http\Response
    {
        return new \Core\Http\Response($content, $status, $headers);
    }
}

if (!function_exists('request')) {
    /**
     * Get the current request instance
     *
     * @return \Core\Http\Request
     */
    function request(): \Core\Http\Request
    {
        return app('request') ?? new \Core\Http\Request();
    }
}

if (!function_exists('json')) {
    /**
     * Create JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return \Core\Http\JsonResponse
     */
    function json(array $data, int $status = 200, array $headers = []): \Core\Http\JsonResponse
    {
        return new \Core\Http\JsonResponse($data, $status, $headers);
    }
}

if (!function_exists('view')) {
    /**
     * Render view
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    function view(string $view, array $data = []): string
    {
        return app('view')->render($view, $data);
    }
}

if (!function_exists('abort')) {
    /**
     * Abort with HTTP exception
     *
     * @param int $code
     * @param string $message
     * @return never
     */
    function abort(int $code, string $message = ''): never
    {
        throw new \Core\Exceptions\HttpException($message ?: "HTTP Error $code", $code);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die
     *
     * @param mixed ...$vars
     * @return never
     */
    function dd(mixed ...$vars): never
    {
        foreach ($vars as $var) {
            var_dump($var);
        }
        die(1);
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML entities
     *
     * @param string $value
     * @return string
     */
    function e(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('sanitize')) {
    /**
     * Sanitize input data
     *
     * @param mixed $data
     * @return mixed
     */
    function sanitize($data)
    {
        return \Core\Security\Sanitizer::clean($data);
    }
}

if (!function_exists('now')) {
    /**
     * Get current DateTime
     *
     * @return \DateTime
     */
    function now(): \DateTime
    {
        return new \DateTime();
    }
}

if (!function_exists('collect')) {
    /**
     * Create collection from array
     *
     * @param array $items
     * @return \Core\Support\Collection
     */
    function collect(array $items = []): \Core\Support\Collection
    {
        return new \Core\Support\Collection($items);
    }
}

if (!function_exists('value')) {
    /**
     * Return default value of value
     *
     * @param mixed $value
     * @return mixed
     */
    function value(mixed $value): mixed
    {
        return $value instanceof \Closure ? $value() : $value;
    }
}

if (!function_exists('with')) {
    /**
     * Return the given value
     *
     * @param mixed $value
     * @return mixed
     */
    function with(mixed $value): mixed
    {
        return $value;
    }
}

if (!function_exists('blank')) {
    /**
     * Determine if value is blank
     *
     * @param mixed $value
     * @return bool
     */
    function blank(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_countable($value)) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('filled')) {
    /**
     * Determine if value is filled
     *
     * @param mixed $value
     * @return bool
     */
    function filled(mixed $value): bool
    {
        return !blank($value);
    }
}

if (!function_exists('class_basename')) {
    /**
     * Get class basename
     *
     * @param string|object $class
     * @return string
     */
    function class_basename(string|object $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('str_contains')) {
    /**
     * Check if string contains substring
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_contains(string $haystack, string $needle): bool
    {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('str_starts_with')) {
    /**
     * Check if string starts with substring
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_starts_with(string $haystack, string $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_ends_with')) {
    /**
     * Check if string ends with substring
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_ends_with(string $haystack, string $needle): bool
    {
        $length = strlen($needle);
        return $length === 0 || substr($haystack, -$length) === $needle;
    }
}

if (!function_exists('logger')) {
    /**
     * Get logger instance or log a debug message
     *
     * @param string|null $message If provided, logs at debug level
     * @param array $context
     * @return \Core\Logging\Logger|null
     */
    function logger(?string $message = null, array $context = []): ?\Core\Logging\Logger
    {
        $log = app('logger');

        if ($message !== null) {
            $log->debug($message, $context);
            return null;
        }

        return $log;
    }
}

if (!function_exists('event')) {
    /**
     * Dispatch an event
     *
     * @param \Core\Events\Event|string $event
     * @param array $payload
     * @return array Listener responses
     */
    function event(\Core\Events\Event|string $event, array $payload = []): array
    {
        return app('events')->dispatch($event, $payload);
    }
}

if (!function_exists('validate')) {
    /**
     * Validate data against rules
     *
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @param array $messages Custom error messages
     * @return array Validated data
     * @throws \Core\Validation\ValidationException
     */
    function validate(array $data, array $rules, array $messages = []): array
    {
        $validator = new \Core\Validation\Validator($data, $rules, $messages);
        return $validator->validate();
    }
}

// ==========================================
// Router Helper Functions
// ==========================================

if (!function_exists('router')) {
    /**
     * Get the router instance
     *
     * @return \Core\Routing\Router
     */
    function router(): \Core\Routing\Router
    {
        return app('router');
    }
}

if (!function_exists('current_route')) {
    /**
     * Get the current route
     *
     * @return \Core\Routing\Route|null
     */
    function current_route(): ?\Core\Routing\Route
    {
        return \Core\Routing\Router::current();
    }
}

if (!function_exists('route_is')) {
    /**
     * Check if current route matches the given name(s)
     *
     * @param string ...$names Route names (supports wildcard *)
     * @return bool
     */
    function route_is(string ...$names): bool
    {
        return \Core\Routing\Router::is(...$names);
    }
}

if (!function_exists('current_route_name')) {
    /**
     * Get the current route name
     *
     * @return string|null
     */
    function current_route_name(): ?string
    {
        return \Core\Routing\Router::currentRouteName();
    }
}

if (!function_exists('current_route_action')) {
    /**
     * Get the current route action
     *
     * @return string|null
     */
    function current_route_action(): ?string
    {
        return \Core\Routing\Router::currentRouteAction();
    }
}

// ==========================================
// Asset Management Helpers
// ==========================================

if (!function_exists('asset')) {
    /**
     * Generate URL to a public asset with cache busting
     *
     * @param string $path Path relative to public/assets/ (e.g., 'css/base.css')
     * @return string Full URL with version query string
     */
    function asset(string $path): string
    {
        return app('assets')->url($path);
    }
}

if (!function_exists('assets')) {
    /**
     * Get the AssetManager instance
     *
     * @return \Core\Support\AssetManager
     */
    function assets(): \Core\Support\AssetManager
    {
        return app('assets');
    }
}

if (!function_exists('push_stack')) {
    /**
     * Push content onto a named asset stack
     *
     * @param string $name Stack name ('styles', 'scripts', etc.)
     * @param string $content Raw content
     * @param int $priority Lower = rendered first (default 50)
     */
    function push_stack(string $name, string $content, int $priority = 50): void
    {
        app('assets')->push($name, $content, $priority);
    }
}

if (!function_exists('render_stack')) {
    /**
     * Render a named asset stack
     *
     * @param string $name Stack name
     * @return string
     */
    function render_stack(string $name): string
    {
        return app('assets')->renderStack($name);
    }
}

if (!function_exists('render_assets')) {
    /**
     * Render all registered assets for a position
     *
     * @param string $position 'head' or 'body_end'
     * @return string HTML tags
     */
    function render_assets(string $position): string
    {
        return app('assets')->renderAssets($position);
    }
}

if (!function_exists('profiler')) {
    /**
     * Get the Profiler instance
     *
     * @return \Core\Debug\Profiler
     */
    function profiler(): \Core\Debug\Profiler
    {
        return \Core\Debug\Profiler::getInstance();
    }
}

// ============================================
// Localization Helpers
// ============================================

if (!function_exists('trans')) {
    /**
     * Translate the given message
     *
     * @param string $key Translation key (e.g., 'validation.required')
     * @param array $replace Replacement parameters
     * @param string|null $locale Override locale
     * @return string
     */
    function trans(string $key, array $replace = [], ?string $locale = null): string
    {
        return app('translator')->get($key, $replace, $locale);
    }
}

if (!function_exists('__')) {
    /**
     * Translate the given message (alias for trans)
     *
     * @param string $key Translation key
     * @param array $replace Replacement parameters
     * @param string|null $locale Override locale
     * @return string
     */
    function __(string $key, array $replace = [], ?string $locale = null): string
    {
        return trans($key, $replace, $locale);
    }
}

if (!function_exists('trans_choice')) {
    /**
     * Translate with pluralization
     *
     * @param string $key Translation key
     * @param int $count Count for pluralization
     * @param array $replace Replacement parameters
     * @param string|null $locale Override locale
     * @return string
     */
    function trans_choice(string $key, int $count, array $replace = [], ?string $locale = null): string
    {
        return app('translator')->choice($key, $count, array_merge($replace, ['count' => $count]), $locale);
    }
}

if (!function_exists('locale')) {
    /**
     * Get or set current locale
     *
     * @param string|null $locale Locale to set (optional)
     * @return string
     */
    function locale(?string $locale = null): string
    {
        $manager = app('locale');

        if ($locale !== null) {
            $manager->setLocale($locale);
        }

        return $manager->getCurrentLocale();
    }
}

if (!function_exists('setLocale')) {
    /**
     * Set the current locale
     *
     * @param string $locale Locale code
     * @return void
     */
    function setLocale(string $locale): void
    {
        app('locale')->setLocale($locale);
    }
}

if (!function_exists('getLocale')) {
    /**
     * Get the current locale
     *
     * @return string
     */
    function getLocale(): string
    {
        return app('locale')->getCurrentLocale();
    }
}

// ============================================
// Formatting Helpers (Phase 2)
// ============================================

if (!function_exists('format_currency')) {
    /**
     * Format currency with locale
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code (USD, EUR, etc.)
     * @param string|null $locale Override locale
     * @return string
     */
    function format_currency(float $amount, string $currency = 'USD', ?string $locale = null): string
    {
        $formatter = app('currency.formatter');

        if ($formatter === null) {
            // Fallback if formatter not available yet
            return $currency . ' ' . number_format($amount, 2);
        }

        return $formatter->format($amount, $currency, $locale);
    }
}

if (!function_exists('format_number')) {
    /**
     * Format number with locale
     *
     * @param float $number Number to format
     * @param int $decimals Decimal places
     * @param string|null $locale Override locale
     * @return string
     */
    function format_number(float $number, int $decimals = 2, ?string $locale = null): string
    {
        $formatter = app('number.formatter');

        if ($formatter === null) {
            // Fallback if formatter not available yet
            return number_format($number, $decimals);
        }

        return $formatter->format($number, $decimals, $locale);
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date with locale
     *
     * @param \DateTime|string $date Date to format
     * @param string $format Format preset (short, medium, long, full) or custom
     * @param string|null $locale Override locale
     * @return string
     */
    function format_date(\DateTime|string $date, string $format = 'medium', ?string $locale = null): string
    {
        $formatter = app('datetime.formatter');

        if ($formatter === null) {
            // Fallback if formatter not available yet
            $dateObj = is_string($date) ? new \DateTime($date) : $date;
            return $dateObj->format('Y-m-d');
        }

        return $formatter->formatDate($date, $format, $locale);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime with locale and timezone
     *
     * @param \DateTime|string $datetime DateTime to format
     * @param string $format Format preset or custom
     * @param string|null $locale Override locale
     * @param string|null $timezone Override timezone
     * @return string
     */
    function format_datetime(\DateTime|string $datetime, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
    {
        $formatter = app('datetime.formatter');

        if ($formatter === null) {
            // Fallback if formatter not available yet
            $dateObj = is_string($datetime) ? new \DateTime($datetime) : $datetime;
            return $dateObj->format('Y-m-d H:i:s');
        }

        return $formatter->format($datetime, $format, $locale, $timezone);
    }
}

if (!function_exists('timezone')) {
    /**
     * Get or set current timezone
     *
     * @param string|null $timezone Timezone to set (optional)
     * @return string
     */
    function timezone(?string $timezone = null): string
    {
        $manager = app('locale');

        if ($timezone !== null) {
            $manager->setTimezone($timezone);
        }

        return $manager->getTimezone();
    }
}

// ============================================
// RTL & Text Direction Helpers
// ============================================

if (!function_exists('is_rtl')) {
    /**
     * Check if current or specified locale is RTL (Right-to-Left)
     *
     * @param string|null $locale Locale to check (null = current)
     * @return bool
     */
    function is_rtl(?string $locale = null): bool
    {
        return app('locale')->isRtl($locale);
    }
}

if (!function_exists('text_direction')) {
    /**
     * Get text direction for locale
     *
     * @param string|null $locale Locale (null = current)
     * @return string 'ltr' or 'rtl'
     */
    function text_direction(?string $locale = null): string
    {
        return app('locale')->getDirection($locale);
    }
}

if (!function_exists('html_dir')) {
    /**
     * Get HTML dir attribute value for locale
     *
     * @param string|null $locale Locale (null = current)
     * @return string 'ltr' or 'rtl'
     */
    function html_dir(?string $locale = null): string
    {
        return app('locale')->getHtmlDir($locale);
    }
}

if (!function_exists('dir_class')) {
    /**
     * Get CSS direction class for locale
     *
     * @param string|null $locale Locale (null = current)
     * @return string 'dir-ltr' or 'dir-rtl'
     */
    function dir_class(?string $locale = null): string
    {
        return app('locale')->getDirectionClass($locale);
    }
}

// ============================================
// ICU MessageFormat Helpers
// ============================================

if (!function_exists('icu')) {
    /**
     * Format message using ICU MessageFormat
     *
     * Supports: select, plural, number, date, time patterns
     *
     * @param string $key Translation key containing ICU pattern
     * @param array $args Arguments for the pattern
     * @param string|null $locale Locale (null = current)
     * @return string Formatted message
     */
    function icu(string $key, array $args = [], ?string $locale = null): string
    {
        $pattern = trans($key);
        $formatter = new \Core\Localization\MessageFormatter();
        return $formatter->format($pattern, $args, $locale);
    }
}

if (!function_exists('icu_format')) {
    /**
     * Format a raw ICU pattern (not from translation files)
     *
     * @param string $pattern ICU message pattern
     * @param array $args Arguments
     * @param string|null $locale Locale
     * @return string
     */
    function icu_format(string $pattern, array $args = [], ?string $locale = null): string
    {
        $formatter = new \Core\Localization\MessageFormatter();
        return $formatter->format($pattern, $args, $locale);
    }
}

// ============================================
// CLDR Pluralization Helpers
// ============================================

if (!function_exists('plural_category')) {
    /**
     * Get CLDR plural category for a number in the current locale
     *
     * @param int|float $count Number
     * @param string|null $locale Locale (null = current)
     * @return string Category (zero, one, two, few, many, other)
     */
    function plural_category(int|float $count, ?string $locale = null): string
    {
        $locale = $locale ?? locale();
        $rule = \Core\Localization\Pluralization\PluralRules::forLocale($locale);
        return $rule->getCategory($count);
    }
}

if (!function_exists('plural_forms')) {
    /**
     * Get number of plural forms for a locale
     *
     * @param string|null $locale Locale (null = current)
     * @return int Number of forms
     */
    function plural_forms(?string $locale = null): int
    {
        $locale = $locale ?? locale();
        $rule = \Core\Localization\Pluralization\PluralRules::forLocale($locale);
        return $rule->getFormCount();
    }
}

// ============================================
// Locale Information Helpers
// ============================================

if (!function_exists('locale_name')) {
    /**
     * Get display name for a locale
     *
     * @param string|null $locale Locale to get name for (null = current)
     * @param string|null $displayLocale Locale for display (null = current)
     * @return string Locale name
     */
    function locale_name(?string $locale = null, ?string $displayLocale = null): string
    {
        return app('locale')->getLocaleName($locale, $displayLocale);
    }
}

if (!function_exists('locale_native_name')) {
    /**
     * Get native name for a locale (in its own language)
     *
     * @param string|null $locale Locale (null = current)
     * @return string Native locale name
     */
    function locale_native_name(?string $locale = null): string
    {
        return app('locale')->getNativeName($locale);
    }
}

if (!function_exists('language_code')) {
    /**
     * Extract language code from locale
     *
     * @param string|null $locale Full locale (null = current)
     * @return string Language code (e.g., 'en' from 'en_US')
     */
    function language_code(?string $locale = null): string
    {
        $locale = $locale ?? locale();
        return app('locale')->getLanguageCode($locale);
    }
}

if (!function_exists('region_code')) {
    /**
     * Extract region/country code from locale
     *
     * @param string|null $locale Full locale (null = current)
     * @return string|null Region code (e.g., 'US' from 'en_US')
     */
    function region_code(?string $locale = null): ?string
    {
        $locale = $locale ?? locale();
        return app('locale')->getRegionCode($locale);
    }
}

// ============================================
// Media/CDN Helpers
// ============================================

if (!function_exists('media_url')) {
    /**
     * Get URL for a media file (with CDN support if enabled)
     *
     * @param string $path Relative path
     * @param string|null $disk Storage disk
     * @return string URL
     */
    function media_url(string $path, ?string $disk = null): string
    {
        return (new \Core\Media\StorageManager())->getUrl($path, $disk);
    }
}

if (!function_exists('cdn_url')) {
    /**
     * Get CDN URL for a path (if CDN enabled)
     *
     * @param string $path Relative path
     * @return string CDN URL or original path
     */
    function cdn_url(string $path): string
    {
        return (new \Core\Media\CdnManager())->getUrl($path);
    }
}

if (!function_exists('is_cdn_enabled')) {
    /**
     * Check if CDN is enabled
     *
     * @return bool
     */
    function is_cdn_enabled(): bool
    {
        return (new \Core\Media\CdnManager())->isEnabled();
    }
}
