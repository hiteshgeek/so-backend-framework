# Request Flow Diagram

> Visual walkthrough of how an HTTP request travels through the SO Framework — from the browser to the response.

---

## Overview

Every HTTP request passes through a well-defined pipeline:

```
Browser Request
    │
    ▼
┌─────────────────────┐
│   public/index.php   │  ← Entry Point
└─────────┬───────────┘
          │
          ▼
┌─────────────────────┐
│  Bootstrap / Boot    │  ← Load Config, Services, Providers
└─────────┬───────────┘
          │
          ▼
┌─────────────────────┐
│   Route Matching     │  ← Match URI + Method to a Route
└─────────┬───────────┘
          │
          ▼
┌─────────────────────┐
│  Middleware Pipeline  │  ← Auth, CSRF, Throttle, etc.
└─────────┬───────────┘
          │
          ▼
┌─────────────────────┐
│  Controller Action   │  ← Execute Business Logic
└─────────┬───────────┘
          │
          ▼
┌─────────────────────┐
│  Response / Send     │  ← HTML, JSON, or Redirect
└─────────────────────┘
```

---

## Step 1 — Entry Point

**File:** `public/index.php`

All HTTP requests are routed to `public/index.php` via the web server (Apache `.htaccess` or Nginx rewrite rules). This is the single entry point for the entire application.

```php
// 1. Autoload classes
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Bootstrap application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Load route definitions
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// 4. Create Request from PHP superglobals
$request = Request::createFromGlobals();

// 5. Age flash data from previous request
session()->ageFlashData();

// 6. Dispatch request through router → middleware → controller
$response = $app->handleWebRequest($request);

// 7. Send HTTP response to client
$response->send();

// 8. Run termination tasks
$app->terminate();
```

```
index.php
 ├── autoload
 ├── bootstrap/app.php   → creates Application
 ├── routes/web.php      → registers web routes
 ├── routes/api.php      → registers API routes
 ├── Request::createFromGlobals()
 ├── handleWebRequest()  → dispatch + middleware + controller
 ├── Response::send()
 └── terminate()
```

---

## Step 2 — Bootstrap

**File:** `bootstrap/app.php`

The bootstrap file creates the `Application` instance (which extends the DI `Container`) and registers all core services.

```
Application (extends Container)
 │
 ├── Load .env             → Env::load()
 ├── Create Application    → new Application(basePath)
 │
 ├── Register Core Services (singletons)
 │   ├── config   → Config (loads /config/*.php files)
 │   ├── db       → Database Connection + QueryBuilder
 │   ├── session  → Session (database-driven)
 │   ├── router   → Router
 │   ├── auth     → Auth (session + JWT)
 │   ├── csrf     → CSRF token manager
 │   └── assets   → AssetManager (CSS/JS loading)
 │
 ├── Register Service Providers
 │   └── foreach provider: $provider->register()
 │
 ├── Boot Service Providers
 │   └── foreach provider: $provider->boot()
 │
 └── $app->boot()
```

### Dependency Container

The container uses **reflection-based dependency injection** to auto-resolve class dependencies:

```php
// Registering
$app->singleton('auth', fn() => new Auth($app->make('db')));

// Resolving
$auth = app('auth');       // via helper
$auth = app()->make(Auth::class);  // via container
```

When resolving, the container:
1. Checks for explicit bindings
2. Uses reflection to inspect constructor parameters
3. Recursively resolves typed dependencies
4. Uses default values for primitives

---

## Step 3 — Request Object

**Class:** `Core\Http\Request`

The `Request` object wraps all PHP superglobals into a clean, object-oriented interface.

```
Request::createFromGlobals()
 │
 ├── $_GET      → query parameters
 ├── $_POST     → form data (or parsed JSON body)
 ├── $_SERVER   → headers, method, URI, IP
 ├── $_FILES    → uploaded files
 └── $_COOKIE   → cookies
```

### Key Methods

| Method | Description |
|--------|-------------|
| `method()` | HTTP method (supports `_method` spoofing for PUT/DELETE) |
| `uri()` | Request URI path |
| `input($key)` | Get value from POST or GET |
| `all()` | All input data |
| `header($name)` | Get HTTP header |
| `bearerToken()` | Extract Bearer token from Authorization header |
| `json()` | Parse JSON request body |
| `file($key)` | Get uploaded file |
| `user()` | Authenticated user (set by middleware) |
| `expectsJson()` | Whether client expects JSON response |
| `ajax()` | Whether request is XMLHttpRequest |

