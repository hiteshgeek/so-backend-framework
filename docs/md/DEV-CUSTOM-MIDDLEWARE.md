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
9. [Built-in Middleware Reference](#built-in-middleware-reference)
   - [AuthMiddleware](#1-authmiddleware)
   - [JwtMiddleware](#2-jwtmiddleware)
   - [CorsMiddleware](#3-corsmiddleware)
   - [CsrfMiddleware](#4-csrfmiddleware)
   - [GuestMiddleware](#5-guestmiddleware)
   - [ThrottleMiddleware](#6-throttlemiddleware)
   - [LogRequestMiddleware](#7-logrequestmiddleware)
   - [ApiVersionMiddleware](#8-apiversionmiddleware)
10. [Quick Reference](#quick-reference)

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

## Built-in Middleware Reference

The SO Framework includes 8 production-ready middleware classes for common tasks. Each is fully implemented and ready to use in your routes.

### 1. AuthMiddleware

**Purpose:** Ensure user is authenticated via session or JWT before accessing a route.

**File:** `app/Middleware/AuthMiddleware.php`

**Features:**
- Supports session-based authentication (web)
- Supports JWT authentication (API)
- Remembers users via "remember me" token
- Returns appropriate error based on request type (JSON for APIs, redirect for web)

**Usage:**
```php
Router::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

// Protect an entire group
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::put('/profile', [ProfileController::class, 'update']);
});
```

**Behavior:**
- Checks `auth()->check()` for session authentication
- Falls back to `auth()->loginViaRememberToken()` if session expired
- Falls back to JWT token in `Authorization: Bearer <token>` header
- Redirects to `/login` if unauthenticated (web requests)
- Returns `401 Unauthorized` if unauthenticated (API requests)
- Attaches `$request->user` and `$request->user_id` on success

**Configuration:**
```php
// config/auth.php
return [
    'login_url' => '/login',  // Redirect destination
];
```

---

### 2. JwtMiddleware

**Purpose:** Validate JWT token in `Authorization` header (JWT-only, no session fallback).

**File:** `app/Middleware/JwtMiddleware.php`

**Features:**
- Strict JWT-only authentication
- Decodes and verifies JWT signature
- Checks token expiration
- Loads user model if `user_id` is in payload

**Usage:**
```php
Router::get('/api/v1/profile', [ApiProfileController::class, 'show'])
    ->middleware([JwtMiddleware::class]);
```

**Behavior:**
- Extracts token from `Authorization: Bearer <token>` header
- Returns `401` with error code if token missing
- Validates signature and expiration using `Core\Security\JWT`
- Returns `401` with error code if token invalid/expired
- Attaches `$request->jwt` (full payload), `$request->user_id`, and `$request->user`

**Configuration:**
```php
// config/security.php
return [
    'jwt' => [
        'secret' => env('JWT_SECRET'),
        'expiration' => 3600,  // 1 hour in seconds
        'algorithm' => 'HS256',
    ],
];
```

**When to Use:**
- API endpoints that require strict JWT auth
- Use `AuthMiddleware` instead if you want session + JWT fallback

---

### 3. CorsMiddleware

**Purpose:** Add CORS headers to allow cross-origin API requests from browsers.

**File:** `app/Middleware/CorsMiddleware.php`

**Features:**
- Configurable allowed origins (exact match or wildcard)
- Handles preflight `OPTIONS` requests
- Supports credentials (cookies/auth headers)
- Adds standard CORS headers to all responses

**Usage:**
```php
Router::group(['prefix' => 'api', 'middleware' => [CorsMiddleware::class]], function() {
    Router::get('/users', [UserController::class, 'index']);
    Router::post('/users', [UserController::class, 'store']);
});
```

**Headers Added:**
- `Access-Control-Allow-Origin` - Allowed origins
- `Access-Control-Allow-Methods` - Allowed HTTP methods
- `Access-Control-Allow-Headers` - Allowed request headers
- `Access-Control-Allow-Credentials` - Allow cookies
- `Access-Control-Max-Age` - Preflight cache duration
- `Access-Control-Expose-Headers` - Exposed response headers

**Configuration:**
```php
// config/cors.php
return [
    'allowed_origins' => ['*'],  // or ['https://example.com', '*.myapp.com']
    'allowed_methods' => 'GET,POST,PUT,DELETE,PATCH,OPTIONS',
    'allowed_headers' => 'Content-Type,Authorization,X-CSRF-TOKEN,X-Requested-With',
    'exposed_headers' => null,
    'allow_credentials' => false,
    'max_age' => 86400,  // 24 hours
];
```

**When to Use:**
- Public APIs accessed from browser frontends
- Single-Page Applications (SPAs) on different domains
- Mobile web apps making API calls

---

### 4. CsrfMiddleware

**Purpose:** Protect against CSRF attacks by validating tokens on state-changing requests.

**File:** `app/Middleware/CsrfMiddleware.php`

**Features:**
- Validates tokens on `POST`, `PUT`, `DELETE`, `PATCH` requests
- Skips `GET`, `HEAD`, `OPTIONS` requests
- Accepts token from `_token` POST field or `X-CSRF-TOKEN` header
- Supports excluded routes via config

**Usage:**
```php
Router::post('/profile', [ProfileController::class, 'update'])
    ->middleware([CsrfMiddleware::class]);

// Apply to entire web group
Router::group(['middleware' => [CsrfMiddleware::class]], function () {
    Router::post('/posts', [PostController::class, 'store']);
    Router::put('/posts/{id}', [PostController::class, 'update']);
});
```

**Behavior:**
- Skips check if CSRF is disabled in config
- Skips check for excluded routes
- Checks for token in `_token` field or `X-CSRF-TOKEN` header
- Returns `419 CSRF Token Mismatch` if validation fails (API)
- Redirects back with error if validation fails (web)

**Configuration:**
```php
// config/security.php
return [
    'csrf' => [
        'enabled' => true,
        'excluded_routes' => [
            'api/*',  // Exclude all API routes
            'webhooks/*',
        ],
    ],
];
```

**In Forms:**
```php
<form method="POST" action="/profile">
    <?= csrf_field() ?>
    <!-- form fields -->
</form>
```

**When to Use:**
- All web forms (`POST`, `PUT`, `DELETE`)
- **Do NOT use** on API routes (use JwtMiddleware instead)

---

### 5. GuestMiddleware

**Purpose:** Redirect authenticated users away from guest-only pages (opposite of Auth).

**File:** `app/Middleware/GuestMiddleware.php`

**Features:**
- Simple inverse check of authentication
- Prevents logged-in users from seeing login/register pages

**Usage:**
```php
Router::get('/login', [AuthController::class, 'showLogin'])
    ->middleware([GuestMiddleware::class]);

Router::get('/register', [AuthController::class, 'showRegister'])
    ->middleware([GuestMiddleware::class]);
```

**Behavior:**
- Checks if `auth()->check()` returns `true`
- Redirects to `/dashboard` if user is authenticated
- Allows request to continue if user is a guest

**When to Use:**
- Login pages
- Registration pages
- Password reset request pages
- Any page that only guests should see

---

### 6. ThrottleMiddleware

**Purpose:** Rate limit requests to prevent abuse and brute-force attacks.

**File:** `app/Middleware/ThrottleMiddleware.php`

**Features:**
- Per-user throttling (if authenticated)
- Per-IP throttling (if guest)
- Configurable max attempts and decay time
- Adds `X-RateLimit-*` headers to responses
- Returns `429 Too Many Requests` when limit exceeded

**Usage:**
```php
// Limit to 60 requests per 1 minute
Router::post('/api/login', [AuthController::class, 'login'])
    ->middleware([ThrottleMiddleware::class . ':60,1']);

// Limit to 5 requests per 5 minutes (strict)
Router::post('/api/password/reset', [PasswordController::class, 'reset'])
    ->middleware([ThrottleMiddleware::class . ':5,5']);

// Use default from config (no parameters)
Router::get('/api/data', [DataController::class, 'index'])
    ->middleware([ThrottleMiddleware::class]);
```

**Parameters:**
- **First parameter:** `maxAttempts` - Maximum requests allowed (default from config)
- **Second parameter:** `decayMinutes` - Time window in minutes (default: 1)

**Headers Added:**
- `X-RateLimit-Limit` - Maximum attempts allowed
- `X-RateLimit-Remaining` - Remaining attempts
- `Retry-After` - Seconds until rate limit resets (when exceeded)
- `X-RateLimit-Reset` - Unix timestamp when limit resets

**Configuration:**
```php
// config/security.php
return [
    'rate_limit' => [
        'default' => '60,1',  // 60 requests per 1 minute
    ],
];
```

**When to Use:**
- Login endpoints (prevent brute force)
- Password reset endpoints
- API endpoints (prevent abuse)
- Registration endpoints (prevent spam)

---

### 7. LogRequestMiddleware

**Purpose:** Log all HTTP requests and responses for debugging and monitoring.

**File:** `app/Middleware/LogRequestMiddleware.php`

**Features:**
- Logs request method, URI, IP, user agent, input data
- Logs response status code and duration
- Filters sensitive fields (passwords, tokens, credit cards)
- Logs to activity logger or error_log
- Different log levels based on status code (error for 5xx, warning for 4xx)

**Usage:**
```php
// Log all API requests
Router::group(['prefix' => 'api', 'middleware' => [LogRequestMiddleware::class]], function() {
    Router::get('/users', [UserController::class, 'index']);
});

// Or apply globally
Router::globalMiddleware([
    LogRequestMiddleware::class,
]);
```

**Behavior:**
- Skips logging if disabled in config
- Logs incoming request with filtered input
- Executes controller and measures duration
- Logs response with status code and timing
- Sensitive fields are replaced with `[FILTERED]`

**Sensitive Fields (Auto-Filtered):**
- `password`, `password_confirmation`
- `token`, `secret`, `api_key`
- `authorization`
- `card_number`, `cvv`, `ssn`

**Configuration:**
```php
// config/logging.php
return [
    'log_requests' => env('LOG_REQUESTS', false),
];

// .env
LOG_REQUESTS=true  // Enable in development/debugging
```

**Output Example:**
```
[INFO] Incoming Request: {"method":"POST","uri":"/api/login","ip":"192.168.1.100","input":{"email":"user@example.com","password":"[FILTERED]"}}
[INFO] Response: {"method":"POST","uri":"/api/login","status":200,"duration":"142.5ms"}
```

**When to Use:**
- Development/debugging
- Monitoring API usage
- Troubleshooting production issues
- **Warning:** Can generate large log files in high-traffic apps

---

### 8. ApiVersionMiddleware

**Purpose:** Detect API version from URL or headers and attach it to the request.

**File:** `app/Middleware/ApiVersionMiddleware.php`

**Features:**
- Detects version from URL path (`/api/v1/users`)
- Falls back to `Accept` header (`application/vnd.api.v1+json`)
- Falls back to default version from config
- Validates version against supported versions
- Adds deprecation warnings for old versions
- Attaches `$request->api_version` and `$request->api_version_number`

**Usage:**
```php
Router::group(['middleware' => [ApiVersionMiddleware::class]], function() {
    Router::version('v1', function() {
        Router::get('/users', [UserControllerV1::class, 'index']);
    });

    Router::version('v2', function() {
        Router::get('/users', [UserControllerV2::class, 'index']);
    });
});
```

**Detection Order:**
1. URL path: `/api/v2/users` → `$request->api_version = "v2"`
2. Accept header: `Accept: application/vnd.api.v1+json` → `$request->api_version = "v1"`
3. Default: config value → `$request->api_version = "v1"`

**Request Properties Set:**
- `$request->api_version` - Version string (`"v1"`, `"v2"`)
- `$request->api_version_number` - Version number (`1`, `2`)

**Deprecation Warnings:**
If version is in `config('api.deprecated_versions')`, adds headers:
- `X-API-Version-Deprecated: true`
- `X-API-Deprecation-Info: API version v1 is deprecated. Please migrate to a newer version.`

**Configuration:**
```php
// config/api.php
return [
    'default_version' => 'v1',
    'supported_versions' => ['v1', 'v2', 'v3'],
    'deprecated_versions' => ['v1'],  // Add deprecation warnings
];
```

**When to Use:**
- Versioned APIs
- APIs with breaking changes between versions
- Migration from old to new API endpoints

**See Also:** [API Versioning Guide](API-VERSIONING.md)

---

## When to Use Each Middleware

| Middleware | Use Case | Priority | Apply To |
|------------|----------|----------|----------|
| **AuthMiddleware** | Protected web/API routes (session + JWT) | High | Dashboard, profile, protected pages |
| **JwtMiddleware** | Protected API routes (JWT only) | High | `/api/*` routes |
| **CsrfMiddleware** | Forms and state-changing web requests | Critical | All `POST`/`PUT`/`DELETE` web routes |
| **CorsMiddleware** | Public APIs accessed from browsers | Medium | `/api/*` routes |
| **GuestMiddleware** | Login/register pages | Low | `/login`, `/register` |
| **ThrottleMiddleware** | Login, API endpoints, prevent abuse | High | `/login`, `/api/*` |
| **LogRequestMiddleware** | Development/debugging | Low | Development only |
| **ApiVersionMiddleware** | Versioned APIs | Medium | `/api/*` routes with versions |

### Typical Web Route Setup

```php
// Web routes (routes/web.php)
Router::group(['middleware' => [CsrfMiddleware::class]], function () {
    // Guest routes
    Router::group(['middleware' => [GuestMiddleware::class]], function () {
        Router::get('/login', [AuthController::class, 'showLogin']);
        Router::post('/login', [AuthController::class, 'login'])
            ->middleware([ThrottleMiddleware::class . ':5,1']);
    });

    // Protected routes
    Router::group(['middleware' => [AuthMiddleware::class]], function () {
        Router::get('/dashboard', [DashboardController::class, 'index']);
        Router::get('/profile', [ProfileController::class, 'show']);
        Router::put('/profile', [ProfileController::class, 'update']);
    });
});
```

### Typical API Route Setup

```php
// API routes (routes/api.php)
Router::group([
    'prefix' => 'api',
    'middleware' => [CorsMiddleware::class, ApiVersionMiddleware::class]
], function () {
    // Public endpoints
    Router::post('/login', [ApiAuthController::class, 'login'])
        ->middleware([ThrottleMiddleware::class . ':5,1']);

    // Protected endpoints
    Router::group(['middleware' => [JwtMiddleware::class]], function () {
        Router::get('/users', [ApiUserController::class, 'index'])
            ->middleware([ThrottleMiddleware::class . ':60,1']);
        Router::post('/users', [ApiUserController::class, 'store']);
    });
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

---

## See Also

- **[Routing System](ROUTING-SYSTEM.md)** - Learn how to define routes and route groups
- **[Auth System](AUTH-SYSTEM.md)** - Session and JWT authentication
- **[API Versioning](API-VERSIONING.md)** - Implement versioned APIs
- **[Security Layer](SECURITY-LAYER.md)** - CSRF protection and security features
- **[Rate Limiting](SECURITY-LAYER.md#rate-limiting)** - Throttle middleware deep dive
- **[Request Flow](REQUEST-FLOW.md)** - How middleware fits in the request pipeline

---

**Last Updated**: 2026-02-01
**Framework Version**: 1.0
