# Authentication & Authorization -- Developer Guide

**SO Framework** | **Step-by-Step Auth Guide**

A practical, step-by-step guide to protecting routes, logging users in and out, and
working with tokens in the SO Backend Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Protecting Routes with AuthMiddleware](#protecting-routes-with-authmiddleware)
3. [Session-Based Auth](#session-based-auth)
4. [Accessing the Authenticated User](#accessing-the-authenticated-user)
5. [Remember Me](#remember-me)
6. [JWT Authentication](#jwt-authentication)
7. [Guest Middleware](#guest-middleware)
8. [Complete Example](#complete-example)

---

## Overview

The framework provides a layered authentication system built on three mechanisms.
`AuthMiddleware` evaluates each one in order until the user is verified or all
checks fail:

| Order | Mechanism | Use Case |
|-------|-----------|----------|
| 1 | **Session** | Traditional web pages -- user logs in through a form, a session cookie keeps them authenticated. |
| 2 | **Remember Token** | "Remember Me" checkbox -- a long-lived HTTP-only cookie that automatically restores the session on return visits. |
| 3 | **JWT Bearer Token** | API consumers -- a stateless JSON Web Token sent in the `Authorization` header. |

Key classes and helpers:

| Symbol | Resolves To | Purpose |
|--------|-------------|---------|
| `auth()` | `Core\Auth\Auth` | Global helper -- check status, attempt login, get user. |
| `jwt()` | `Core\Security\JWT` | Global helper -- encode and decode JWT tokens. |
| `AuthMiddleware` | `App\Middleware\AuthMiddleware` | Route middleware -- blocks unauthenticated requests. |
| `GuestMiddleware` | `App\Middleware\GuestMiddleware` | Route middleware -- blocks already-authenticated users. |

---

## Protecting Routes with AuthMiddleware

`AuthMiddleware` implements `Core\Middleware\MiddlewareInterface`. When the
middleware runs it performs three checks in sequence:

1. `auth()->check()` -- is there an active session?
2. `auth()->loginViaRememberToken()` -- is there a valid remember cookie?
3. `$request->bearerToken()` + `jwt()->decode($token)` -- is there a valid JWT?

If any check succeeds the middleware attaches the user to the request and lets it
through. If all checks fail the middleware returns an appropriate error:

- **API / JSON requests** -- `401 Unauthenticated` JSON response.
- **Web requests** -- redirect to the login URL (defaults to `/login`), with the
  intended URI stored in the session flash data.

### Protecting a Single Route

```php
use Core\Routing\Router;
use App\Controllers\DashboardController;

Router::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth']);
```

### Protecting a Group of Routes

```php
use Core\Routing\Router;
use App\Controllers\DashboardController;
use App\Controllers\ProfileController;
use App\Controllers\AuthController;

Router::group(['middleware' => 'auth'], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
    Router::get('/profile',   [ProfileController::class, 'show']);
    Router::put('/profile',   [ProfileController::class, 'update']);
    Router::post('/logout',   [AuthController::class, 'logout']);
});
```

### Combining with a Prefix

```php
Router::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
    Router::get('/users',     [AdminController::class, 'users']);
});
// Results in: /admin/dashboard, /admin/users -- all protected.
```

---

## Session-Based Auth

Session-based authentication is the default for web routes. The `auth()` helper
returns a `Core\Auth\Auth` instance that wraps the session and the `User` model.

### Logging In -- `auth()->attempt()`

`attempt()` accepts an array with `email` and `password` keys and an optional
`$remember` boolean. It looks up the user by email, verifies the password hash,
and -- on success -- stores the user ID in the session.

```php
// app/Controllers/AuthController.php

namespace App\Controllers;

use Core\Http\Request;

class AuthController
{
    public function login(Request $request)
    {
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = (bool) $request->input('remember', false);

        if (auth()->attempt($credentials, $remember)) {
            // Success -- session is now active.
            return redirect('/dashboard');
        }

        // Failure -- redirect back with an error message.
        return back()->with('error', 'Invalid email or password.');
    }
}
```

Under the hood `attempt()` calls `auth()->login($user)`, which:

1. Regenerates the session ID (prevents session fixation).
2. Regenerates the CSRF token.
3. Stores the user ID under the `auth_user_id` session key.
4. If `$remember` is `true`, generates a remember-me cookie (see below).

### Logging Out -- `auth()->logout()`

```php
public function logout()
{
    auth()->logout();

    return redirect('/login');
}
```

`logout()` performs the following steps:

1. Clears the `remember_token` column on the user record.
2. Removes the `auth_user_id` session key.
3. Regenerates the session ID.
4. Deletes the remember-me cookie.

### Checking Auth State -- `auth()->check()` / `auth()->guest()`

```php
if (auth()->check()) {
    // User is logged in.
}

if (auth()->guest()) {
    // User is NOT logged in.
}
```

Both methods are lightweight -- they only inspect the session (no database query).

---

## Accessing the Authenticated User

Once `AuthMiddleware` has run, the authenticated user is available through
multiple access points.

### Via the Request Object

The middleware calls `$request->set('user', auth()->user())` and assigns
`$request->user_id`, so inside any controller behind the `auth` middleware you
can use:

```php
public function dashboard(Request $request)
{
    // Full user model (User instance or null)
    $user = $request->user();

    // User ID (int or null)
    $userId = $request->user_id;

    return view('dashboard', ['user' => $user]);
}
```

### Via the `auth()` Helper

You can call the helper from anywhere -- controllers, services, views:

```php
// Get the User model
$user = auth()->user();          // App\Models\User | null

// Get just the ID (no DB query)
$userId = auth()->id();          // int | null

// Quick guard clause
if (!auth()->check()) {
    return redirect('/login');
}
```

### Summary Table

| Method | Returns | DB Query? |
|--------|---------|-----------|
| `$request->user()` | `User` or `null` | No (already loaded by middleware) |
| `$request->user_id` | `int` or `null` | No |
| `auth()->user()` | `User` or `null` | Yes (`User::find()`) |
| `auth()->id()` | `int` or `null` | No (reads session) |
| `auth()->check()` | `bool` | No (reads session) |

---

## Remember Me

When `auth()->attempt($credentials, true)` is called with the second argument
set to `true`, the framework creates a persistent "remember me" cookie so the
user stays logged in across browser sessions.

### How It Works

1. A 64-character random token is generated (`bin2hex(random_bytes(32))`).
2. The **SHA-256 hash** of the token is stored in the `remember_token` column of
   the `users` table.
3. The **raw** token is sent to the browser as an HTTP-only cookie named
   `remember_token` with a 30-day expiry.
4. On the next visit, `AuthMiddleware` calls `auth()->loginViaRememberToken()`.
   The method reads the cookie, hashes it, and looks up the user by the hashed
   value. If found, the user is logged in and the token is rotated.

### Login Form with Remember Me

```php
<!-- resources/views/auth/login.php -->

<form method="POST" action="/login">
    <?= csrf_field() ?>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>
        <input type="checkbox" name="remember" value="1">
        Remember me
    </label>

    <button type="submit">Log In</button>
</form>
```

### Controller Handling

```php
public function login(Request $request)
{
    $credentials = [
        'email'    => $request->input('email'),
        'password' => $request->input('password'),
    ];

    // Pass true as the second argument when the checkbox is checked.
    $remember = (bool) $request->input('remember', false);

    if (auth()->attempt($credentials, $remember)) {
        return redirect('/dashboard');
    }

    return back()->with('error', 'Invalid credentials.');
}
```

### Security Notes

- The cookie is **HTTP-only** -- JavaScript cannot read it.
- The stored token is a **SHA-256 hash** -- a database leak does not expose raw
  tokens.
- Each successful remember-me login **rotates the token**, so a stolen token can
  only be used once.
- Set `COOKIE_SECURE=true` in `.env` when running over HTTPS to ensure the
  cookie is never sent in plain text.

---

## JWT Authentication

For API consumers the framework supports stateless JWT authentication via the
`Authorization: Bearer <token>` header.

### Issuing a Token

Use the `jwt()` helper (resolves to `Core\Security\JWT::fromConfig()`) to encode
a payload. The token is signed with the `JWT_SECRET` from your `.env` file using
HMAC-SHA256.

```php
// app/Controllers/Api/AuthController.php

namespace App\Controllers\Api;

use Core\Http\Request;
use Core\Http\JsonResponse;

class AuthController
{
    public function login(Request $request): JsonResponse
    {
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (!auth()->attempt($credentials)) {
            return JsonResponse::error('Invalid credentials', 401);
        }

        $user = auth()->user();

        // Encode a payload with a 1-hour TTL.
        $token = jwt()->encode([
            'user_id' => $user->id,
            'email'   => $user->email,
        ], 3600);

        return JsonResponse::success([
            'token'      => $token,
            'expires_in' => 3600,
        ]);
    }
}
```

### How the Middleware Validates a JWT

When session auth and the remember token both fail, `AuthMiddleware` falls back
to JWT validation. The sequence is:

1. Read the `Authorization` header via `$request->bearerToken()`.
2. If present, call `jwt()->decode($token)`.
3. `decode()` verifies the HMAC-SHA256 signature and checks the `exp` claim.
4. On success, the decoded payload is attached as `$request->jwt` and the
   `user_id` claim (if present) is copied to `$request->user_id`.
5. On failure (invalid signature, expired token, malformed), the exception is
   caught and the request is treated as unauthenticated.

### Consuming a Protected API Endpoint

```bash
# Step 1 -- Obtain a token.
curl -X POST https://example.com/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"s3cret"}'

# Step 2 -- Send the token on subsequent requests.
curl https://example.com/api/dashboard \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
```

### Accessing the JWT Payload in a Controller

```php
public function dashboard(Request $request): JsonResponse
{
    // The full decoded payload array.
    $payload = $request->jwt;

    // The user_id extracted by the middleware.
    $userId = $request->user_id;

    return JsonResponse::success([
        'user_id' => $userId,
        'claims'  => $payload,
    ]);
}
```

### Configuration

Set these values in your `.env` file:

```ini
JWT_SECRET=your-long-random-secret-key
JWT_ALGORITHM=HS256
JWT_EXPIRATION=3600
```

---

## Guest Middleware

`GuestMiddleware` is the inverse of `AuthMiddleware`. It redirects
**authenticated** users away from pages they should not see once logged in, such
as the login and registration forms.

### How It Works

```php
// app/Middleware/GuestMiddleware.php

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (auth()->check()) {
            return redirect(url('/dashboard'));
        }

        return $next($request);
    }
}
```

If `auth()->check()` returns `true` the user is redirected to `/dashboard`.
Otherwise the request proceeds normally.

### Applying Guest Middleware to Routes

```php
// routes/web.php

Router::group(['middleware' => 'guest'], function () {
    Router::get('/login',    [AuthController::class, 'showLogin']);
    Router::post('/login',   [AuthController::class, 'login']);
    Router::get('/register', [AuthController::class, 'showRegister']);
    Router::post('/register',[AuthController::class, 'register']);
});
```

With this configuration, a user who is already logged in and navigates to
`/login` will be automatically redirected to `/dashboard`.

---

## Complete Example

Below is a full working example that ties everything together: public pages,
guest-only pages, a login/logout flow, and a protected dashboard.

### Route Definitions

```php
// routes/web.php

use Core\Routing\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;

// --- Public routes (no middleware) ---
Router::get('/', [HomeController::class, 'index'])->name('home');

// --- Guest-only routes ---
Router::group(['middleware' => 'guest'], function () {
    Router::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Router::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// --- Protected routes ---
Router::group(['middleware' => 'auth'], function () {
    Router::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Router::post('/logout',   [AuthController::class, 'logout'])->name('logout');
});
```

### Auth Controller

```php
// app/Controllers/AuthController.php

namespace App\Controllers;

use Core\Http\Request;

class AuthController
{
    /**
     * Show the login form (GET /login).
     */
    public function showLogin()
    {
        return view('auth/login');
    }

    /**
     * Handle a login attempt (POST /login).
     */
    public function login(Request $request)
    {
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = (bool) $request->input('remember', false);

        if (auth()->attempt($credentials, $remember)) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    /**
     * Log the user out (POST /logout).
     */
    public function logout()
    {
        auth()->logout();

        return redirect('/login');
    }
}
```

### Dashboard Controller

```php
// app/Controllers/DashboardController.php

namespace App\Controllers;

use Core\Http\Request;

class DashboardController
{
    public function index(Request $request)
    {
        // The user is guaranteed to be authenticated at this point
        // because AuthMiddleware has already run.

        $user = $request->user();      // User model loaded by middleware
        $userId = auth()->id();        // Same user, read from session

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
```

### Login View

```php
<!-- resources/views/auth/login.php -->

<h1>Log In</h1>

<?php if (session()->has('error')): ?>
    <div class="alert alert-error">
        <?= e(session()->get('error')) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/login">
    <?= csrf_field() ?>

    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="remember" value="1">
            Remember me
        </label>
    </div>

    <button type="submit">Log In</button>
</form>
```

### Dashboard View

```php
<!-- resources/views/dashboard.php -->

<h1>Dashboard</h1>
<p>Welcome, <?= e($user->name) ?>!</p>

<form method="POST" action="/logout">
    <?= csrf_field() ?>
    <button type="submit">Log Out</button>
</form>
```

### Request Flow Summary

```
GET /dashboard (no session)
  -> AuthMiddleware
       1. auth()->check()              => false
       2. auth()->loginViaRememberToken() => false (no cookie)
       3. $request->bearerToken()      => null
       -> All checks failed
       -> Web request => redirect to /login
            (flash: intended = /dashboard)

POST /login (email + password + remember)
  -> GuestMiddleware
       auth()->check() => false => allow through
  -> AuthController::login()
       auth()->attempt($creds, true)
         -> finds user, verifies password => true
         -> session regenerated, user ID stored
         -> remember cookie set (30-day, HTTP-only)
       -> redirect to /dashboard

GET /dashboard (with session)
  -> AuthMiddleware
       1. auth()->check() => true
       -> $request->set('user', auth()->user())
       -> $request->user_id = user ID
       -> allow through
  -> DashboardController::index()
       $request->user() => User model

POST /logout
  -> AuthMiddleware => passes (session active)
  -> AuthController::logout()
       auth()->logout()
         -> clears remember_token in DB
         -> removes session key
         -> regenerates session
         -> deletes remember cookie
       -> redirect to /login
```