---

## Step 4 — Route Matching

**Class:** `Core\Routing\Router`

Routes are registered in `routes/web.php` and `routes/api.php` during bootstrap.

### Route Registration

```php
// Simple routes
Router::get('/users', [UserController::class, 'index']);
Router::post('/users', [UserController::class, 'store']);

// Route with parameters
Router::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id');

// Route groups
Router::group(['prefix' => 'api', 'middleware' => ['auth']], function () {
    Router::get('/posts', [PostController::class, 'index']);
});

// Resource routes (7 CRUD routes)
Router::resource('posts', PostController::class);

// Fallback (404 handler)
Router::fallback(fn() => abort(404));
```

### Matching Process

```
Router::dispatch($request)
 │
 ├── For each registered route:
 │   └── Route::matches($request)
 │       ├── Check HTTP method (GET, POST, etc.)
 │       ├── Compile URI to regex pattern
 │       │   ├── {id}     → (?P<id>[^/]+)
 │       │   ├── {slug?}  → (?P<slug>[^/]*)
 │       │   └── where()  → custom constraints
 │       ├── Match against request URI
 │       └── Extract route parameters
 │
 ├── Match found:
 │   └── runRouteWithMiddleware($route, $request)
 │
 ├── No match + fallback exists:
 │   └── runRouteWithMiddleware($fallback, $request)
 │
 └── No match + no fallback:
     └── throw NotFoundException (404)
```

### Parameter Constraints

```php
Route::get('/users/{id}', ...)->whereNumber('id');
// Pattern: /users/(?P<id>[0-9]+)

Route::get('/posts/{slug}', ...)->whereAlpha('slug');
// Pattern: /posts/(?P<slug>[a-zA-Z]+)

Route::get('/files/{path}', ...)->where('path', '.*');
// Pattern: /files/(?P<path>.*)
```

---

## Step 5 — Middleware Pipeline

**Interface:** `Core\Middleware\MiddlewareInterface`

Once a route is matched, the request passes through a **middleware pipeline** before reaching the controller.

### Pipeline Architecture

```
Request enters pipeline
 │
 ▼
┌──────────────────────────────────────────────────────┐
│ AuthMiddleware                                        │
│  ├── Check session auth (auth()->check())            │
│  ├── Try remember token (auth()->loginViaRememberToken()) │
│  ├── Try JWT auth (Bearer token)                     │
│  ├── Set $request->user                              │
│  └── $next($request) ───┐                            │
│                          │                            │
│  ┌───────────────────────┘                            │
│  ▼                                                    │
│  ┌────────────────────────────────────────────────┐  │
│  │ CsrfMiddleware                                  │  │
│  │  ├── Skip for GET/HEAD/OPTIONS                  │  │
│  │  ├── Skip if route is excluded                  │  │
│  │  ├── Read token from _token field or header     │  │
│  │  ├── Csrf::verify($token)                       │  │
│  │  └── $next($request) ───┐                       │  │
│  │                          │                       │  │
│  │  ┌───────────────────────┘                       │  │
│  │  ▼                                               │  │
│  │  ┌──────────────────────────────────────────┐   │  │
│  │  │ ThrottleMiddleware                        │   │  │
│  │  │  ├── Generate key (user:id or ip:addr)   │   │  │
│  │  │  ├── Check: tooManyAttempts?              │   │  │
│  │  │  ├── Increment counter                   │   │  │
│  │  │  ├── $next($request) ──→ CONTROLLER      │   │  │
│  │  │  └── Add rate limit headers to response  │   │  │
│  │  └──────────────────────────────────────────┘   │  │
│  └────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────┘
 │
 ▼
Response returns to client
```

### How the Pipeline is Built

```php
// Middleware applied = global middleware + route middleware
$middleware = array_merge($globalMiddleware, $route->getMiddleware());

// array_reduce builds a nested callable chain
$pipeline = array_reduce(
    array_reverse($middleware),
    function ($next, $middleware) {
        return function ($request) use ($next, $middleware) {
            $instance = app()->make($middleware);
            return $instance->handle($request, $next);
        };
    },
    fn($request) => $route->run($request)  // innermost: the controller
);

$response = $pipeline($request);  // start execution
```

### Available Middleware

