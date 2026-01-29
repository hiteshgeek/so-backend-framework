<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;
use Core\Exceptions\NotFoundException;

/**
 * Router Class
 */
class Router
{
    protected static array $routes = [];
    protected static array $namedRoutes = [];
    protected static array $groupStack = [];

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
                return $this->runRouteWithMiddleware($route, $request);
            }
        }

        throw new NotFoundException('Route not found: ' . $request->uri());
    }

    protected function runRouteWithMiddleware(Route $route, Request $request): Response
    {
        $middleware = $route->getMiddleware();

        if (empty($middleware)) {
            return $route->run($request);
        }

        // Build middleware pipeline
        $pipeline = array_reduce(
            array_reverse($middleware),
            function ($next, $middleware) {
                return function ($request) use ($next, $middleware) {
                    $middlewareInstance = app()->make($middleware);
                    return $middlewareInstance->handle($request, $next);
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
}
