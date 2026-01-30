<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;
use Core\Exceptions\NotFoundException;

/**
 * Router Class
 *
 * Provides Laravel-style routing with support for:
 * - HTTP methods (GET, POST, PUT, DELETE, PATCH, ANY)
 * - Route parameters with constraints
 * - Route groups with prefix and middleware
 * - Named routes and URL generation
 * - Resource and API resource routes
 * - Fallback routes
 * - Route redirects and views
 * - Route model binding
 * - Current route helpers
 */
class Router
{
    protected static array $routes = [];
    protected static array $namedRoutes = [];
    protected static array $groupStack = [];
    protected static array $globalMiddleware = [];
    protected static array $middlewareGroups = [];
    protected static array $middlewareAliases = [];
    protected static ?Route $fallbackRoute = null;
    protected static ?Route $currentRoute = null;

    public static function get(string $uri, $action): Route
    {
        return self::addRoute(['GET'], $uri, $action);
    }

    public static function post(string $uri, $action): Route
    {
        return self::addRoute(['POST'], $uri, $action);
    }

    public static function put(string $uri, $action): Route
    {
        return self::addRoute(['PUT'], $uri, $action);
    }

    public static function delete(string $uri, $action): Route
    {
        return self::addRoute(['DELETE'], $uri, $action);
    }

    public static function patch(string $uri, $action): Route
    {
        return self::addRoute(['PATCH'], $uri, $action);
    }

