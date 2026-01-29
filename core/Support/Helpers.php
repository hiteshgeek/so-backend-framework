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
