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

**Related Documentation:**
- [API Controllers](/docs/dev/api-controllers) - Using helpers in APIs
- [Web Controllers](/docs/dev/web-controllers) - Using helpers in web controllers
- [Views](/docs/view-templates) - Using helpers in templates
- [Caching](/docs/dev/caching) - Cache helper usage

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