    public static function any(string $uri, $action): Route
    {
        return self::addRoute(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], $uri, $action);
    }

    /**
     * Register a route for multiple HTTP methods
     *
     * @param array $methods HTTP methods (e.g., ['GET', 'POST'])
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public static function match(array $methods, string $uri, $action): Route
    {
        $methods = array_map('strtoupper', $methods);
        return self::addRoute($methods, $uri, $action);
    }

    protected static function addRoute(array $methods, string $uri, $action): Route
    {
        $uri = self::prefix($uri);
        $route = new Route($methods, $uri, $action);

        // Apply group middleware
        if (!empty(self::$groupStack)) {
            $lastGroup = end(self::$groupStack);
            if (isset($lastGroup['middleware'])) {
                $route->middleware($lastGroup['middleware']);
            }
        }

        self::$routes[] = $route;
        return $route;
    }

    public static function group(array $attributes, callable $callback): void
    {
        self::$groupStack[] = $attributes;
        $callback();
        array_pop(self::$groupStack);
    }

    /**
     * Register global middleware (applied to all routes)
     *
     * @param array|string $middleware
     * @return void
     */
    public static function globalMiddleware($middleware): void
    {
        $middleware = is_array($middleware) ? $middleware : [$middleware];
        self::$globalMiddleware = array_merge(self::$globalMiddleware, $middleware);
    }

    /**
     * Register a named middleware group
     *
     * Usage:
     *   Router::middlewareGroup('web', [CsrfMiddleware::class, SessionMiddleware::class]);
     *   Router::group(['middleware' => 'web'], function () { ... });
     */
    public static function middlewareGroup(string $name, array $middleware): void
    {
        self::$middlewareGroups[$name] = $middleware;
    }

    /**
     * Register a middleware alias (shorthand name for a class)
     *
     * Usage:
     *   Router::middlewareAlias('auth', AuthMiddleware::class);
     *   Route::get('/profile', ...)->middleware('auth');
     */
    public static function middlewareAlias(string $alias, string $middlewareClass): void
    {
        self::$middlewareAliases[$alias] = $middlewareClass;
    }

    /**
     * Resolve middleware names — expand groups and aliases to class names
     */
    protected static function resolveMiddleware(array $middleware): array
    {
        $resolved = [];

        foreach ($middleware as $item) {
            // Strip parameters for resolution lookup
            $name = is_string($item) && str_contains($item, ':') ? explode(':', $item, 2)[0] : $item;
            $params = is_string($item) && str_contains($item, ':') ? ':' . explode(':', $item, 2)[1] : '';

            // Check if it's a group name
            if (is_string($name) && isset(self::$middlewareGroups[$name])) {
                // Recursively resolve the group (groups can't have params)
                $resolved = array_merge($resolved, self::resolveMiddleware(self::$middlewareGroups[$name]));
                continue;
            }

            // Check if it's an alias
            if (is_string($name) && isset(self::$middlewareAliases[$name])) {
                $resolved[] = self::$middlewareAliases[$name] . $params;
                continue;
            }

            // Otherwise it's a class name (pass through)
            $resolved[] = $item;
        }

        return array_unique($resolved);
    }

    public static function resource(string $name, string $controller): void
    {
        self::get("/{$name}", [$controller, 'index']);
        self::get("/{$name}/create", [$controller, 'create']);
        self::post("/{$name}", [$controller, 'store']);
        self::get("/{$name}/{id}", [$controller, 'show']);
        self::get("/{$name}/{id}/edit", [$controller, 'edit']);
        self::put("/{$name}/{id}", [$controller, 'update']);
        self::delete("/{$name}/{id}", [$controller, 'destroy']);
    }

    /**
     * Register API resource routes (without create/edit)
     *
     * @param string $name Resource name
     * @param string $controller Controller class
     * @return void
     */
    public static function apiResource(string $name, string $controller): void
    {
        self::get("/{$name}", [$controller, 'index']);
        self::post("/{$name}", [$controller, 'store']);
        self::get("/{$name}/{id}", [$controller, 'show']);
        self::put("/{$name}/{id}", [$controller, 'update']);
        self::delete("/{$name}/{id}", [$controller, 'destroy']);
    }

    /**
     * Register a fallback route for unmatched requests
     *
     * @param mixed $action
     * @return Route
     */
    public static function fallback($action): Route
    {
        self::$fallbackRoute = new Route(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{fallback}', $action);
        self::$fallbackRoute->where('fallback', '.*');
        return self::$fallbackRoute;
    }

    /**
     * Register a redirect route
     *
     * @param string $uri
     * @param string $destination
     * @param int $status HTTP status code (default 302)
     * @return Route
     */
    public static function redirect(string $uri, string $destination, int $status = 302): Route
    {
        return self::any($uri, function () use ($destination, $status) {
            return redirect($destination, $status);
        });
    }

    /**
     * Register a permanent redirect route (301)
     *
     * @param string $uri
     * @param string $destination
     * @return Route
     */
    public static function permanentRedirect(string $uri, string $destination): Route
    {
        return self::redirect($uri, $destination, 301);
    }

    /**
     * Register a view route
     *
     * @param string $uri
     * @param string $view View name
     * @param array $data Data to pass to view
     * @return Route
     */
    public static function view(string $uri, string $view, array $data = []): Route
    {
        return self::get($uri, function () use ($view, $data) {
            return Response::view($view, $data);
        });
    }

    protected static function prefix(string $uri): string
    {
        if (empty(self::$groupStack)) {
            return '/' . trim($uri, '/');
        }

        $lastGroup = end(self::$groupStack);
        $prefix = $lastGroup['prefix'] ?? '';

        return '/' . trim(trim($prefix, '/') . '/' . trim($uri, '/'), '/');
    }

    public function dispatch(Request $request): Response
    {
        foreach (self::$routes as $route) {
            if ($route->matches($request)) {
                self::$currentRoute = $route;
                return $this->runRouteWithMiddleware($route, $request);
            }
        }

        // Try fallback route if no match found
        if (self::$fallbackRoute !== null) {
            self::$currentRoute = self::$fallbackRoute;
            return $this->runRouteWithMiddleware(self::$fallbackRoute, $request);
        }

        throw new NotFoundException('Route not found: ' . $request->uri());
    }

    protected function runRouteWithMiddleware(Route $route, Request $request): Response
    {
        // Merge global middleware with route middleware, then resolve groups/aliases
        $middleware = self::resolveMiddleware(
            array_merge(self::$globalMiddleware, $route->getMiddleware())
        );

        if (empty($middleware)) {
            return $route->run($request);
        }

        // Build middleware pipeline
        $pipeline = array_reduce(
            array_reverse($middleware),
            function ($next, $middleware) {
                return function ($request) use ($next, $middleware) {
                    // Parse middleware parameters (e.g. "App\Middleware\Throttle:5,1")
                    $parameters = [];
                    if (is_string($middleware) && str_contains($middleware, ':')) {
                        [$middleware, $paramString] = explode(':', $middleware, 2);
                        $parameters = explode(',', $paramString);
                    }

                    $middlewareInstance = app()->make($middleware);
                    return $middlewareInstance->handle($request, $next, ...$parameters);
                };
            },
            function ($request) use ($route) {
                return $route->run($request);
            }
        );

        return $pipeline($request);
    }

    public function url(string $name, array $parameters = []): string
    {
        if (!isset(self::$namedRoutes[$name])) {
            throw new \Exception("Route [{$name}] not found");
        }

        $route = self::$namedRoutes[$name];
        $uri = $route->getUri();

        foreach ($parameters as $key => $value) {
            $uri = str_replace("{{$key}}", $value, $uri);
        }

        return url($uri);
    }

    public static function registerNamed(string $name, Route $route): void
    {
        self::$namedRoutes[$name] = $route;
    }

    // ==========================================
    // Current Route Helpers
    // ==========================================

    /**
     * Get the current route
     *
     * @return Route|null
     */
    public static function current(): ?Route
    {
        return self::$currentRoute;
    }

    /**
     * Get the current route name
     *
     * @return string|null
     */
    public static function currentRouteName(): ?string
    {
        return self::$currentRoute?->getName();
    }

    /**
     * Get the current route action
     *
     * @return string|null
     */
    public static function currentRouteAction(): ?string
    {
        if (!self::$currentRoute) {
            return null;
        }

        $action = self::$currentRoute->getAction();

        if (is_array($action)) {
            return $action[0] . '@' . $action[1];
        }

        if ($action instanceof \Closure) {
            return 'Closure';
        }

        return is_string($action) ? $action : null;
    }

    /**
     * Check if the current route name matches the given pattern
     *
     * @param string ...$patterns
     * @return bool
     */
    public static function is(string ...$patterns): bool
    {
        $currentName = self::currentRouteName();

        if ($currentName === null) {
            return false;
        }

        foreach ($patterns as $pattern) {
            // Support wildcard matching
            if (str_contains($pattern, '*')) {
                $regex = str_replace('*', '.*', preg_quote($pattern, '/'));
                if (preg_match('/^' . $regex . '$/', $currentName)) {
                    return true;
                }
            } elseif ($pattern === $currentName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all registered routes
     *
     * @return array
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * Get all named routes
     *
     * @return array
     */
    public static function getNamedRoutes(): array
    {
        return self::$namedRoutes;
    }

    /**
     * Check if a named route exists
     *
     * @param string $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return isset(self::$namedRoutes[$name]);
    }

    /**
     * Clear all routes (useful for testing)
     *
     * @return void
     */
    public static function clear(): void
    {
        self::$routes = [];
        self::$namedRoutes = [];
        self::$groupStack = [];
        self::$fallbackRoute = null;
        self::$currentRoute = null;
    }
}
