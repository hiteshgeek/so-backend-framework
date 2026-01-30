# Routing System

The SO Framework provides a powerful and expressive routing system similar to Laravel. Routes define how your application responds to HTTP requests by mapping URLs to controller actions or closures.

## Table of Contents

1. [Basic Routing](#basic-routing)
2. [Route Parameters](#route-parameters)
3. [Parameter Constraints](#parameter-constraints)
4. [Named Routes](#named-routes)
5. [Route Groups](#route-groups)
6. [Middleware](#middleware)
7. [Resource Routes](#resource-routes)
8. [API Resources](#api-resources)
9. [Route Model Binding](#route-model-binding)
10. [Fallback Routes](#fallback-routes)
11. [Redirect Routes](#redirect-routes)
12. [View Routes](#view-routes)
13. [Current Route Helpers](#current-route-helpers)
14. [URL Generation](#url-generation)
15. [Best Practices](#best-practices)

---

## Basic Routing

Routes are defined in `routes/web.php` for web routes and `routes/api.php` for API routes.

### HTTP Methods

```php
use Core\Routing\Router;

// GET request
Router::get('/users', [UserController::class, 'index']);

// POST request
Router::post('/users', [UserController::class, 'store']);

// PUT request
Router::put('/users/{id}', [UserController::class, 'update']);

// DELETE request
Router::delete('/users/{id}', [UserController::class, 'destroy']);

// PATCH request
Router::patch('/users/{id}', [UserController::class, 'patch']);

// Match any HTTP method
Router::any('/contact', [ContactController::class, 'handle']);

// Match specific HTTP methods
Router::match(['GET', 'POST'], '/form', [FormController::class, 'handle']);
```

### Closure Routes

For simple routes, you can use closures instead of controllers:

```php
Router::get('/hello', function () {
    return response('Hello, World!');
});

Router::get('/user/{id}', function ($id) {
    return json(['user_id' => $id]);
});
```

### Controller Actions

Route to controller methods using array syntax:

```php
Router::get('/users', [UserController::class, 'index']);
Router::post('/users', [UserController::class, 'store']);
```

---

## Route Parameters

### Required Parameters

Capture segments of the URI using curly braces:

```php
Router::get('/users/{id}', function ($id) {
    return json(['user_id' => $id]);
});

Router::get('/posts/{post}/comments/{comment}', function ($post, $comment) {
    return json(['post' => $post, 'comment' => $comment]);
});
```

### Optional Parameters

Add `?` after the parameter name for optional parameters:

```php
Router::get('/users/{name?}', function ($name = 'Guest') {
    return response("Hello, {$name}!");
});
```

---

## Parameter Constraints

Constrain route parameters using regex patterns for enhanced security and routing precision.

### Generic Constraint

```php
// Custom regex pattern
Router::get('/users/{id}', [UserController::class, 'show'])
    ->where('id', '[0-9]+');

// Multiple constraints
Router::get('/posts/{category}/{slug}', [PostController::class, 'show'])
    ->where([
        'category' => '[a-z]+',
        'slug' => '[a-z0-9-]+'
    ]);
```

### Built-in Constraint Methods

```php
// Numeric only (0-9)
Router::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id');

// Alphabetic only (a-z, A-Z)
Router::get('/categories/{name}', [CategoryController::class, 'show'])
    ->whereAlpha('name');

// Alphanumeric only (a-z, A-Z, 0-9)
Router::get('/products/{code}', [ProductController::class, 'show'])
    ->whereAlphaNumeric('code');

// UUID format
Router::get('/orders/{uuid}', [OrderController::class, 'show'])
    ->whereUuid('uuid');

// Slug format (alphanumeric with dashes)
Router::get('/posts/{slug}', [PostController::class, 'show'])
    ->whereSlug('slug');

// Specific values only
Router::get('/status/{type}', [StatusController::class, 'show'])
    ->whereIn('type', ['pending', 'active', 'completed']);
```

### Multiple Parameters

Apply constraints to multiple parameters at once:

```php
Router::get('/users/{user}/posts/{post}', [PostController::class, 'show'])
    ->whereNumber('user', 'post');
```

---

## Named Routes

Assign names to routes for easy URL generation:

```php
Router::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show');

Router::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');
```

### Generating URLs for Named Routes

```php
// Using route() helper
$url = route('users.show', ['id' => 1]);
// Result: http://yoursite.com/users/1

// In views
<a href="<?= route('users.show', ['id' => $user->id]) ?>">View User</a>
```

---

## Route Groups

Group routes that share common attributes like prefixes or middleware.

### Prefix Groups

```php
Router::group(['prefix' => 'admin'], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
    Router::get('/users', [AdminController::class, 'users']);
    Router::get('/settings', [AdminController::class, 'settings']);
});

// Results in:
// /admin/dashboard
// /admin/users
// /admin/settings
```

### Middleware Groups

```php
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::put('/profile', [ProfileController::class, 'update']);
});
```

### Combined Attributes

```php
Router::group([
    'prefix' => 'api/v1',
    'middleware' => [ApiAuthMiddleware::class, ThrottleMiddleware::class]
], function () {
    Router::get('/users', [ApiUserController::class, 'index']);
    Router::post('/users', [ApiUserController::class, 'store']);
});
```

### Nested Groups

```php
Router::group(['prefix' => 'admin'], function () {
    Router::group(['middleware' => [AdminMiddleware::class]], function () {
        Router::get('/users', [AdminUserController::class, 'index']);
    });
});
```

---

## Middleware

### Route-Level Middleware

```php
Router::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

// Multiple middleware
Router::post('/admin/users', [AdminController::class, 'store'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class]);
```

### Global Middleware

Apply middleware to all routes:

```php
// In bootstrap or service provider
Router::globalMiddleware([
    CsrfMiddleware::class,
    SessionMiddleware::class
]);
```

---

## Resource Routes

Quickly generate routes for CRUD operations:

```php
Router::resource('posts', PostController::class);
```

This generates:

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | /posts | index | List all posts |
| GET | /posts/create | create | Show create form |
| POST | /posts | store | Store new post |
| GET | /posts/{id} | show | Show single post |
| GET | /posts/{id}/edit | edit | Show edit form |
| PUT | /posts/{id} | update | Update post |
| DELETE | /posts/{id} | destroy | Delete post |

---

## API Resources

For API routes (without create/edit form routes):

```php
Router::apiResource('posts', PostApiController::class);
```

This generates:

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | /posts | index | List all posts |
| POST | /posts | store | Store new post |
| GET | /posts/{id} | show | Show single post |
| PUT | /posts/{id} | update | Update post |
| DELETE | /posts/{id} | destroy | Delete post |

---

## Route Model Binding

Automatically inject model instances into route handlers based on the parameter value.

### Implicit Binding

When the parameter name matches a model class, the framework automatically fetches the model:

```php
// Route definition
Router::get('/users/{user}', function (\App\Models\User $user) {
    // $user is automatically fetched from database where id = {user}
    return json($user->toArray());
});

// Controller method
class UserController
{
    public function show(\App\Models\User $user)
    {
        // $user is automatically resolved
        return json($user->toArray());
    }
}
```

### How It Works

1. The framework inspects the route handler's type hints
2. If a parameter is type-hinted with a Model class, it fetches the model by ID
3. If the model isn't found, a `NotFoundException` is thrown (404 response)

```php
// This route automatically fetches the User model
Router::get('/users/{user}', [UserController::class, 'show']);

// Controller
class UserController
{
    public function show(User $user)
    {
        // $user is already a User model instance
        return json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
```

---

## Fallback Routes

Define a catch-all route for unmatched requests:

```php
Router::fallback(function () {
    return response('Page not found', 404);
});

// Or redirect to home
Router::fallback(function () {
    return redirect('/');
});

// With custom 404 view
Router::fallback(function () {
    return \Core\Http\Response::view('errors.404', [], 404);
});
```

**Note:** The fallback route should be defined after all other routes.

---

## Redirect Routes

Create routes that redirect to other URLs:

```php
// Temporary redirect (302)
Router::redirect('/old-page', '/new-page');

// Permanent redirect (301)
Router::permanentRedirect('/legacy-url', '/modern-url');

// Custom status code
Router::redirect('/moved', '/destination', 307);
```

---

## View Routes

Return a view without a controller:

```php
// Simple view
Router::view('/about', 'about');

// View with data
Router::view('/welcome', 'welcome', [
    'name' => 'Guest',
    'title' => 'Welcome Page'
]);
```

---

## Current Route Helpers

Access information about the current route:

### In Code

```php
// Get current route instance
$route = Router::current();

// Get current route name
$name = Router::currentRouteName();
// Returns: "users.show" or null

// Get current route action
$action = Router::currentRouteAction();
// Returns: "App\Controllers\UserController@show" or "Closure"

// Check if current route matches name(s)
if (Router::is('users.*')) {
    // Current route name starts with "users."
}

if (Router::is('users.show', 'users.edit')) {
    // Current route is either "users.show" or "users.edit"
}
```

### Helper Functions

```php
// Get current route
$route = current_route();

// Get current route name
$name = current_route_name();

// Get current route action
$action = current_route_action();

// Check if route matches
if (route_is('dashboard')) {
    // On dashboard route
}

if (route_is('admin.*')) {
    // On any admin route
}
```

### In Views

```php
<?php if (route_is('home')): ?>
    <li class="active">Home</li>
<?php else: ?>
    <li><a href="<?= route('home') ?>">Home</a></li>
<?php endif; ?>
```

---

## URL Generation

### Using url() Helper

```php
// Generate URL from path
$url = url('/users/1');
// Result: http://yoursite.com/users/1

// Base URL
$baseUrl = url('/');
// Result: http://yoursite.com/
```

### Using route() Helper

```php
// Named route URL
$url = route('users.show', ['id' => 1]);
// Result: http://yoursite.com/users/1

// In views
<a href="<?= route('posts.edit', ['id' => $post->id]) ?>">Edit</a>
```

### Checking Route Existence

```php
if (Router::has('users.profile')) {
    $url = route('users.profile', ['id' => $user->id]);
}
```

---

## Best Practices

### 1. Use Named Routes

Always name your routes for maintainability:

```php
// Good
Router::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Avoid hardcoded URLs in views
<a href="<?= route('users.show', ['id' => 1]) ?>">View User</a>
```

### 2. Apply Parameter Constraints

Validate route parameters early:

```php
// Good - rejects non-numeric IDs at routing level
Router::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id');

// Without constraint, "abc" would be passed to controller
Router::get('/users/{id}', [UserController::class, 'show']);
```

### 3. Group Related Routes

Organize routes logically:

```php
// API routes
Router::group(['prefix' => 'api/v1'], function () {
    Router::apiResource('users', ApiUserController::class);
    Router::apiResource('posts', ApiPostController::class);
});

// Admin routes
Router::group(['prefix' => 'admin', 'middleware' => [AdminMiddleware::class]], function () {
    Router::resource('users', AdminUserController::class);
});
```

### 4. Use Route Model Binding

Let the framework handle model fetching:

```php
// Good - automatic 404 if user not found
public function show(User $user)
{
    return json($user);
}

// Manual approach (still valid but more verbose)
public function show($id)
{
    $user = User::find($id);
    if (!$user) {
        throw new NotFoundException('User not found');
    }
    return json($user);
}
```

### 5. Define Fallback Route

Always handle 404 cases gracefully:

```php
// Define after all other routes
Router::fallback(function () {
    if (request()->expectsJson()) {
        return json(['error' => 'Not Found'], 404);
    }
    return \Core\Http\Response::view('errors.404', [], 404);
});
```

### 6. Apply Middleware Appropriately

Use middleware at the right level:

```php
// Global middleware for all routes
Router::globalMiddleware([SessionMiddleware::class]);

// Group middleware for related routes
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    // Protected routes
});

// Route-specific middleware
Router::post('/admin/delete-all', [AdminController::class, 'deleteAll'])
    ->middleware([SuperAdminMiddleware::class]);
```

---

## Complete Example

Here's a complete `routes/web.php` example:

```php
<?php

use Core\Routing\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

// Public routes
Router::get('/', [HomeController::class, 'index'])->name('home');
Router::view('/about', 'about')->name('about');
Router::view('/contact', 'contact')->name('contact');

// Auth routes
Router::get('/login', [AuthController::class, 'showLogin'])->name('login');
Router::post('/login', [AuthController::class, 'login'])->name('login.submit');
Router::post('/logout', [AuthController::class, 'logout'])->name('logout');
Router::get('/register', [AuthController::class, 'showRegister'])->name('register');
Router::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Protected routes
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // User profile
    Router::get('/profile', [UserController::class, 'profile'])->name('profile');
    Router::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Posts
    Router::resource('posts', PostController::class);
});

// Admin routes
Router::group([
    'prefix' => 'admin',
    'middleware' => [AuthMiddleware::class, AdminMiddleware::class]
], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Router::resource('users', AdminController::class);
});

// API routes
Router::group(['prefix' => 'api/v1'], function () {
    Router::apiResource('posts', ApiPostController::class);

    Router::get('/users/{user}', function (\App\Models\User $user) {
        return json($user->toArray());
    })->whereNumber('user');
});

// Redirects
Router::permanentRedirect('/old-blog', '/posts');

// Fallback (must be last)
Router::fallback(function () {
    if (request()->expectsJson()) {
        return json(['error' => 'Not Found'], 404);
    }
    return \Core\Http\Response::view('errors.404', [], 404);
});
```

---

## Quick Reference

| Feature | Syntax |
|---------|--------|
| GET route | `Router::get('/path', $action)` |
| POST route | `Router::post('/path', $action)` |
| Any method | `Router::any('/path', $action)` |
| Multiple methods | `Router::match(['GET', 'POST'], '/path', $action)` |
| Required param | `Router::get('/users/{id}', ...)` |
| Optional param | `Router::get('/users/{id?}', ...)` |
| Number constraint | `->whereNumber('id')` |
| Alpha constraint | `->whereAlpha('name')` |
| UUID constraint | `->whereUuid('uuid')` |
| Custom constraint | `->where('id', '[0-9]+')` |
| Named route | `->name('users.show')` |
| Middleware | `->middleware([AuthMiddleware::class])` |
| Route group | `Router::group(['prefix' => ...], fn)` |
| Resource routes | `Router::resource('posts', Controller::class)` |
| API resources | `Router::apiResource('posts', Controller::class)` |
| Fallback | `Router::fallback($action)` |
| Redirect | `Router::redirect('/from', '/to')` |
| View route | `Router::view('/about', 'about')` |
| Current route | `Router::current()` |
| Route name | `Router::currentRouteName()` |
| Check route | `Router::is('admin.*')` |
