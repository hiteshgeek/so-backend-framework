# Helper Functions Reference - Developer Guide

**SO Framework** | **Global Helper Functions** | **Version 1.0**

A comprehensive reference to all available helper functions for rapid development.

---

## Table of Contents

1. [Overview](#overview)
2. [Configuration & Environment](#configuration--environment)
3. [Path Helpers](#path-helpers)
4. [HTTP & Routing](#http--routing)
5. [Authentication & Security](#authentication--security)
6. [Session & Cache](#session--cache)
7. [Database & Models](#database--models)
8. [View & Output](#view--output)
9. [String Helpers](#string-helpers)
10. [Array & Collection](#array--collection)
11. [Logging & Debugging](#logging--debugging)
12. [Queue & Events](#queue--events)

---

## Overview

Helper functions provide quick access to common framework features without needing to instantiate classes or use facades.

### How to Use

Helpers are globally available - just call them:

```php
// No imports needed
$value = config('app.name');
$user = auth()->user();
cache()->put('key', 'value', 3600);
```

---

## Configuration & Environment

### app()

Get the application instance or resolve a binding from the container.

```php
app(?string $abstract = null): mixed
```

**Examples:**

```php
// Get application instance
$app = app();

// Resolve from container
$router = app('router');
$cache = app('cache');
$auth = app('auth');

// Make instance
$validator = app(\Core\Validation\Validator::class);

// Check if bound
if ($app->has('custom.service')) {
    $service = app('custom.service');
}
```

---

### env()

Get environment variable value.

```php
env(string $key, mixed $default = null): mixed
```

**Examples:**

```php
// Get with default
$debug = env('APP_DEBUG', false);

// Database credentials
$host = env('DB_HOST', 'localhost');
$port = env('DB_PORT', 3306);

// API keys
$apiKey = env('STRIPE_API_KEY');
```

---

### config()

Get configuration value.

```php
config(string $key, mixed $default = null): mixed
```

**Examples:**

```php
// App configuration
$appName = config('app.name');
$debug = config('app.debug', false);

// Database configuration
$connection = config('database.default');
$host = config('database.connections.mysql.host');

// Nested values
$jwtSecret = config('security.jwt.secret');
```

---

## Path Helpers

### base_path()

Get the base path of the application.

```php
base_path(string $path = ''): string
```

**Examples:**

```php
// Base directory
$base = base_path(); // /var/www/html/project

// Specific file
$envPath = base_path('.env');
$composerPath = base_path('composer.json');
```

---

### storage_path()

Get the storage directory path.

```php
storage_path(string $path = ''): string
```

**Examples:**

```php
// Storage directory
$storage = storage_path(); // /var/www/html/project/storage

// Logs
$logPath = storage_path('logs/app.log');

// Cache
$cachePath = storage_path('cache/views');

// Uploads
$uploadPath = storage_path('uploads/images');
```

---

### public_path()

Get the public directory path.

```php
public_path(string $path = ''): string
```

**Examples:**

```php
// Public directory
$public = public_path(); // /var/www/html/project/public

// Assets
$cssPath = public_path('assets/css/app.css');
$jsPath = public_path('assets/js/app.js');

// Uploads (public)
$avatarPath = public_path('uploads/avatars/user.jpg');
```

---

### config_path()

Get the config directory path.

```php
config_path(string $path = ''): string
```

**Examples:**

```php
// Config directory
$config = config_path(); // /var/www/html/project/config

// Specific config file
$dbConfig = config_path('database.php');
```

---

## HTTP & Routing

### url()

Generate absolute URL.

```php
url(string $path = ''): string
```

**Examples:**

```php
// Base URL
$baseUrl = url(); // https://example.com

// Specific path
$apiUrl = url('/api/users'); // https://example.com/api/users

// Asset URL
$imageUrl = url('/images/logo.png');
```

---

### route()

Generate URL for named route.

```php
route(string $name, array $parameters = []): string
```

**Examples:**

```php
// Simple route
$url = route('home'); // /

// Route with parameters
$url = route('user.show', ['id' => 123]); // /users/123
$url = route('post.edit', ['id' => 5]); // /posts/5/edit

// Multiple parameters
$url = route('category.product', [
    'category' => 'electronics',
    'product' => 'laptop'
]); // /categories/electronics/products/laptop
```

---

### redirect()

Create redirect response.

```php
redirect(string $url, int $status = 302): RedirectResponse
```

**Examples:**

```php
// Redirect to URL
return redirect('/dashboard');

// Redirect with status code
return redirect('/login', 301); // Permanent redirect

// Redirect to named route
return redirect(route('user.profile'));

// Redirect with flash message
return redirect('/dashboard')->with('success', 'Login successful');

// Redirect with errors
return redirect()->back()->withErrors(['error' => 'Invalid input']);

// Redirect with old input
return redirect()->back()->withInput();
```

---

### back()

Redirect back to previous page.

```php
back(): RedirectResponse
```

**Examples:**

```php
// Go back
return back();

// Go back with message
return back()->with('error', 'Something went wrong');

// Go back with errors
return back()->withErrors(['email' => 'Email is required']);

// Go back with input
return back()->withInput();
```

---

### router()

Get the router instance.

```php
router(): Router
```

**Examples:**

```php
// Get router
$router = router();

// Add route dynamically
router()->get('/custom', function() {
    return 'Custom route';
});

// Get all routes
$routes = router()->getRoutes();

// Get current route
$current = router()->current();
```

---

### current_route()

Get the currently matched route object.

```php
current_route(): ?Route
```

**Examples:**

```php
// Get current route
$route = current_route();

// Get route information
if ($route) {
    $name = $route->name;
    $uri = $route->uri;
    $methods = $route->methods;
    $middleware = $route->middleware;
}
```

---

### route_is()

Check if the current route matches the given name(s). Supports wildcard patterns.

```php
route_is(string ...$names): bool
```

**Examples:**

```php
// Exact match
if (route_is('home')) {
    // Current route is 'home'
}

// Multiple names
if (route_is('user.show', 'user.edit')) {
    // Current route is either user.show or user.edit
}

// Wildcard patterns
if (route_is('admin.*')) {
    // Any admin route
}

if (route_is('user.*', 'profile.*')) {
    // Any user or profile route
}

// In views
<nav>
    <a href="/dashboard" class="<?= route_is('dashboard') ? 'active' : '' ?>">Dashboard</a>
    <a href="/profile" class="<?= route_is('profile.*') ? 'active' : '' ?>">Profile</a>
</nav>
```

---

### current_route_name()

Get the name of the currently matched route.

```php
current_route_name(): ?string
```

**Examples:**

```php
// Get current route name
$name = current_route_name(); // 'user.show'

// Use in conditionals
if (current_route_name() === 'dashboard') {
    // Dashboard-specific logic
}

// In views
<body class="page-<?= current_route_name() ?>">
```

---

### current_route_action()

Get the action (controller method) of the currently matched route.

```php
current_route_action(): ?string
```

**Examples:**

```php
// Get current action
$action = current_route_action(); // 'App\Controllers\UserController@show'

// Check controller
if (str_contains(current_route_action(), 'AdminController')) {
    // Admin controller
}
```

---

### request()

Get current request instance.

```php
request(): Request
```

**Examples:**

```php
// Get request
$request = request();

// Get input
$email = request()->input('email');
$all = request()->all();

// Get method
$method = request()->method(); // GET, POST, etc.

// Get IP
$ip = request()->ip();

// Check if AJAX
if (request()->isAjax()) {
    // Handle AJAX request
}
```

---

### response()

Create HTTP response.

```php
response(string $content = '', int $status = 200, array $headers = []): Response
```

**Examples:**

```php
// Simple response
return response('Hello World');

// Response with status
return response('Not Found', 404);

// Response with headers
return response('OK', 200, [
    'X-Custom-Header' => 'Value'
]);
```

---

### json()

Create JSON response.

```php
json(array $data, int $status = 200, array $headers = []): JsonResponse
```

**Examples:**

```php
// Simple JSON
return json(['message' => 'Success']);

// With status code
return json(['error' => 'Not found'], 404);

// API response
return json([
    'status' => 'success',
    'data' => $users,
    'meta' => [
        'total' => count($users),
        'page' => 1,
    ]
]);
```

---

### abort()

Abort with HTTP exception.

```php
abort(int $code, string $message = ''): never
```

**Examples:**

```php
// 404 Not Found
abort(404);
abort(404, 'Page not found');

// 403 Forbidden
abort(403, 'Access denied');

// 500 Server Error
abort(500, 'Internal server error');

// In controller
if (!$user) {
    abort(404, 'User not found');
}
```

---

## Authentication & Security

### auth()

Get authentication instance.

```php
auth(): Auth
```

**Examples:**

```php
// Check if authenticated
if (auth()->check()) {
    // User is logged in
}

// Get current user
$user = auth()->user();
$userId = $user['id'];
$email = $user['email'];

// Login
auth()->login($user);

// Logout
auth()->logout();

// Get user ID
$id = auth()->id();
```

---

### csrf_token()

Get CSRF token.

```php
csrf_token(): string
```

**Examples:**

```php
// Get token
$token = csrf_token();

// Use in AJAX
?>
<script>
    fetch('/api/data', {
        headers: {
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        }
    });
</script>
```

---

### csrf_field()

Generate CSRF hidden input field.

```php
csrf_field(): string
```

**Examples:**

```php
// In forms
<form method="POST" action="/submit">
    <?= csrf_field() ?>
    <input type="text" name="name">
    <button type="submit">Submit</button>
</form>

// Outputs:
// <input type="hidden" name="_token" value="...">
```

---

### jwt()

Get JWT instance.

```php
jwt(): JWT
```

**Examples:**

```php
// Encode token
$token = jwt()->encode([
    'user_id' => 123,
    'email' => 'user@example.com'
], 3600);

// Decode token
try {
    $payload = jwt()->decode($token);
    $userId = $payload['user_id'];
} catch (\Exception $e) {
    // Invalid or expired token
}

// Invalidate token
jwt()->invalidate($token);

// Invalidate all user tokens
jwt()->invalidateUser($userId);
```

---

### e()

Escape HTML entities (prevent XSS).

```php
e(mixed $value): string
```

**Examples:**

```php
// Escape user input
$safe = e($userInput);

// In views
<p><?= e($post->title) ?></p>
<div><?= e($comment->content) ?></div>

// Handles null
$output = e(null); // Returns empty string

// Escapes HTML
$html = '<script>alert("xss")</script>';
echo e($html); // &lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;
```

---

### sanitize()

Sanitize input data.

```php
sanitize(mixed $data): mixed
```

**Examples:**

```php
// Sanitize string
$clean = sanitize($userInput);

// Sanitize array
$cleanData = sanitize($_POST);

// Sanitize nested arrays
$data = sanitize([
    'name' => '<b>John</b>',
    'email' => 'test@example.com',
    'bio' => '<script>alert("xss")</script>',
]);
```

---

## Session & Cache

### session()

Get session instance or value.

```php
session(?string $key = null, mixed $default = null): mixed
```

**Examples:**

```php
// Get session instance
$session = session();

// Get value
$userId = session('user_id');
$name = session('name', 'Guest');

// Set value
session()->set('key', 'value');

// Flash message (available for next request only)
session()->flash('success', 'Operation completed');

// Get flash message
$message = session()->get('success');

// Check if exists
if (session()->has('user_id')) {
    // Session key exists
}

// Remove value
session()->forget('key');

// Clear all
session()->flush();
```

---

### old()

Get old input value (from previous request).

```php
old(string $key, mixed $default = null): mixed
```

**Examples:**

```php
// In forms after validation error
<input type="text" name="email" value="<?= old('email') ?>">
<input type="text" name="name" value="<?= old('name', 'Default') ?>">

// Controller usage
$email = old('email'); // Value from previous request
```

---

### cache()

Get cache instance or value.

```php
cache(?string $key = null, mixed $default = null): mixed
```

**Examples:**

```php
// Get cache instance
$cache = cache();

// Get value
$users = cache('users.all');
$count = cache('user.count', 0);

// Store value
cache()->put('key', 'value', 3600); // 3600 seconds

// Store forever
cache()->forever('settings', $settings);

// Remember pattern
$users = cache()->remember('users', 3600, function() {
    return User::all();
});

// Check if exists
if (cache()->has('key')) {
    // Cache exists
}

// Delete
cache()->forget('key');

// Clear all
cache()->flush();
```

---

## Database & Models

### db()

Get database connection (if available).

```php
// Direct query
$users = db()->table('users')->where('active', true)->get();

// Raw query
$results = db()->select('SELECT * FROM users WHERE id = ?', [1]);
```

---

### validate()

Validate data against rules.

```php
validate(array $data, array $rules, array $messages = []): array
```

**Examples:**

```php
// Basic validation
try {
    $validated = validate($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);
} catch (ValidationException $e) {
    // Handle errors
    $errors = $e->errors();
}

// With custom messages
$validated = validate($data, [
    'name' => 'required|string|max:255',
    'age' => 'required|integer|min:18',
], [
    'name.required' => 'Please enter your name',
    'age.min' => 'You must be at least 18 years old',
]);
```

---

## View & Output

### view()

Render view template.

```php
view(string $view, array $data = []): string
```

**Examples:**

```php
// Render view
$html = view('home/index');

// With data
$html = view('users/show', [
    'user' => $user,
    'posts' => $posts,
]);

// In controller
return Response::view('dashboard', [
    'stats' => $stats,
]);

// Nested views
$content = view('partials/header') . view('content') . view('partials/footer');
```

---

### asset()

Generate versioned asset URL.

```php
asset(string $path): string
```

**Examples:**

```php
// CSS
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">

// JavaScript
<script src="<?= asset('js/app.js') ?>"></script>

// Images
<img src="<?= asset('images/logo.png') ?>" alt="Logo">

// With cache busting
// Output: /assets/css/app.css?v=1706742000
```

---

### assets()

Get the AssetManager instance for advanced asset management.

```php
assets(): AssetManager
```

**Examples:**

```php
// Get asset manager
$manager = assets();

// Register CSS
assets()->css('app.css');
assets()->css('custom.css', ['position' => 'head', 'priority' => 10]);

// Register JavaScript
assets()->js('app.js');
assets()->js('analytics.js', ['position' => 'body_end']);

// Inline styles/scripts
assets()->inlineStyle('.custom { color: red; }');
assets()->inlineScript('console.log("loaded");');

// Check if registered
if (assets()->has('app.css')) {
    // Asset already registered
}
```

---

### push_stack()

Push content onto a named asset stack (for custom assets).

```php
push_stack(string $name, string $content, int $priority = 50): void
```

**Examples:**

```php
// Push to styles stack
push_stack('styles', '<link rel="stylesheet" href="/custom.css">');

// Push to scripts stack
push_stack('scripts', '<script src="/analytics.js"></script>');

// With priority (lower = rendered first)
push_stack('scripts', '<script src="/vendor.js"></script>', 10);
push_stack('scripts', '<script src="/app.js"></script>', 20);

// Custom stacks
push_stack('meta-tags', '<meta name="description" content="...">');
push_stack('social-meta', '<meta property="og:title" content="...">');

// In child views
push_stack('head', '<style>.page-specific { color: blue; }</style>');
```

---

### render_stack()

Render a named asset stack.

```php
render_stack(string $name): string
```

**Examples:**

```php
// In layout template
<head>
    <?= render_stack('styles') ?>
    <?= render_stack('meta-tags') ?>
</head>

// In body
<body>
    <?= $content ?>
    <?= render_stack('scripts') ?>
    <?= render_stack('body_end') ?>
</body>

// Check if stack has content
<?php if (!empty(render_stack('social-meta'))): ?>
    <?= render_stack('social-meta') ?>
<?php endif; ?>
```

---

### render_assets()

Render all registered assets for a specific position.

```php
render_assets(string $position): string
```

**Examples:**

```php
// In layout head
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <?= render_assets('head') ?>
</head>

// Before closing body tag
<body>
    <?= $content ?>
    <?= render_assets('body_end') ?>
</body>

// Typical usage in layout
<!DOCTYPE html>
<html>
<head>
    <?= render_assets('head') ?>
    <!-- All CSS and head scripts render here -->
</head>
<body>
    <?= $content ?>
    <?= render_assets('body_end') ?>
    <!-- All body_end scripts render here -->
</body>
</html>
```

**See Also:** [Asset Management Guide](ASSET-MANAGEMENT.md)

---

## String Helpers

### str_contains()

Check if string contains substring.

```php
str_contains(string $haystack, string $needle): bool
```

**Examples:**

```php
if (str_contains('hello world', 'world')) {
    // True
}

if (str_contains($email, '@')) {
    // Valid email format check
}
```

---

### str_starts_with()

Check if string starts with substring.

```php
str_starts_with(string $haystack, string $needle): bool
```

**Examples:**

```php
if (str_starts_with($url, 'https://')) {
    // Secure URL
}

if (str_starts_with($filename, 'temp_')) {
    // Temporary file
}
```

---

### str_ends_with()

Check if string ends with substring.

```php
str_ends_with(string $haystack, string $needle): bool
```

**Examples:**

```php
if (str_ends_with($filename, '.pdf')) {
    // PDF file
}

if (str_ends_with($url, '/')) {
    // URL ends with slash
}
```

---

### class_basename()

Get class name without namespace.

```php
class_basename(string|object $class): string
```

**Examples:**

```php
$basename = class_basename('App\Models\User'); // 'User'
$basename = class_basename($userObject); // 'User'
$basename = class_basename('Core\Http\Request'); // 'Request'
```

---

## Array & Collection

### collect()

Create collection from array.

```php
collect(array $items = []): Collection
```

**Examples:**

```php
// Create collection
$collection = collect([1, 2, 3, 4, 5]);

// Chain methods
$result = collect($users)
    ->filter(fn($user) => $user->active)
    ->map(fn($user) => $user->name)
    ->values()
    ->all();

// Use collection methods
$sum = collect([1, 2, 3])->sum(); // 6
$first = collect($users)->first(); // First user
$plucked = collect($users)->pluck('email'); // Array of emails
```

---

### blank()

Determine if value is blank.

```php
blank(mixed $value): bool
```

**Examples:**

```php
blank(null); // true
blank(''); // true
blank('   '); // true
blank([]); // true
blank(0); // false
blank('0'); // false
blank(false); // false
```

---

### filled()

Determine if value is filled (not blank).

```php
filled(mixed $value): bool
```

**Examples:**

```php
filled('hello'); // true
filled([1, 2]); // true
filled(0); // true
filled(''); // false
filled(null); // false
```

---

### value()

Return default value of value (resolve closures).

```php
value(mixed $value): mixed
```

**Examples:**

```php
// Simple value
$result = value('hello'); // 'hello'

// Closure
$result = value(fn() => 'computed'); // 'computed'

// Conditional default
$default = value(fn() => expensive_operation());
```

---

### with()

Return the given value (useful for chaining or one-liners).

```php
with(mixed $value): mixed
```

**Examples:**

```php
// Simple return
$user = with($user);

// Useful for compact expressions
return with(User::find($id))->update(['active' => true]);

// Transform and return
$data = with(['a' => 1, 'b' => 2]);
```

---

## Logging & Debugging

### logger()

Get logger instance or log message.

```php
logger(?string $message = null, array $context = []): ?Logger
```

**Examples:**

```php
// Get logger instance
$log = logger();

// Quick debug log
logger('Debug message', ['key' => 'value']);

// Log levels
logger()->info('User logged in', ['user_id' => 123]);
logger()->warning('Low disk space');
logger()->error('Payment failed', ['order_id' => 456]);
logger()->debug('Query executed', ['sql' => $sql]);

// Channels
logger()->channel('security')->warning('Failed login');
logger()->channel('payments')->error('Payment error');
```

---

### dd()

Dump and die (for debugging).

```php
dd(mixed ...$vars): never
```

**Examples:**

```php
// Dump single variable
dd($user);

// Dump multiple variables
dd($user, $posts, $settings);

// In controller
public function debug() {
    $data = ['key' => 'value'];
    dd($data); // Dumps and stops execution
}
```

---

### now()

Get current DateTime object.

```php
now(): DateTime
```

**Examples:**

```php
// Get current datetime
$now = now();

// Format
$formatted = now()->format('Y-m-d H:i:s');

// Comparison
$expires = now()->modify('+1 hour');

// Store in database
$data = [
    'created_at' => now()->format('Y-m-d H:i:s'),
    'expires_at' => now()->modify('+24 hours')->format('Y-m-d H:i:s'),
];

// Use in timestamps
cache()->put('key', 'value', now()->modify('+1 hour')->getTimestamp());
```

---

## Queue & Events

### queue()

Get queue manager instance.

```php
queue(?string $connection = null): QueueManager|Queue
```

**Examples:**

```php
// Get queue manager
$manager = queue();

// Get specific connection
$redis = queue('redis');
$database = queue('database');
```

---

### dispatch()

Dispatch job to queue.

```php
dispatch(Job $job, ?string $queue = null): string
```

**Examples:**

```php
use App\Jobs\SendEmailJob;

// Dispatch job
$jobId = dispatch(new SendEmailJob($user));

// Dispatch to specific queue
$jobId = dispatch(new ProcessOrderJob($order), 'high-priority');

// Job class example
class SendEmailJob extends \Core\Queue\Job
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        // Send email
    }
}
```

---

### event()

Dispatch event.

```php
event(Event|string $event, array $payload = []): array
```

**Examples:**

```php
// Dispatch event
event('user.registered', ['user' => $user]);

// Event object
event(new UserRegistered($user));

// Get listener responses
$responses = event('order.created', ['order' => $order]);
```

---

### activity()

Get activity logger instance.

```php
activity(?string $logName = null): ActivityLogger
```

**Examples:**

```php
// Log activity
activity()
    ->causedBy(auth()->user())
    ->performedOn($post)
    ->log('Post updated');

// Specific log
activity('admin')
    ->log('Settings changed');
```

---

## Complete Usage Example

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Post;

class PostController
{
    public function index(): Response
    {
        // Cache with helper
        $posts = cache()->remember('posts.all', 3600, function() {
            return Post::where('published', true)->get();
        });

        // Log
        logger()->info('Posts page viewed', [
            'user_id' => auth()->user()['id'] ?? null,
            'ip' => request()->ip(),
        ]);

        // Return view
        return Response::view('posts/index', [
            'posts' => $posts,
            'appName' => config('app.name'),
        ]);
    }

    public function store(Request $request): Response
    {
        try {
            // Validate
            $data = validate($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Sanitize
            $data = sanitize($data);

            // Create post
            $post = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => auth()->user()['id'],
            ]);

            // Clear cache
            cache()->forget('posts.all');

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($post)
                ->log('Post created');

            // Redirect with message
            return redirect(route('post.show', ['id' => $post->id]))
                ->with('success', 'Post created successfully');

        } catch (\Core\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            logger()->error('Post creation failed', ['exception' => $e]);

            return back()
                ->withErrors(['error' => 'Failed to create post'])
                ->withInput();
        }
    }
}
```

---

## Helper Functions Summary

The SO Framework provides **52 global helper functions** organized into these categories:

| Category | Count | Key Functions |
|----------|-------|---------------|
| Configuration & Environment | 3 | `app()`, `env()`, `config()` |
| Path Helpers | 4 | `base_path()`, `storage_path()`, `public_path()`, `config_path()` |
| HTTP & Routing | 13 | `route()`, `redirect()`, `request()`, `response()`, `route_is()` |
| Authentication & Security | 6 | `auth()`, `jwt()`, `csrf_token()`, `e()`, `sanitize()` |
| Session & Cache | 3 | `session()`, `cache()`, `old()` |
| Database & Models | 1 | `validate()` |
| View & Output | 7 | `view()`, `asset()`, `assets()`, `push_stack()`, `render_assets()` |
| String Helpers | 4 | `str_contains()`, `str_starts_with()`, `str_ends_with()`, `class_basename()` |
| Array & Collection | 5 | `collect()`, `blank()`, `filled()`, `value()`, `with()` |
| Logging & Debugging | 4 | `logger()`, `dd()`, `now()`, `abort()` |
| Queue & Events | 4 | `queue()`, `dispatch()`, `event()`, `activity()` |

**Total: 54 helper functions**

---

## See Also

- **[API Controllers](DEV-API-CONTROLLERS.md)** - Using helpers in API controllers
- **[Web Controllers](DEV-WEB-CONTROLLERS.md)** - Using helpers in web controllers
- **[View Templates](VIEW-TEMPLATES.md)** - Using helpers in templates
- **[Asset Management](ASSET-MANAGEMENT.md)** - Asset helper functions
- **[Caching System](DEV-CACHING.md)** - Cache helper deep dive
- **[Validation System](VALIDATION-SYSTEM.md)** - Validation helper usage
- **[Routing System](ROUTING-SYSTEM.md)** - Routing helper functions
- **[Authentication System](AUTH-SYSTEM.md)** - Auth helper functions

---

**Last Updated**: 2026-02-01
**Framework Version**: 1.0