| Middleware | Purpose | Parameters |
|-----------|---------|------------|
| `AuthMiddleware` | Session + JWT authentication | — |
| `CsrfMiddleware` | CSRF token verification | — |
| `ThrottleMiddleware` | Rate limiting | `maxAttempts`, `decayMinutes` |
| `GuestMiddleware` | Redirect if authenticated | — |
| `JwtMiddleware` | JWT-only authentication | — |
| `LogRequestMiddleware` | Log request/response | — |
| `CorsMiddleware` | Cross-origin headers | — |

### Applying Middleware

```php
// On a single route
Router::post('/login', [AuthController::class, 'login'])
    ->middleware(CsrfMiddleware::class);

// On a group
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
});

// With parameters
Router::get('/api/users', [UserController::class, 'index'])
    ->middleware('throttle:60,1');  // 60 requests per minute
```

---

## Step 6 — Controller Dispatch

**Class:** `Core\Routing\Route`

After middleware passes, the `Route::run()` method executes the controller action.

### Dispatch Flow

```
Route::run($request)
 │
 ├── Action is [Controller::class, 'method']
 │   ├── app()->make(Controller::class)  → instantiate with DI
 │   ├── Resolve route model bindings
 │   │   └── Type-hinted Model? → Model::find($id) or 404
 │   └── app()->call([$controller, $method], $params)
 │       └── Reflection-based parameter injection
 │
 ├── Action is Closure
 │   ├── Resolve closure model bindings
 │   └── app()->call($closure, $params)
 │
 └── Action is other callable
     └── app()->call($action, $params)
```

### Dependency Injection in Controllers

```php
// Route: GET /users/{id}
Router::get('/users/{id}', [UserController::class, 'show']);

// Controller
class UserController
{
    public function show(
        Request $request,    // ← injected from route parameters
        int $id,             // ← extracted from URI {id}
        UserService $service // ← auto-resolved from container
    ): Response {
        $user = $service->find($id);
        return Response::view('users/show', ['user' => $user]);
    }
}
```

### Route Model Binding

```php
// Route: GET /posts/{id}
Router::get('/posts/{id}', [PostController::class, 'show']);

// Controller — type-hint a Model class
class PostController
{
    public function show(Request $request, Post $id): Response
    {
        // $id is automatically: Post::find($id)
        // If not found: throws NotFoundException → 404
        return Response::view('posts/show', ['post' => $id]);
    }
}
```

---

## Step 7 — Response

**Classes:** `Core\Http\Response`, `Core\Http\JsonResponse`, `Core\Http\RedirectResponse`

Controllers return a `Response` object which bubbles back through the middleware stack.

### Response Types

```
Controller returns Response
 │
 ├── Response::view('template', $data)
 │   └── Renders PHP view from resources/views/
 │
 ├── JsonResponse::success($data)
 │   └── {"success": true, "data": {...}}
 │
 ├── JsonResponse::error($message, $code)
 │   └── {"success": false, "message": "..."}
 │
 └── RedirectResponse
     └── redirect('/path')->with('key', 'value')
```

### Sending the Response

```
Response::send()
 │
 ├── session_write_close()     → persist session data
 ├── http_response_code($code) → set status (200, 404, etc.)
 ├── Send headers
 │   ├── Content-Type
 │   ├── Location (redirects)
 │   ├── X-RateLimit-* (throttle)
 │   └── Custom headers
 └── echo $content              → output body
```

---

## Step 8 — Error Handling

**Class:** `Core\Application`

Exceptions thrown anywhere in the pipeline are caught at the application level.

```
Application::handleWebRequest()
 │
 ├── try { dispatch request }
 │
 ├── catch HttpException (404, 403, 500, etc.)
 │   ├── Look for: resources/views/errors/{code}.php
 │   ├── View exists → render custom error page
 │   └── No view → render default HTML error
 │
 └── catch \Exception (unexpected errors)
     ├── Debug mode ON → show full trace
     └── Debug mode OFF → generic 500 error
```

### Throwing Errors

```php
// Using the abort() helper
abort(404);                     // NotFoundException
abort(403, 'Forbidden');        // HttpException
abort(500, 'Server error');     // HttpException

// Direct throw
throw new NotFoundException('User not found');
throw new HttpException('Bad request', 400);
```

---

## Complete Lifecycle — Visual Summary

