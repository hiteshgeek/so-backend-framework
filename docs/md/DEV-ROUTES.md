# Developer Guide: Routing

A step-by-step guide to defining and organizing routes in the SO Backend Framework using `Core\Routing\Router`.

## Table of Contents

1. [Overview](#overview)
2. [Basic Routes](#basic-routes)
3. [Route with Controller](#route-with-controller)
4. [Route with Closure](#route-with-closure)
5. [Route Groups](#route-groups)
6. [Named Routes](#named-routes)
7. [Resource Routes](#resource-routes)
8. [Redirect Routes](#redirect-routes)
9. [Fallback Route](#fallback-route)
10. [Route Files](#route-files)

---

## Overview

Every HTTP request that reaches your application is matched against a list of registered routes. A route binds a URI pattern and HTTP method to an action -- either a controller method or a closure. Routes are registered through the static methods on `Core\Routing\Router`.

```
Request  -->  Router matches URI + method  -->  Middleware pipeline  -->  Controller / Closure  -->  Response
```

All route definitions live under the `routes/` directory:

| File | Purpose |
|---|---|
| `routes/web.php` | Web routes (HTML pages, forms, sessions) |
| `routes/api.php` | API routes (JSON endpoints) |
| `routes/web/*.php` | Modular web route files loaded by `web.php` |
| `routes/api/*.php` | Modular API route files loaded by `api.php` |

At the top of every route file, import the Router:

```php
use Core\Routing\Router;
```

---

## Basic Routes

The Router exposes a static method for each HTTP verb. Every method accepts a URI string and an action, and returns a `Route` instance that you can chain further.

### GET

```php
Router::get('/dashboard', [DashboardController::class, 'index']);
```

### POST

```php
Router::post('/users', [UserController::class, 'store']);
```

### PUT

```php
Router::put('/users/{id}', [UserController::class, 'update']);
```

### PATCH

```php
Router::patch('/users/{id}', [UserController::class, 'patch']);
```

### DELETE

```php
Router::delete('/users/{id}', [UserController::class, 'destroy']);
```

### any()

`any()` registers the route for all five HTTP methods (GET, POST, PUT, DELETE, PATCH) at once:

```php
Router::any('/webhook', [WebhookController::class, 'handle']);
```

### match()

`match()` lets you pick exactly which methods a route should respond to:

```php
Router::match(['GET', 'POST'], '/search', [SearchController::class, 'handle']);
```

The methods array is case-insensitive -- `['get', 'post']` works the same as `['GET', 'POST']`.

---

## Route with Controller

The most common pattern is pointing a route at a controller method. Pass an array containing the controller class and the method name:

```php
use App\Controllers\UserApiController;

Router::get('/api/users', [UserApiController::class, 'index']);
Router::get('/api/users/{id}', [UserApiController::class, 'show']);
Router::post('/api/users', [UserApiController::class, 'store']);
Router::put('/api/users/{id}', [UserApiController::class, 'update']);
Router::delete('/api/users/{id}', [UserApiController::class, 'destroy']);
```

The framework resolves the controller through the service container, so constructor dependencies are injected automatically. Route parameters like `{id}` are passed to the controller method as arguments.

A matching controller for the routes above:

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class UserApiController
{
    public function index(Request $request): Response
    {
        // List all users
    }

    public function show(Request $request, int $id): Response
    {
        // Show user by ID
    }

    public function store(Request $request): Response
    {
        // Create a new user
    }

    public function update(Request $request, int $id): Response
    {
        // Update user by ID
    }

    public function destroy(Request $request, int $id): Response
    {
        // Delete user by ID
    }
}
```

---

## Route with Closure

For lightweight endpoints that do not need a full controller, use a closure. The `Request` object is always available as the first argument:

```php
use Core\Http\Request;
use Core\Http\JsonResponse;

Router::get('/api/health', function (Request $request) {
    return JsonResponse::success([
        'status' => 'ok',
        'version' => config('app.version'),
        'timestamp' => date('c'),
    ]);
})->name('api.health');
```

Route parameters are passed as additional arguments after `$request`:

```php
Router::get('/api/users/{id}', function (Request $request, int $id) {
    return JsonResponse::success([
        'user_id' => $id,
        'message' => 'User details',
    ]);
})->whereNumber('id');
```

Closures support the same chaining as controller routes -- `->name()`, `->middleware()`, `->whereNumber()`, and so on.

### When to use closures vs. controllers

Use closures for simple, self-contained endpoints like health checks, redirects, or quick debugging routes. Use controllers when the logic is substantial, reusable, or part of a resource.

---

## Route Groups

Groups let you apply shared attributes -- a URI prefix, middleware, or both -- to a set of routes. This avoids repeating the same prefix or middleware on every single route.

### Prefix only

```php
Router::group(['prefix' => 'api/v1'], function () {
    Router::get('/users', [UserController::class, 'index']);       // /api/v1/users
    Router::get('/users/{id}', [UserController::class, 'show']);   // /api/v1/users/{id}
    Router::post('/users', [UserController::class, 'store']);      // /api/v1/users
});
```

### Middleware only

```php
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

Router::group(['middleware' => [CsrfMiddleware::class, AuthMiddleware::class]], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
    Router::post('/settings', [SettingsController::class, 'update']);
});
```

### Prefix and middleware together

```php
Router::group(['prefix' => 'dashboard', 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]], function () {
    Router::get('/', [DashboardController::class, 'index']);                 // /dashboard
    Router::get('/users/create', [DashboardController::class, 'create']);    // /dashboard/users/create
    Router::post('/users', [DashboardController::class, 'store']);           // /dashboard/users
    Router::get('/users/{id}/edit', [DashboardController::class, 'edit']);   // /dashboard/users/{id}/edit
    Router::delete('/users/{id}', [DashboardController::class, 'destroy']); // /dashboard/users/{id}
});
```

### Nested groups

Groups can be nested. Inner groups inherit the prefix and middleware of outer groups:

```php
Router::group(['middleware' => [CsrfMiddleware::class]], function () {

    // Guest routes -- CsrfMiddleware applied
    Router::group(['middleware' => [GuestMiddleware::class]], function () {
        Router::get('/login', [AuthController::class, 'showLogin']);
        Router::post('/login', [AuthController::class, 'login']);
    });

    // Authenticated routes -- CsrfMiddleware applied
    Router::group(['middleware' => [AuthMiddleware::class]], function () {
        Router::post('/logout', [AuthController::class, 'logout']);
    });

});
```

### Middleware with parameters

Middleware classes that accept parameters are written with a colon separator:

```php
use App\Middleware\ThrottleMiddleware;

Router::group(['middleware' => [ThrottleMiddleware::class . ':5,1']], function () {
    // These routes are rate-limited to 5 requests per 1 minute
    Router::post('/login', [AuthController::class, 'login']);
    Router::post('/register', [AuthController::class, 'register']);
});
```

---

## Named Routes

Naming a route gives it a unique identifier you can use to generate URLs without hardcoding paths. Chain `->name()` onto any route definition:

```php
Router::get('/api/users', [UserApiController::class, 'index'])->name('api.users.index');
Router::get('/api/users/{id}', [UserApiController::class, 'show'])->name('api.users.show');
Router::post('/api/users', [UserApiController::class, 'store'])->name('api.users.store');
Router::put('/api/users/{id}', [UserApiController::class, 'update'])->name('api.users.update');
Router::delete('/api/users/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
```

### Generating URLs from named routes

Use the `url()` method on a Router instance to build a URL from a route name. Pass parameters as an associative array:

```php
$router = app(Router::class);

// Simple route (no parameters)
$url = $router->url('api.users.index');
// => http://yourapp.com/api/users

// Route with parameters
$url = $router->url('api.users.show', ['id' => 42]);
// => http://yourapp.com/api/users/42
```

### Checking if a named route exists

```php
if (Router::has('api.users.index')) {
    // Route exists
}
```

### Getting the current route name

```php
$name = Router::currentRouteName();
// => "api.users.show"
```

### Pattern matching on the current route name

The `Router::is()` method supports wildcards for checking if the current route matches a pattern:

```php
if (Router::is('api.users.*')) {
    // Current route is any user API route
}

if (Router::is('dashboard', 'dashboard.*')) {
    // Current route is the dashboard or any dashboard sub-route
}
```

### Listing all named routes

Retrieve every registered named route with `Router::getNamedRoutes()`:

```php
$namedRoutes = Router::getNamedRoutes();

foreach ($namedRoutes as $name => $route) {
    echo $name . ' => ' . $route->getUri() . "\n";
}
```

---

## Resource Routes

Resource routes register a complete set of CRUD routes for a resource in a single call.

### Full resource: Router::resource()

`Router::resource()` generates 7 routes covering the full CRUD lifecycle, including form display routes:

```php
use App\Controllers\PostController;

Router::resource('posts', PostController::class);
```

This single line registers:

| HTTP Method | URI | Controller Method | Purpose |
|---|---|---|---|
| GET | `/posts` | `index` | List all posts |
| GET | `/posts/create` | `create` | Show create form |
| POST | `/posts` | `store` | Save a new post |
| GET | `/posts/{id}` | `show` | Display a single post |
| GET | `/posts/{id}/edit` | `edit` | Show edit form |
| PUT | `/posts/{id}` | `update` | Update a post |
| DELETE | `/posts/{id}` | `destroy` | Delete a post |

### API resource: Router::apiResource()

For API endpoints that return JSON, you typically do not need the `create` and `edit` form routes. `Router::apiResource()` generates 5 routes:

```php
use App\Controllers\Api\Demo\DemoProductController;

Router::apiResource('products', DemoProductController::class);
```

This registers:

| HTTP Method | URI | Controller Method | Purpose |
|---|---|---|---|
| GET | `/products` | `index` | List all products |
| POST | `/products` | `store` | Create a new product |
| GET | `/products/{id}` | `show` | Get a single product |
| PUT | `/products/{id}` | `update` | Update a product |
| DELETE | `/products/{id}` | `destroy` | Delete a product |

### Resource routes inside a group

Combine resource routes with a group prefix to namespace them under an API version or section:

```php
Router::group(['prefix' => 'api/demo'], function () {
    Router::apiResource('products', DemoProductController::class);
});
// Produces:
//   GET    /api/demo/products
//   POST   /api/demo/products
//   GET    /api/demo/products/{id}
//   PUT    /api/demo/products/{id}
//   DELETE /api/demo/products/{id}
```

### Your controller must implement the matching methods

For `Router::resource()`, the controller needs all 7 methods:

```php
class PostController
{
    public function index(Request $request) { /* ... */ }
    public function create(Request $request) { /* ... */ }
    public function store(Request $request) { /* ... */ }
    public function show(Request $request, int $id) { /* ... */ }
    public function edit(Request $request, int $id) { /* ... */ }
    public function update(Request $request, int $id) { /* ... */ }
    public function destroy(Request $request, int $id) { /* ... */ }
}
```

For `Router::apiResource()`, you can omit `create` and `edit`.

---

## Redirect Routes

Redirect routes send visitors from one URI to another without writing a controller or closure.

### Temporary redirect (302)

A 302 redirect tells the browser this is a temporary move:

```php
Router::redirect('/api/demo/legacy', '/api/demo/ping');
```

### Permanent redirect (301)

A 301 redirect tells the browser (and search engines) this is a permanent move:

```php
Router::permanentRedirect('/api/demo/old-products', '/api/demo/products');
```

### Custom status code

The `redirect()` method accepts an optional third argument for the HTTP status code:

```php
Router::redirect('/old-path', '/new-path', 308);
```

### Common use cases

- Renaming a URL and keeping old links working
- Consolidating duplicate URLs
- Moving an API version from `/v1/` to `/v2/`

```php
// After renaming /blog to /articles
Router::permanentRedirect('/blog', '/articles');

// After moving API version
Router::permanentRedirect('/api/v1/users', '/api/v2/users');
```

---

## Fallback Route

The fallback route acts as a catch-all. It runs when no other registered route matches the incoming request. Register it at the end of your route definitions so it does not shadow real routes.

```php
use Core\Http\Request;
use Core\Http\JsonResponse;

Router::fallback(function (Request $request) {
    return JsonResponse::error('Route not found.', 404, [
        'requested_uri' => $request->uri(),
        'requested_method' => $request->method(),
    ]);
});
```

The fallback route responds to all HTTP methods (GET, POST, PUT, DELETE, PATCH).

### Practical example: helpful 404 with available routes

```php
Router::fallback(function (Request $request) {
    $namedRoutes = Router::getNamedRoutes();
    $available = [];

    foreach ($namedRoutes as $name => $route) {
        $available[] = [
            'name' => $name,
            'methods' => $route->getMethods(),
            'uri' => $route->getUri(),
        ];
    }

    return JsonResponse::error('Route not found. See available_routes for valid endpoints.', 404, [
        'requested_uri' => $request->uri(),
        'requested_method' => $request->method(),
        'available_routes' => $available,
    ]);
});
```

### Important notes

- Only one fallback route can be active at a time. Registering a second one replaces the first.
- Always register the fallback **last** in your route files so all other routes are checked first.
- If no fallback is registered and no route matches, the framework throws a `Core\Exceptions\NotFoundException`.

---

## Route Files

The framework organizes routes into modular files under the `routes/` directory.

### Structure

```
routes/
    web.php              <-- Main web entry point
    api.php              <-- Main API entry point
    web/
        auth.php         <-- Authentication routes (login, register, logout)
        dashboard.php    <-- Dashboard routes
        docs.php         <-- Documentation routes
    api/
        users.php        <-- User API routes
        products.php     <-- Product API routes
        orders.php       <-- Order API routes
        demo.php         <-- Demo/showcase routes
```

### How it works

`routes/web.php` is the entry point for web routes. It defines top-level routes and loads modular files from `routes/web/` using `require`:

```php
<?php
// routes/web.php

use Core\Routing\Router;
use Core\Http\Request;
use Core\Http\Response;

// Top-level route defined directly
Router::get('/', function (Request $request) {
    return Response::view('welcome');
})->name('home');

// Load route modules
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/dashboard.php';
require __DIR__ . '/web/docs.php';
```

`routes/api.php` does the same for API routes, loading files from `routes/api/`:

```php
<?php
// routes/api.php

use Core\Routing\Router;

// Load API route modules
require __DIR__ . '/api/users.php';
require __DIR__ . '/api/products.php';
require __DIR__ . '/api/orders.php';
require __DIR__ . '/api/demo.php';

// Routes can also be defined directly in api.php
Router::get('/api/health', function (\Core\Http\Request $request) {
    return \Core\Http\JsonResponse::success([
        'status' => 'ok',
        'version' => config('app.version'),
        'timestamp' => date('c'),
    ]);
})->name('api.health');
```

### Inside a module file

Each module file is a standalone PHP file that uses `Router` to define its own routes. Groups are commonly used to apply a shared prefix and middleware:

```php
<?php
// routes/api/users.php

use Core\Routing\Router;
use App\Controllers\UserApiController;
use App\Middleware\AuthMiddleware;

Router::group(['prefix' => 'api', 'middleware' => [AuthMiddleware::class]], function () {
    Router::get('/users', [UserApiController::class, 'index'])->name('api.users.index');
    Router::get('/users/{id}', [UserApiController::class, 'show'])->name('api.users.show');
    Router::post('/users', [UserApiController::class, 'store'])->name('api.users.store');
    Router::put('/users/{id}', [UserApiController::class, 'update'])->name('api.users.update');
    Router::delete('/users/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
});
```

### Adding a new route module

1. Create a new file under `routes/web/` or `routes/api/`:

```php
<?php
// routes/api/categories.php

use Core\Routing\Router;
use App\Controllers\Api\CategoryController;

Router::group(['prefix' => 'api'], function () {
    Router::apiResource('categories', CategoryController::class);
});
```

2. Add a `require` line in the parent file (`routes/api.php`):

```php
require __DIR__ . '/api/categories.php';
```

That is all that is needed. The new routes are now active.

### Naming conventions

| Convention | Example |
|---|---|
| Web module file name | `routes/web/dashboard.php` |
| API module file name | `routes/api/users.php` |
| Web route name | `dashboard.users.create` |
| API route name | `api.users.index`, `api.v1.users.show` |
| Group prefix for API v1 | `api/v1` |
