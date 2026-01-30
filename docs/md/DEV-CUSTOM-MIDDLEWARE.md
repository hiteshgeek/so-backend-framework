# Creating Custom Middleware

A step-by-step guide to building your own middleware in the SO Backend Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Step 1: Create the Middleware Class](#step-1-create-the-middleware-class)
3. [Step 2: Implement handle()](#step-2-implement-handle)
4. [Before vs After Middleware](#before-vs-after-middleware)
5. [Short-Circuit Responses](#short-circuit-responses)
6. [Middleware with Parameters](#middleware-with-parameters)
7. [Registering Middleware](#registering-middleware)
8. [Practical Examples](#practical-examples)
   - [RoleMiddleware](#rolemiddleware)
   - [MaintenanceMiddleware](#maintenancemiddleware)
   - [JsonResponseMiddleware](#jsonresponsemiddleware)

---

## Overview

Middleware provides a mechanism for filtering and inspecting HTTP requests as they enter your application and responses as they leave. Each middleware sits in a **pipeline** -- the request passes through each middleware layer in order before reaching your controller, and the response passes back through each layer in reverse order on the way out.

```
Request ──> Middleware A ──> Middleware B ──> Controller
                                                 │
Response <── Middleware A <── Middleware B <───────┘
```

Common use cases for middleware include:

- **Authentication** -- verify the user is logged in before allowing access
- **Authorization** -- check that the user has the required role or permission
- **Logging** -- record request details for debugging and monitoring
- **Rate limiting** -- throttle requests to prevent abuse
- **Response transformation** -- add headers or modify the response body

Every middleware in the SO Framework implements `Core\Middleware\MiddlewareInterface` and follows a single, consistent pattern: receive a request, optionally call the next layer, and return a response.

---

## Step 1: Create the Middleware Class

Middleware classes live in the `app/Middleware/` directory. Create a new PHP file there and implement `Core\Middleware\MiddlewareInterface`.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class MyCustomMiddleware implements MiddlewareInterface
{
    /**
     * Handle the incoming request.
     *
     * @param Request  $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        // Your logic here...

        return $next($request);
    }
}
```

Key points:

- The namespace is `App\Middleware`.
- The class **must** implement `Core\Middleware\MiddlewareInterface`.
- The interface requires a single method: `handle(Request $request, callable $next): Response`.

---

## Step 2: Implement handle()

The `handle()` method receives two arguments:

| Argument   | Type       | Purpose                                                    |
|------------|------------|------------------------------------------------------------|
| `$request` | `Request`  | The current HTTP request object                            |
| `$next`    | `callable` | A callback that passes the request to the next middleware or controller |

Calling `$next($request)` hands control to the next layer in the pipeline. The return value of `$next()` is a `Response` object that you can inspect or modify before returning it yourself.

```php
public function handle(Request $request, callable $next): Response
{
    // 1. Inspect or modify the $request (before logic)

    // 2. Pass the request down the pipeline
    $response = $next($request);

    // 3. Inspect or modify the $response (after logic)

    // 4. Return the response
    return $response;
}
```

You **must** always return a `Response` from `handle()`. Either return the result of `$next($request)`, a modified version of it, or an entirely new `Response` that you construct yourself.

---

## Before vs After Middleware

Where you place your logic relative to the `$next($request)` call determines whether your middleware runs **before** or **after** the controller.

### Before Middleware

Logic that runs **before** the request reaches the controller. Place it above the `$next()` call. This is useful for validation, authentication, and request modification.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class TrimStringsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Runs BEFORE the controller
        // Trim whitespace from all string input values
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $request->set($key, trim($value));
            }
        }

        // Pass the modified request forward
        return $next($request);
    }
}
```

### After Middleware

Logic that runs **after** the controller has produced a response. Place it below the `$next()` call. This is useful for adding headers, logging, or transforming the response body.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class AddSecurityHeadersMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Let the controller handle the request first
        $response = $next($request);

        // Runs AFTER the controller
        // Add security headers to every response
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'DENY');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
```

### Combined (Before and After)

A single middleware can contain logic on both sides of the `$next()` call. The framework's built-in `LogRequestMiddleware` is a real-world example of this pattern -- it logs the incoming request before the controller and logs the response with timing data afterward.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class RequestTimingMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // BEFORE: record the start time
        $startTime = microtime(true);

        // Hand off to the next middleware / controller
        $response = $next($request);

        // AFTER: calculate duration and attach it as a header
        $durationMs = round((microtime(true) - $startTime) * 1000, 2);
        $response->header('X-Response-Time', $durationMs . 'ms');

        return $response;
    }
}
```

---

## Short-Circuit Responses

A middleware can **short-circuit** the pipeline by returning a `Response` directly without calling `$next()`. When you do this, no subsequent middleware or controller will execute. This is the standard pattern for authorization checks, maintenance mode, IP blocking, and similar guards.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;

class IpWhitelistMiddleware implements MiddlewareInterface
{
    protected array $allowedIps = [
        '192.168.1.100',
        '10.0.0.50',
    ];

    public function handle(Request $request, callable $next): Response
    {
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        if (!in_array($clientIp, $this->allowedIps)) {
            // Short-circuit: return 403 without calling $next()
            return JsonResponse::error('Access denied', 403);
        }

        // IP is allowed -- continue to the next layer
        return $next($request);
    }
}
```

When a middleware short-circuits:

- The `$next` callback is never invoked.
- No downstream middleware runs.
- The controller action is never called.
- The response returned by the middleware travels back up through any upstream middleware that already called `$next()`.

---

## Middleware with Parameters

Middleware can accept additional parameters beyond `$request` and `$next`. Declare them as extra arguments on the `handle()` method. Parameters are passed using **colon notation** when you attach the middleware to a route.

### Defining Parameters

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;

class RoleMiddleware implements MiddlewareInterface
{
    /**
     * @param Request  $request
     * @param callable $next
     * @param string   $role    The required role, passed via colon notation
     * @return Response
     */
    public function handle(Request $request, callable $next, string $role): Response
    {
        $user = $request->get('user');

        if (!$user || $user->role !== $role) {
            return JsonResponse::error('Insufficient permissions', 403);
        }

        return $next($request);
    }
}
```

### Applying Parameters with Colon Notation

Append a colon and the parameter value to the middleware class name:

```php
use Core\Routing\Router;
use App\Middleware\RoleMiddleware;

// Single parameter
Router::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware([RoleMiddleware::class . ':admin']);

// The string resolves to: "App\Middleware\RoleMiddleware:admin"
// The framework passes "admin" as the $role argument
```

### Multiple Parameters

Separate multiple values with commas. They are passed to the `handle()` method as positional arguments in order.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class ThrottleMiddleware implements MiddlewareInterface
{
    public function handle(
        Request $request,
        callable $next,
        ?string $maxAttempts = null,
        ?string $decayMinutes = null
    ): Response {
        $maxAttempts = $maxAttempts ? (int) $maxAttempts : 60;
        $decayMinutes = $decayMinutes ? (int) $decayMinutes : 1;

        // Rate limiting logic...

        return $next($request);
    }
}
```

```php
// Pass two parameters separated by comma
Router::get('/api/data', [DataController::class, 'index'])
    ->middleware([ThrottleMiddleware::class . ':100,5']);

// Resolves to: "App\Middleware\ThrottleMiddleware:100,5"
// $maxAttempts = "100", $decayMinutes = "5"
```

---

## Registering Middleware

There are three levels at which middleware can be applied: a single route, a route group, or globally to every route.

### On a Single Route

Use the `->middleware()` method when defining a route. Pass an array of middleware class names.

```php
use Core\Routing\Router;
use App\Middleware\AuthMiddleware;

Router::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

// Multiple middleware on one route
Router::post('/admin/users', [AdminController::class, 'store'])
    ->middleware([AuthMiddleware::class, RoleMiddleware::class . ':admin']);
```

Middleware executes in the order listed. In the example above, `AuthMiddleware` runs first. If it calls `$next()`, then `RoleMiddleware` runs next with the `admin` parameter.

### On a Route Group

Apply middleware to every route inside a group by including `middleware` in the group attributes array.

```php
use Core\Routing\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::put('/profile', [ProfileController::class, 'update']);
    Router::get('/settings', [SettingsController::class, 'index']);
});
```

Combine middleware with other group attributes like `prefix`:

```php
Router::group([
    'prefix' => 'admin',
    'middleware' => [AuthMiddleware::class, RoleMiddleware::class . ':admin']
], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
    Router::get('/users', [AdminController::class, 'users']);
    Router::get('/settings', [AdminController::class, 'settings']);
});

// Produces routes: /admin/dashboard, /admin/users, /admin/settings
// All protected by AuthMiddleware and RoleMiddleware
```

Nested groups inherit middleware from parent groups:

```php
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    // AuthMiddleware applied here
    Router::get('/dashboard', [DashboardController::class, 'index']);

    Router::group(['prefix' => 'admin', 'middleware' => [RoleMiddleware::class . ':admin']], function () {
        // Both AuthMiddleware AND RoleMiddleware applied here
        Router::get('/users', [AdminController::class, 'users']);
    });
});
```

### Globally (All Routes)

Global middleware runs on every request regardless of the route. Register it using `Router::globalMiddleware()`.

```php
use Core\Routing\Router;
use App\Middleware\CorsMiddleware;
use App\Middleware\CsrfMiddleware;

Router::globalMiddleware([
    CorsMiddleware::class,
    CsrfMiddleware::class,
]);
```

Global middleware executes before any route-specific or group middleware.

---

## Practical Examples

### RoleMiddleware

Checks that the authenticated user has a specific role before allowing access to a route. Short-circuits with a 403 response if the user lacks the required role.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;

/**
 * Role Middleware
 *
 * Restricts route access to users with a specific role.
 *
 * Usage:
 *   ->middleware([RoleMiddleware::class . ':admin'])
 *   ->middleware([RoleMiddleware::class . ':editor'])
 */
class RoleMiddleware implements MiddlewareInterface
{
    /**
     * Handle the request.
     *
     * @param Request  $request
     * @param callable $next
     * @param string   $role  The required role (passed via colon notation)
     * @return Response
     */
    public function handle(Request $request, callable $next, string $role): Response
    {
        $user = $request->get('user');

        // No authenticated user
        if (!$user) {
            return $this->denyAccess($request, 'Authentication required');
        }

        // User does not have the required role
        if (!isset($user->role) || $user->role !== $role) {
            return $this->denyAccess(
                $request,
                "This action requires the '{$role}' role"
            );
        }

        // User is authorized -- continue
        return $next($request);
    }

    /**
     * Return an appropriate denial response.
     *
     * @param Request $request
     * @param string  $message
     * @return Response
     */
    protected function denyAccess(Request $request, string $message): Response
    {
        // JSON response for API requests
        if ($request->expectsJson() || str_starts_with($request->uri(), 'api/')) {
            return JsonResponse::error($message, 403);
        }

        // Redirect for web requests
        return redirect(url('/'))
            ->with('error', $message);
    }
}
```

**Registering the RoleMiddleware:**

```php
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

// Protect a single route
Router::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware([AuthMiddleware::class, RoleMiddleware::class . ':admin']);

// Protect an entire group
Router::group([
    'prefix' => 'editor',
    'middleware' => [AuthMiddleware::class, RoleMiddleware::class . ':editor']
], function () {
    Router::get('/posts', [EditorController::class, 'posts']);
    Router::get('/drafts', [EditorController::class, 'drafts']);
});
```

---

### MaintenanceMiddleware

Returns a 503 Service Unavailable response when the application is in maintenance mode. Allows a list of whitelisted IPs to bypass maintenance mode for testing.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;

/**
 * Maintenance Middleware
 *
 * Short-circuits all requests with a 503 response when
 * maintenance mode is enabled, unless the client IP is whitelisted.
 *
 * Configuration:
 *   config('app.maintenance', false)
 *   config('app.maintenance_allowed_ips', [])
 */
class MaintenanceMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Check if maintenance mode is active
        if (!$this->isInMaintenance()) {
            return $next($request);
        }

        // Allow whitelisted IPs to bypass maintenance mode
        if ($this->isIpWhitelisted($request)) {
            return $next($request);
        }

        // Short-circuit: return 503 Service Unavailable
        return $this->maintenanceResponse($request);
    }

    /**
     * Check if the application is in maintenance mode.
     *
     * @return bool
     */
    protected function isInMaintenance(): bool
    {
        return config('app.maintenance', false);
    }

    /**
     * Check if the client IP is whitelisted.
     *
     * @param Request $request
     * @return bool
     */
    protected function isIpWhitelisted(Request $request): bool
    {
        $allowedIps = config('app.maintenance_allowed_ips', []);
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        return in_array($clientIp, $allowedIps);
    }

    /**
     * Build the maintenance mode response.
     *
     * @param Request $request
     * @return Response
     */
    protected function maintenanceResponse(Request $request): Response
    {
        $message = 'The application is currently undergoing maintenance. Please try again later.';

        // JSON response for API requests
        if ($request->expectsJson() || str_starts_with($request->uri(), 'api/')) {
            return JsonResponse::error($message, 503);
        }

        // HTML response for web requests
        $html = '<!DOCTYPE html>
<html>
<head><title>503 Service Unavailable</title></head>
<body>
    <h1>Under Maintenance</h1>
    <p>' . $message . '</p>
</body>
</html>';

        return new Response($html, 503);
    }
}
```

**Registering as global middleware so it runs on every request:**

```php
use App\Middleware\MaintenanceMiddleware;

Router::globalMiddleware([
    MaintenanceMiddleware::class,
]);
```

---

### JsonResponseMiddleware

Forces `Content-Type: application/json` on all responses for API routes. This is an **after** middleware -- it lets the controller run first and then modifies the outgoing response headers.

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * JSON Response Middleware
 *
 * Ensures all responses in the middleware group are returned
 * with the correct JSON content-type header.
 *
 * Usage:
 *   Apply to API route groups to guarantee consistent JSON responses.
 */
class JsonResponseMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Tell downstream code that the client expects JSON
        // (useful for error handlers that check expectsJson())
        $request->headers['Accept'] = 'application/json';

        // Let the controller handle the request
        $response = $next($request);

        // Force JSON content-type on the response
        $response->header('Content-Type', 'application/json; charset=utf-8');

        // Add standard API headers
        $response->header('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
```

**Registering on an API route group:**

```php
use App\Middleware\JsonResponseMiddleware;
use App\Middleware\AuthMiddleware;

Router::group([
    'prefix' => 'api/v1',
    'middleware' => [JsonResponseMiddleware::class, AuthMiddleware::class]
], function () {
    Router::get('/users', [ApiUserController::class, 'index']);
    Router::get('/users/{id}', [ApiUserController::class, 'show']);
    Router::post('/users', [ApiUserController::class, 'store']);
    Router::put('/users/{id}', [ApiUserController::class, 'update']);
    Router::delete('/users/{id}', [ApiUserController::class, 'destroy']);
});
```

---

## Quick Reference

| Task | How |
|------|-----|
| Create middleware | Implement `Core\Middleware\MiddlewareInterface` in `app/Middleware/` |
| Before logic | Place code above `$next($request)` |
| After logic | Place code below `$next($request)` |
| Short-circuit | Return a `Response` without calling `$next()` |
| Pass parameters | Add arguments to `handle()`, apply with `Middleware::class . ':value'` |
| Multiple parameters | Comma-separated: `Middleware::class . ':val1,val2'` |
| Single route | `->middleware([MyMiddleware::class])` |
| Route group | `Router::group(['middleware' => [MyMiddleware::class]], fn() => ...)` |
| Global | `Router::globalMiddleware([MyMiddleware::class])` |
