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

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token
     *
     * @return string|null
     */
    function csrf_token(): ?string
    {
        return app('csrf')->getToken();
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
        $token = csrf_token();
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8') . '">';
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
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
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
        return str_contains($haystack, $needle);
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
        return str_starts_with($haystack, $needle);
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
        return str_ends_with($haystack, $needle);
    }
}
