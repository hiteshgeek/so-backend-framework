# API Authentication with JWT - Developer Guide

**SO Framework** | **JWT Token Authentication** | **Version 1.0**

A practical guide to implementing stateless API authentication using JSON Web Tokens (JWT).

---

## Table of Contents

1. [Overview](#overview)
2. [JWT Configuration](#jwt-configuration)
3. [Token Generation](#token-generation)
4. [Token Verification](#token-verification)
5. [Authentication Middleware](#authentication-middleware)
6. [Token Refresh](#token-refresh)
7. [Logout & Token Revocation](#logout--token-revocation)
8. [Complete API Example](#complete-api-example)
9. [Best Practices](#best-practices)

---

## Overview

JWT (JSON Web Token) provides stateless authentication for APIs. Tokens are signed and verified using a secret key, eliminating the need for server-side session storage.

### Key Features

- Stateless authentication (no server-side sessions)
- HS256 algorithm signing
- Token expiration (TTL)
- Individual token revocation
- User-level token invalidation
- Automatic JTI (JWT ID) generation
- Blacklist support via cache

### How It Works

1. User logs in with credentials
2. Server generates JWT token with user data
3. Client stores token (localStorage, cookie)
4. Client sends token in `Authorization` header
5. Server verifies token signature and expiration
6. Server extracts user data from token payload

---

## JWT Configuration

### Environment Variables

Set these in your `.env` file:

```env
# JWT Secret (minimum 32 characters)
JWT_SECRET=your-very-long-secret-key-minimum-32-characters-for-security

# Token TTL (in seconds)
JWT_TTL=3600

# Algorithm (default: HS256)
JWT_ALGORITHM=HS256
```

### Configuration File

**config/security.php:**

```php
return [
    'jwt' => [
        'secret' => env('JWT_SECRET'),
        'ttl' => env('JWT_TTL', 3600), // 1 hour default
        'algorithm' => env('JWT_ALGORITHM', 'HS256'),
        'blacklist_enabled' => true,
        'blacklist_grace_period' => 10, // seconds
    ],
];
```

### Generate JWT Secret

```bash
# Generate a secure JWT secret
./sixorbit jwt:secret

# This will output a secure random key
# Add it to your .env file
```

---

## Token Generation

### Basic Token Creation

```php
use Core\Security\JWT;

// Create JWT instance
$jwt = new JWT();

// Or use helper
$jwt = jwt();

// Generate token with user data
$payload = [
    'user_id' => 123,
    'email' => 'user@example.com',
    'role' => 'admin',
];

$token = $jwt->encode($payload, 3600); // 1 hour TTL
```

### Standard Claims

JWT automatically adds standard claims:

```php
$token = $jwt->encode(['user_id' => 123], 3600);

// Decoded payload includes:
// {
//   "user_id": 123,
//   "iat": 1706742000,  // Issued At (timestamp)
//   "exp": 1706745600,  // Expiration (timestamp)
//   "jti": "a1b2c3..."  // JWT ID (unique token identifier)
// }
```

### Using Standard "sub" Claim

For better compatibility with JWT standards:

```php
$payload = [
    'sub' => 123,              // Subject (user ID)
    'email' => 'user@example.com',
    'name' => 'John Doe',
    'role' => 'admin',
];

$token = $jwt->encode($payload, 3600);
```

### Token Without Expiration

```php
// Token never expires (use with caution!)
$token = $jwt->encode(['user_id' => 123], null);
```

---

## Token Verification

### Decode and Verify Token

```php
try {
    $jwt = jwt();
    $payload = $jwt->decode($token);

    // Access user data
    $userId = $payload['user_id'];
    $email = $payload['email'];

    echo "User authenticated: $email";

} catch (\Exception $e) {
    // Token invalid, expired, or revoked
    echo "Authentication failed: " . $e->getMessage();
}
```

### Verification Checks

The `decode()` method automatically verifies:

1. **Token Format** - Must have 3 parts (header.payload.signature)
2. **Signature** - Verifies token hasn't been tampered with
3. **Algorithm** - Must match configured algorithm (HS256)
4. **Expiration** - Checks if token is expired
5. **Blacklist** - Checks if token has been revoked
6. **User Invalidation** - Checks if all user tokens have been revoked

### Common Exception Messages

```php
try {
    $payload = $jwt->decode($token);
} catch (\Exception $e) {
    // "Invalid token format" - Malformed token
    // "Invalid signature" - Token tampered with
    // "Invalid algorithm" - Algorithm mismatch
    // "Token expired" - Past expiration time
    // "Token has been revoked" - Individual token blacklisted
    // "Token has been revoked (user invalidated)" - All user tokens revoked
}
```

---

## Authentication Middleware

### JWT Middleware

Protect API routes with JWT authentication:

**app/Middleware/JwtMiddleware.php:**

```php
namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Security\JWT;
use Closure;

class JwtMiddleware
{
    protected JWT $jwt;

    public function __construct()
    {
        $this->jwt = jwt();
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Get token from Authorization header
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return new JsonResponse([
                'error' => 'Unauthorized',
                'message' => 'Missing or invalid authorization header',
            ], 401);
        }

        // Extract token
        $token = substr($authHeader, 7); // Remove "Bearer " prefix

        try {
            // Verify and decode token
            $payload = $this->jwt->decode($token);

            // Attach user data to request
            $request->_user = $payload;

            // Continue to controller
            return $next($request);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
```

### Apply to Routes

**routes/api.php:**

```php
use Core\Routing\Router;
use App\Middleware\JwtMiddleware;

// Protected API routes
Router::group(['prefix' => 'api', 'middleware' => [JwtMiddleware::class]], function() {
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::put('/profile', [ProfileController::class, 'update']);
    Router::get('/orders', [OrderController::class, 'index']);
});

// Public routes (no middleware)
Router::post('/api/login', [AuthController::class, 'login']);
Router::post('/api/register', [AuthController::class, 'register']);
```

### Access Authenticated User

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\JsonResponse;

class ProfileController
{
    public function show(Request $request): JsonResponse
    {
        // Get user from request (set by middleware)
        $user = $request->_user;

        return new JsonResponse([
            'user' => [
                'id' => $user['user_id'],
                'email' => $user['email'],
                'role' => $user['role'],
            ],
        ]);
    }
}
```

---

## Token Refresh

### Refresh Token Endpoint

Allow users to refresh their token before it expires:

```php
namespace App\Controllers\Api;

use Core\Http\Request;
use Core\Http\JsonResponse;

class AuthController
{
    public function refresh(Request $request): JsonResponse
    {
        $jwt = jwt();

        try {
            // Decode current token (from middleware)
            $currentUser = $request->_user;

            // Generate new token with same user data
            $newToken = $jwt->encode([
                'user_id' => $currentUser['user_id'],
                'email' => $currentUser['email'],
                'role' => $currentUser['role'],
            ], JWT::getDefaultTtl());

            return new JsonResponse([
                'message' => 'Token refreshed',
                'token' => $newToken,
                'expires_in' => JWT::getDefaultTtl(),
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Token refresh failed',
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
```

### Refresh Before Expiration

Client-side logic to refresh token:

```javascript
// Check if token expires soon (within 5 minutes)
function shouldRefreshToken(token) {
    const payload = JSON.parse(atob(token.split('.')[1]));
    const expiresAt = payload.exp * 1000; // Convert to milliseconds
    const now = Date.now();
    const fiveMinutes = 5 * 60 * 1000;

    return expiresAt - now < fiveMinutes;
}

// Refresh token
async function refreshToken() {
    const response = await fetch('/api/refresh', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${currentToken}`,
        },
    });

    const data = await response.json();
    localStorage.setItem('token', data.token);
}
```

---

## Logout & Token Revocation

### Individual Token Revocation

Invalidate a specific token on logout:

```php
namespace App\Controllers\Api;

use Core\Http\Request;
use Core\Http\JsonResponse;

class AuthController
{
    public function logout(Request $request): JsonResponse
    {
        $jwt = jwt();

        try {
            // Get token from Authorization header
            $authHeader = $request->header('Authorization');
            $token = substr($authHeader, 7); // Remove "Bearer "

            // Revoke this specific token
            $jwt->invalidate($token);

            return new JsonResponse([
                'message' => 'Logged out successfully',
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Logout failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
```

### Revoke All User Tokens

Invalidate all tokens for a user (e.g., password change, security breach):

```php
public function logoutAll(Request $request): JsonResponse
{
    $jwt = jwt();
    $user = $request->_user;

    try {
        // Revoke all tokens for this user
        $jwt->invalidateUser($user['user_id']);

        return new JsonResponse([
            'message' => 'All sessions logged out successfully',
        ]);

    } catch (\Exception $e) {
        return new JsonResponse([
            'error' => 'Logout failed',
            'message' => $e->getMessage(),
        ], 500);
    }
}
```

### Password Change Handler

```php
public function changePassword(Request $request): JsonResponse
{
    $user = $request->_user;
    $jwt = jwt();

    // Validate request
    $data = validate($request->all(), [
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Verify current password
    $userModel = User::find($user['user_id']);

    if (!password_verify($data['current_password'], $userModel->password)) {
        return new JsonResponse([
            'error' => 'Current password is incorrect',
        ], 400);
    }

    // Update password
    $userModel->update([
        'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
    ]);

    // Revoke all existing tokens for security
    $jwt->invalidateUser($user['user_id']);

    // Generate new token
    $newToken = $jwt->encode([
        'user_id' => $user['user_id'],
        'email' => $user['email'],
    ], JWT::getDefaultTtl());

    return new JsonResponse([
        'message' => 'Password changed successfully',
        'token' => $newToken,
    ]);
}
```

---

## Complete API Example

### Login Endpoint

```php
namespace App\Controllers\Api;

use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Security\JWT;
use App\Models\User;

class AuthController
{
    public function login(Request $request): JsonResponse
    {
        // Validate request
        try {
            $data = validate($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
        } catch (\Core\Validation\ValidationException $e) {
            return new JsonResponse([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        // Find user
        $user = User::where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user->password)) {
            return new JsonResponse([
                'error' => 'Invalid credentials',
            ], 401);
        }

        // Generate JWT token
        $jwt = jwt();
        $token = $jwt->encode([
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ], JWT::getDefaultTtl());

        return new JsonResponse([
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWT::getDefaultTtl(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }
}
```

### Protected Resource

```php
namespace App\Controllers\Api;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\Order;

class OrderController
{
    public function index(Request $request): JsonResponse
    {
        // Get authenticated user from middleware
        $user = $request->_user;

        // Fetch user's orders
        $orders = Order::where('user_id', $user['user_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        return new JsonResponse([
            'orders' => $orders,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->_user;

        // Validate
        $data = validate($request->all(), [
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        // Create order
        $order = Order::create([
            'user_id' => $user['user_id'],
            'items' => json_encode($data['items']),
            'total' => $data['total'],
            'status' => 'pending',
        ]);

        return new JsonResponse([
            'message' => 'Order created',
            'order' => $order,
        ], 201);
    }
}
```

### Client-Side Usage

```javascript
// Login
async function login(email, password) {
    const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    });

    const data = await response.json();

    if (response.ok) {
        // Store token
        localStorage.setItem('token', data.token);
        return data.user;
    } else {
        throw new Error(data.error);
    }
}

// Make authenticated request
async function getOrders() {
    const token = localStorage.getItem('token');

    const response = await fetch('/api/orders', {
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    });

    if (response.status === 401) {
        // Token invalid or expired - redirect to login
        window.location.href = '/login';
        return;
    }

    return await response.json();
}

// Logout
async function logout() {
    const token = localStorage.getItem('token');

    await fetch('/api/logout', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    });

    localStorage.removeItem('token');
    window.location.href = '/login';
}
```

---

## Best Practices

### 1. Use Strong JWT Secrets

```bash
# Generate a strong secret (minimum 32 characters)
./sixorbit jwt:secret

# Or use OpenSSL
openssl rand -base64 32
```

### 2. Set Appropriate TTL

```php
// Short TTL for sensitive operations
$token = $jwt->encode($payload, 900); // 15 minutes

// Medium TTL for normal API usage
$token = $jwt->encode($payload, 3600); // 1 hour

// Longer TTL for mobile apps (with refresh)
$token = $jwt->encode($payload, 86400); // 24 hours
```

### 3. Don't Store Sensitive Data in Tokens

```php
// Bad - sensitive data in token
$token = $jwt->encode([
    'user_id' => 123,
    'password' => $user->password, // NEVER!
    'credit_card' => $user->card, // NEVER!
], 3600);

// Good - only identifiers and non-sensitive data
$token = $jwt->encode([
    'user_id' => 123,
    'email' => $user->email,
    'role' => $user->role,
], 3600);
```

### 4. Revoke Tokens on Security Events

```php
// Password change
$jwt->invalidateUser($userId);

// Account compromise
$jwt->invalidateUser($userId);

// Permission changes
$jwt->invalidateUser($userId);
```

### 5. Use HTTPS in Production

JWT tokens can be intercepted if transmitted over HTTP. Always use HTTPS in production.

### 6. Implement Token Refresh

```php
// Allow token refresh before expiration
Router::post('/api/refresh', [AuthController::class, 'refresh'])
    ->middleware([JwtMiddleware::class]);
```

### 7. Handle Token Expiration Gracefully

```javascript
// Axios interceptor example
axios.interceptors.response.use(
    response => response,
    async error => {
        if (error.response.status === 401) {
            // Token expired - try to refresh
            try {
                const { data } = await axios.post('/api/refresh');
                localStorage.setItem('token', data.token);
                // Retry original request
                return axios(error.config);
            } catch (refreshError) {
                // Refresh failed - redirect to login
                window.location.href = '/login';
            }
        }
        return Promise.reject(error);
    }
);
```

### 8. Log Authentication Events

```php
// Successful login
logger()->channel('security')->info('User logged in', [
    'user_id' => $user->id,
    'ip' => $request->ip(),
]);

// Failed login
logger()->channel('security')->warning('Failed login attempt', [
    'email' => $data['email'],
    'ip' => $request->ip(),
]);

// Token revocation
logger()->channel('security')->info('User logged out', [
    'user_id' => $user['user_id'],
]);
```

---

**Related Documentation:**
- [API Controllers](/docs/dev/api-controllers) - Building API endpoints
- [Security](/docs/dev/security) - Security best practices
- [Middleware](/docs/dev/custom-middleware) - Custom middleware

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