```
                    ┌────────────────┐
                    │  HTTP Request   │
                    │  GET /users/42  │
                    └───────┬────────┘
                            │
          ┌─────────────────▼─────────────────┐
          │         public/index.php           │
          │                                    │
          │  1. Autoload (Composer)             │
          │  2. Bootstrap (services, config)    │
          │  3. Load routes (web.php, api.php)  │
          │  4. Create Request object           │
          └─────────────────┬─────────────────┘
                            │
          ┌─────────────────▼─────────────────┐
          │         Router::dispatch()         │
          │                                    │
          │  Loop routes → match URI + method  │
          │  Extract parameters: {id} = 42     │
          └─────────────────┬─────────────────┘
                            │
          ┌─────────────────▼─────────────────┐
          │        Middleware Pipeline          │
          │                                    │
          │  ┌─ AuthMiddleware ─────────────┐  │
          │  │  Verify session / JWT        │  │
          │  │  Set $request->user          │  │
          │  │  ┌─ CsrfMiddleware ───────┐  │  │
          │  │  │  Validate CSRF token   │  │  │
          │  │  │  ┌─ ThrottleMiddle. ─┐ │  │  │
          │  │  │  │  Check rate limit │ │  │  │
          │  │  │  │  ┌─ Controller ─┐ │ │  │  │
          │  │  │  │  │ Run action   │ │ │  │  │
          │  │  │  │  │ Return Resp. │ │ │  │  │
          │  │  │  │  └──────────────┘ │ │  │  │
          │  │  │  │  Add rate headers │ │  │  │
          │  │  │  └───────────────────┘ │  │  │
          │  │  └────────────────────────┘  │  │
          │  └──────────────────────────────┘  │
          └─────────────────┬─────────────────┘
                            │
          ┌─────────────────▼─────────────────┐
          │          Response::send()          │
          │                                    │
          │  Write session → Set status code   │
          │  Send headers → Output body        │
          └─────────────────┬─────────────────┘
                            │
                    ┌───────▼────────┐
                    │ HTTP Response   │
                    │ 200 OK + body   │
                    └────────────────┘
```

---

## Helper Functions

These helper functions provide quick access to the framework's services throughout the request lifecycle:

| Helper | Returns | Used For |
|--------|---------|----------|
| `app()` | Application | Container / service resolution |
| `config($key)` | mixed | Configuration values |
| `auth()` | Auth | Authentication checks |
| `session()` | Session | Session read/write |
| `request()` | Request | Current HTTP request |
| `csrf_token()` | string | CSRF token value |
| `redirect($url)` | RedirectResponse | HTTP redirects |
| `response($content)` | Response | HTTP responses |
| `json($data)` | JsonResponse | JSON responses |
| `abort($code)` | — | Throw HTTP exceptions |
| `url($path)` | string | Generate full URL |
| `route($name)` | string | Generate named route URL |

---

## Request Flow by Type

### Web Request (HTML)

```
GET /dashboard
 → AuthMiddleware (check session)
 → CsrfMiddleware (skip — GET request)
 → DashboardController::index()
 → Response::view('dashboard/index', $data)
 → HTML response
```

### API Request (JSON)

```
POST /api/users  (Authorization: Bearer <token>)
 → AuthMiddleware (verify JWT)
 → ThrottleMiddleware (rate limit: 60/min)
 → UserController::store()
 → JsonResponse::created($user)
 → JSON response with 201 status
```

### Form Submission

```
POST /login  (_token=abc123)
 → CsrfMiddleware (verify _token)
 → GuestMiddleware (redirect if already logged in)
 → AuthController::login()
 → redirect('/dashboard')->with('success', '...')
 → 302 redirect with flash data
```

---

## Key Source Files

| File | Purpose |
|------|---------|
| `public/index.php` | Application entry point |
| `bootstrap/app.php` | Service registration and boot |
| `core/Application.php` | Application container and error handling |
| `core/Container/Container.php` | Dependency injection container |
| `core/Routing/Router.php` | Route matching and middleware pipeline |
| `core/Routing/Route.php` | Route definition and controller dispatch |
| `core/Http/Request.php` | HTTP request wrapper |
| `core/Http/Response.php` | HTTP response (HTML) |
| `core/Http/JsonResponse.php` | JSON response |
| `core/Http/RedirectResponse.php` | Redirect response |
| `core/Support/Helpers.php` | Global helper functions |
| `routes/web.php` | Web route definitions |
| `routes/api.php` | API route definitions |
