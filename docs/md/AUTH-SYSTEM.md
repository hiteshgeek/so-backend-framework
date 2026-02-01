# Authentication System Guide

**SO Framework** | **Session-Based Auth** | **Version {{APP_VERSION}}**

Complete guide to user authentication and authorization in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Quick Start](#quick-start)
4. [Authentication Methods](#authentication-methods)
5. [Session-Based Auth](#session-based-auth)
6. [JWT Authentication](#jwt-authentication)
7. [Remember Me Functionality](#remember-me-functionality)
8. [Authentication Middleware](#authentication-middleware)
9. [Password Management](#password-management)
10. [Authorization & Permissions](#authorization--permissions)
11. [Multi-Factor Authentication](#multi-factor-authentication)
12. [API Authentication](#api-authentication)
13. [Security Best Practices](#security-best-practices)
14. [Troubleshooting](#troubleshooting)

---

## Overview

The SO Framework provides a comprehensive authentication system with multiple authentication methods:

- **Session-Based Authentication** - Traditional web authentication with sessions
- **JWT Authentication** - Stateless token-based auth for APIs
- **Remember Me** - Persistent authentication via secure cookies
- **API Key Authentication** - For service-to-service communication

### Features

- Session-based authentication for web applications
- Stateless JWT tokens for API authentication
- Remember me functionality (30-day persistence)
- Password hashing with Argon2ID
- CSRF protection integration
- Rate limiting support
- Multi-factor authentication ready
- Context-aware permissions

---

## Architecture

### Authentication Flow

```
+-------------+
|   Request   |
+------+------+
       |
       v
+------------------+
|  Auth Middleware |<--- Check session/token
+------+-----------+
       |
       v
   Authenticated?
       |
   Yes | No
       |  +--> Redirect to login / 401
       v
+--------------+
|  Controller  |
+--------------+
```

### Auth Components

| Component | Purpose | File |
|-----------|---------|------|
| **Auth Service** | Core authentication logic | `core/Auth/Auth.php` |
| **JWT Service** | Token generation/validation | `core/Security/JWT.php` |
| **Session** | Session management | `core/Http/Session.php` |
| **AuthMiddleware** | Route protection | `app/Middleware/AuthMiddleware.php` |
| **User Model** | User data access | `app/Models/User.php` |

---

## Working with the AUSER Table

The SO Framework User model is designed to work with an existing `auser` table from a legacy system. This is important to understand when working with user authentication and data.

### Table Structure

- **Table name:** `auser` (not the typical `users`)
- **Primary key:** `uid` (not the standard `id`)
- **Timestamps:** `created_ts`, `updated_ts` (not `created_at`, `updated_at`)
- **Connection:** `db` (application database, not essentials)
- **Status field:** `ustatusid` (uses HasStatusField trait)

### User Model Configuration

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;
use Core\Notifications\Notifiable;
use Core\Model\Traits\HasStatusField;

class User extends Model
{
    use LogsActivity, Notifiable, HasStatusField;

    // Legacy table configuration
    protected static string $table = 'auser';
    protected static string $primaryKey = 'uid';
    protected static string $connection = 'db';

    // Status field configuration in constructor
    public function __construct(array $attributes = [])
    {
        $this->statusField = 'ustatusid';
        $this->activeStatusValues = [1];
        $this->inactiveStatusValues = [2, 3];

        parent::__construct($attributes);
    }

    protected array $fillable = [
        'uid', 'name', 'email', 'password', 'empid',
        'designation', 'report_to', 'ustatusid',
        'email_signature', 'mail_box_full_name',
        // ... other fields
    ];

    // Custom timestamp column names
    protected static array $timestamps = ['created_ts', 'updated_ts'];
}
```

### Key Differences from Standard Setup

**Finding Users:**
```php
// Use uid instead of id
$user = User::find($uid);  // NOT User::find($id)

// Get authenticated user's uid
$userId = auth()->user()->uid;  // NOT auth()->user()->id
```

**Timestamps:**
```php
// Access timestamps with custom names
$createdAt = $user->created_ts;  // NOT $user->created_at
$updatedAt = $user->updated_ts;  // NOT $user->updated_at
```

**Status Checking:**
```php
// Uses HasStatusField trait
if ($user->isActive()) {
    // User status is active (ustatusid = 1)
}

// Query active users
$activeUsers = User::active()->get();
```

### Why This Matters

When following authentication examples in this guide, remember:
- Examples may show generic `users` table - adapt to `auser`
- Examples may show `id` primary key - adapt to `uid`
- Examples may show standard timestamps - adapt to `created_ts`/`updated_ts`

**See Also:**
- [DEV-MODELS.md](/docs/dev-models) - Model basics
- [STATUS-FIELD-TRAIT.md](/docs/status-field-trait) - Status field handling

---

## Quick Start

### 1. Basic Login Example

```php
// app/Controllers/AuthController.php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Http\RedirectResponse;

class AuthController
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = $request->input('remember', false);

        if (auth()->attempt($credentials, $remember)) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
```

### 2. Login Form

```php
<!-- resources/views/auth/login.php -->

<form method="POST" action="/login">
    <?= csrf_field() ?>

    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="remember" value="1">
            Remember Me
        </label>
    </div>

    <button type="submit">Login</button>
</form>

<?php if (session()->has('error')): ?>
    <div class="error">
        <?= e(session()->get('error')) ?>
    </div>
<?php endif; ?>
```

### 3. Protect Routes

```php
// routes/web.php

use Core\Routing\Router;

// Public routes
Router::get('/login', [AuthController::class, 'showLogin']);
Router::post('/login', [AuthController::class, 'login']);

// Protected routes
Router::group(['middleware' => 'auth'], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::post('/logout', [AuthController::class, 'logout']);
});
```

---

## Authentication Methods

### Available Methods

```php
// Check if user is authenticated
auth()->check();  // Returns bool

// Check if user is a guest (not authenticated)
auth()->guest();  // Returns bool

// Get authenticated user
$user = auth()->user();  // Returns User|null

// Get authenticated user ID
$userId = auth()->id();  // Returns int|null

// Attempt authentication
auth()->attempt([
    'email' => 'user@example.com',
    'password' => 'password123'
], $remember = false);

// Manual login
auth()->login($user, $remember = false);

// Logout
auth()->logout();
```

---

## Session-Based Auth

### How It Works

1. User submits credentials via login form
2. Server validates credentials
3. On success, user ID stored in session
4. Session cookie sent to browser
5. Subsequent requests include session cookie
6. Middleware checks session for authentication

### Configuration

```ini
# .env

SESSION_DRIVER=database
SESSION_LIFETIME=120  # minutes
SESSION_COOKIE=so_session
SESSION_SECURE=false  # Set to true in production with HTTPS
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### Complete Login Flow

```php
// app/Controllers/Auth/LoginController.php

namespace App\Controllers\Auth;

use Core\Http\Request;
use Core\Http\RedirectResponse;
use App\Services\AuditLogger;

class LoginController
{
    public function showLoginForm()
    {
        // If already authenticated, redirect to dashboard
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return view('auth/login');
    }

    public function login(Request $request): RedirectResponse
    {
        // Validate input
        $validated = validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Rate limiting (prevent brute force)
        $limiter = app('rate.limiter');
        $key = 'login:' . $request->ip();

        if ($limiter->tooManyAttempts($key, 5, 60)) {
            return back()->with('error', 'Too many login attempts. Please try again in 1 minute.');
        }

        // Attempt authentication
        $remember = $request->input('remember', false);

        if (auth()->attempt($validated, $remember)) {
            // Regenerate session (prevent session fixation)
            session()->regenerate();

            // Log successful login
            activity()
                ->causedBy(auth()->user())
                ->log('User logged in')
                ->save();

            // Redirect to intended page or dashboard
            return redirect()->intended('/dashboard');
        }

        // Increment failed attempts
        $limiter->hit($key, 60);

        // Log failed attempt
        activity()
            ->withProperties(['email' => $validated['email'], 'ip' => $request->ip()])
            ->log('Failed login attempt')
            ->save();

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(): RedirectResponse
    {
        // Log logout
        if (auth()->check()) {
            activity()
                ->causedBy(auth()->user())
                ->log('User logged out')
                ->save();
        }

        auth()->logout();

        return redirect('/login');
    }
}
```

---

## JWT Authentication

### Overview

JWT (JSON Web Token) authentication is stateless and ideal for APIs. Tokens are signed and verified using a secret key.

### Configuration

```ini
# .env

JWT_SECRET=your-secret-key-here  # Change in production!
JWT_ALGORITHM=HS256
JWT_EXPIRATION=3600  # 1 hour in seconds
```

### Generating Tokens

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
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (!auth()->attempt($credentials)) {
            return JsonResponse::error('Invalid credentials', 401);
        }

        $user = auth()->user();

        // Generate JWT token
        $token = jwt()->encode([
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ], 3600); // 1 hour expiration

        return JsonResponse::success([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'expires_in' => 3600,
        ]);
    }
}
```

### Validating Tokens

```php
// app/Middleware/JwtAuthMiddleware.php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Middleware\MiddlewareInterface;

class JwtAuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return JsonResponse::error('Authentication required', 401);
        }

        try {
            $payload = jwt()->decode($token);

            // Attach user to request
            $request->attributes['user'] = $payload;
            $request->attributes['user_id'] = $payload['user_id'];

        } catch (\Exception $e) {
            return JsonResponse::error('Invalid or expired token', 401);
        }

        return $next($request);
    }
}
```

### API Usage

```bash
# Login to get token
curl -X POST http://localhost/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'

# Response:
# {
#   "success": true,
#   "data": {
#     "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
#     "user": {...},
#     "expires_in": 3600
#   }
# }

# Use token for authenticated requests
curl http://localhost/api/v1/users \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

---

## Remember Me Functionality

### How It Works

1. User checks "Remember Me" on login
2. Server generates secure 64-character token
3. Token stored in database (users.remember_token)
4. Token set as HTTP-only cookie (30-day expiration)
5. On future visits, token validated and user logged in

### Implementation

**Already implemented in Auth service:**

```php
// Automatic usage
auth()->attempt($credentials, $remember = true);
```

**Manual validation on each request:**

```php
// In bootstrap or middleware
if (auth()->guest()) {
    auth()->loginViaRememberToken();
}
```

### Security Considerations

1. **Token Regeneration**: New token generated on each login
2. **HTTP-Only**: Cookie not accessible via JavaScript
3. **Secure Flag**: Enable in production with HTTPS
4. **One Token Per User**: Old tokens invalidated on new login
5. **Token Rotation**: Consider rotating tokens periodically

---

## Authentication Middleware

### Creating Auth Middleware

```php
// app/Middleware/AuthMiddleware.php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\RedirectResponse;
use Core\Middleware\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Try remember me authentication
        if (auth()->guest()) {
            auth()->loginViaRememberToken();
        }

        // Check if user is authenticated
        if (auth()->guest()) {
            // Store intended URL
            session()->put('url.intended', $request->fullUrl());

            // Redirect to login
            return new RedirectResponse('/login');
        }

        return $next($request);
    }
}
```

### Guest Middleware (Redirect Authenticated Users)

```php
// app/Middleware/GuestMiddleware.php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\RedirectResponse;
use Core\Middleware\MiddlewareInterface;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (auth()->check()) {
            return new RedirectResponse('/dashboard');
        }

        return $next($request);
    }
}
```

### Using Middleware

```php
// routes/web.php

// Guest routes (login, register)
Router::group(['middleware' => 'guest'], function () {
    Router::get('/login', [AuthController::class, 'showLogin']);
    Router::post('/login', [AuthController::class, 'login']);
    Router::get('/register', [AuthController::class, 'showRegister']);
});

// Authenticated routes
Router::group(['middleware' => 'auth'], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
    Router::post('/logout', [AuthController::class, 'logout']);
});
```

---

## Password Management

### Password Hashing

**Automatic hashing in User model:**

```php
// app/Models/User.php

class User extends Model
{
    protected array $fillable = ['name', 'email', 'password'];

    // Automatically hash passwords
    protected function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
```

### Password Reset Flow

**1. Request Password Reset**

```php
// app/Controllers/Auth/ForgotPasswordController.php

public function sendResetLink(Request $request): JsonResponse
{
    $email = $request->input('email');

    $user = User::where('email', '=', $email)->first();

    if (!$user) {
        // Don't reveal if email exists
        return JsonResponse::success(['message' => 'If that email exists, a reset link has been sent.']);
    }

    // Generate secure token
    $token = bin2hex(random_bytes(32));

    // Store token in database (create password_resets table)
    DB::table('password_resets')->insert([
        'email' => $email,
        'token' => hash('sha256', $token),
        'created_at' => date('Y-m-d H:i:s'),
    ]);

    // Send email with reset link
    $resetUrl = config('app.url') . "/reset-password?token={$token}&email={$email}";

    // TODO: Send email (requires mail system)
    // mail()->to($user)->send(new PasswordResetEmail($resetUrl));

    return JsonResponse::success(['message' => 'Password reset link sent.']);
}
```

**2. Reset Password**

```php
public function resetPassword(Request $request): JsonResponse
{
    $validated = validate($request->all(), [
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    // Verify token
    $reset = DB::table('password_resets')
        ->where('email', '=', $validated['email'])
        ->where('token', '=', hash('sha256', $validated['token']))
        ->first();

    if (!$reset) {
        return JsonResponse::error('Invalid or expired reset token', 400);
    }

    // Check if token is expired (1 hour)
    $createdAt = strtotime($reset['created_at']);
    if (time() - $createdAt > 3600) {
        return JsonResponse::error('Reset token has expired', 400);
    }

    // Update password
    $user = User::where('email', '=', $validated['email'])->first();
    $user->password = $validated['password'];
    $user->save();

    // Delete reset token
    DB::table('password_resets')
        ->where('email', '=', $validated['email'])
        ->delete();

    // Log password reset
    activity()
        ->causedBy($user)
        ->log('Password reset')
        ->save();

    return JsonResponse::success(['message' => 'Password has been reset.']);
}
```

---

## Authorization & Permissions

### Role-Based Access Control (RBAC)

**User Model with Roles:**

```php
// app/Models/User.php

class User extends Model
{
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
```

**Role Middleware:**

```php
// app/Middleware/RoleMiddleware.php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Middleware\MiddlewareInterface;

class RoleMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next, string $role = null): Response
    {
        if (!auth()->check()) {
            return JsonResponse::error('Authentication required', 401);
        }

        $user = auth()->user();

        if ($role && !$user->hasRole($role)) {
            return JsonResponse::error('Insufficient permissions', 403);
        }

        return $next($request);
    }
}
```

**Usage:**

```php
// routes/web.php

Router::group(['middleware' => ['auth', 'role:admin']], function () {
    Router::get('/admin/users', [AdminController::class, 'users']);
    Router::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
});
```

---

## API Authentication

### Context-Aware Authentication

The framework supports multiple authentication contexts:

```php
use Core\Api\RequestContext;

$context = RequestContext::detect($request);

if ($context->isWeb()) {
    // Use session authentication
    $authenticated = auth()->check();
}

if ($context->isMobile()) {
    // Use JWT authentication
    $payload = jwt()->decode($request->bearerToken());
}

if ($context->isCron()) {
    // Use signature authentication
    $valid = app('internal.api.guard')->validate($request);
}

if ($context->isExternal()) {
    // Use API key + JWT
    $apiKey = $request->header('X-API-Key');
    $token = $request->bearerToken();
}
```

**See**: [Internal API Layer Documentation](/docs/internal-api)

---

## Security Best Practices

### 1. Always Use HTTPS in Production

```ini
# .env (production)
SESSION_SECURE=true
COOKIE_SECURE=true
```

### 2. Implement Rate Limiting

```php
// Prevent brute force attacks
$limiter->hit('login:' . $request->ip(), 60);  // 60 second window
if ($limiter->tooManyAttempts('login:' . $request->ip(), 5, 60)) {
    // Block for 60 seconds after 5 attempts
}
```

### 3. Use CSRF Protection

```php
// All POST/PUT/DELETE routes automatically protected
<?= csrf_field() ?>
```

### 4. Log Security Events

```php
activity()
    ->log('Failed login attempt')
    ->withProperties(['ip' => $request->ip(), 'email' => $email])
    ->save();
```

### 5. Session Security

```php
// Regenerate session on login
session()->regenerate();

// Regenerate session periodically
if (time() - session()->get('last_regeneration', 0) > 300) {
    session()->regenerate();
    session()->put('last_regeneration', time());
}
```

### 6. Password Requirements

```php
$validated = validate($request->all(), [
    'password' => 'required|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/',
]);
```

---

## Troubleshooting

### Session Not Persisting

**Problem**: User logged in but session lost on redirect

**Solutions**:
1. Check session driver is configured: `SESSION_DRIVER=database`
2. Ensure sessions table exists
3. Verify session cookie is being set
4. Check browser console for cookie errors

### Remember Me Not Working

**Problem**: Remember me checkbox has no effect

**Solutions**:
1. Ensure `remember_token` column exists in users table
2. Check cookie is being set (browser dev tools)
3. Verify `loginViaRememberToken()` is called on subsequent visits
4. Check cookie `secure` flag matches HTTPS status

### JWT Token Expired

**Problem**: Token expires too quickly

**Solutions**:
1. Increase `JWT_EXPIRATION` in .env
2. Implement token refresh mechanism
3. Use short-lived access tokens + long-lived refresh tokens

### Password Hashing Slow

**Problem**: Login takes several seconds

**Solutions**:
1. Argon2ID is intentionally slow for security
2. Adjust cost parameters if needed (not recommended)
3. Use hardware acceleration if available
4. Consider queue-based login for high traffic

---

## Complete Examples

### Registration Flow

```php
// app/Controllers/Auth/RegisterController.php

public function register(Request $request): RedirectResponse
{
    $validated = validate($request->all(), [
        'name' => 'required|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],  // Auto-hashed by mutator
        'role' => 'user',
    ]);

    // Log registration
    activity()
        ->causedBy($user)
        ->log('User registered')
        ->save();

    // Send welcome email (optional)
    // mail()->to($user)->send(new WelcomeEmail());

    // Auto-login
    auth()->login($user);

    return redirect('/dashboard')->with('success', 'Welcome to ' . config('app.name') . '!');
}
```

---

## Summary

The SO Framework authentication system provides:

- Session-based authentication for web applications
- JWT tokens for API authentication
- Remember me functionality with secure cookies
- Password hashing with Argon2ID
- Rate limiting to prevent brute force
- CSRF protection integration
- Context-aware authentication
- Activity logging for audit trails

All authentication methods follow security best practices and are production-ready.

---

**Related Documentation:**
- [Security Layer](/docs/security-layer) - CSRF, JWT, Rate Limiting
- [Internal API Layer](/docs/internal-api) - API Authentication
- [Middleware System](/docs/middleware) - Auth Middleware

---

**Last Updated**: 2026-01-29
**Framework Version**: {{APP_VERSION}}
