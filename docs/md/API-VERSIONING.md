# API Versioning

## Overview

The API Versioning system provides a robust, flexible way to manage multiple API versions simultaneously. It supports URL-based and header-based version detection, version-specific routes, and gradual deprecation of old versions.

## Key Features

- **URL-based versioning** (primary): `/api/v1/users`, `/api/v2/products`
- **Header-based versioning** (fallback): `Accept: application/vnd.api.v1+json`
- **Version-specific route groups** via `Router::version()`
- **Default version fallback** for backward compatibility
- **Deprecation warnings** for old versions
- **Configurable supported versions**
- **Clean, RESTful URLs**

## Quick Start

### 1. Define Versioned Routes

```php
// routes/api.php or bootstrap/app.php

use Core\Routing\Router;

// Version 1 routes
Router::version('v1', function() {
    Router::get('/users', [UserController::class, 'index']);
    Router::get('/users/{id}', [UserController::class, 'show']);
    Router::post('/users', [UserController::class, 'store']);
});

// Version 2 routes (with breaking changes)
Router::version('v2', function() {
    Router::get('/users', [UserControllerV2::class, 'index']);  // New response format
    Router::get('/users/{id}', [UserControllerV2::class, 'show']);
    Router::post('/users', [UserControllerV2::class, 'store']);
});
```

### 2. Access Versioned APIs

```bash
# URL-based (recommended)
curl http://api.example.com/api/v1/users
curl http://api.example.com/api/v2/users

# Header-based
curl -H "Accept: application/vnd.api.v1+json" http://api.example.com/api/users
curl -H "Accept: application/vnd.api.v2+json" http://api.example.com/api/users

# Default version (no version specified)
curl http://api.example.com/api/users  # Uses default (v1)
```

## Version Detection

### URL-Based (Primary)

The middleware extracts the version from the URL path:

```
/api/v1/users       → version: v1
/api/v2/products    → version: v2
/v1/users           → version: v1
```

**Pattern matched:** `/v(\d+)`

### Header-Based (Fallback)

If no version in URL, the middleware checks the Accept header:

```
Accept: application/vnd.api.v1+json    → version: v1
Accept: application/vnd.api.v2+json    → version: v2
Accept: application/vnd.myapp.v1+json  → version: v1
```

**Pattern matched:** `\.v(\d+)`

### Precedence

1. URL version (if present)
2. Accept header version (if present)
3. Default version (from config)

## Configuration

Edit `config/api.php`:

```php
return [
    // Default version when none specified
    'default_version' => env('API_DEFAULT_VERSION', 'v1'),

    // List of supported versions
    'supported_versions' => ['v1', 'v2'],

    // Deprecated versions (still work, but with warnings)
    'deprecated_versions' => [],

    // API route prefix
    'prefix' => env('API_PREFIX', 'api'),
];
```

Environment variables (`.env`):

```env
API_DEFAULT_VERSION=v1
API_PREFIX=api
```

## Router API

### `Router::version()`

Create version-specific route groups:

```php
// Basic usage
Router::version('v1', function() {
    Router::get('/users', [UserController::class, 'index']);
});

// With additional attributes
Router::version('v2', ['middleware' => 'throttle:60'], function() {
    Router::get('/users', [UserControllerV2::class, 'index']);
});

// Nested groups
Router::version('v1', function() {
    Router::group(['middleware' => 'auth'], function() {
        Router::get('/profile', [ProfileController::class, 'show']);
    });
});
```

### Generated Routes

```php
Router::version('v1', function() {
    Router::get('/users', ...);
});
```

Creates route: `/api/v1/users`

## Middleware

### ApiVersionMiddleware

The middleware automatically detects and attaches version information to requests:

```php
namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

class ApiVersionMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Detect version from URL or header
        // Attach to request:
        //   $request->api_version        → "v1", "v2", etc.
        //   $request->api_version_number → 1, 2, etc.

        return $next($request);
    }
}
```

### Accessing Version in Controllers

```php
class UserController
{
    public function index(Request $request)
    {
        $version = $request->api_version;         // "v1"
        $versionNumber = $request->api_version_number;  // 1

        // Version-specific logic
        if ($versionNumber >= 2) {
            return $this->v2Response();
        }

        return $this->v1Response();
    }
}
```

## Versioning Strategies

### 1. Separate Controllers (Recommended)

Create separate controllers for each version:

```php
// app/Controllers/V1/UserController.php
namespace App\Controllers\V1;

class UserController
{
    public function index() {
        return json(['format' => 'v1', 'users' => User::all()]);
    }
}

// app/Controllers/V2/UserController.php
namespace App\Controllers\V2;

class UserController
{
    public function index() {
        return json([
            'data' => User::all(),
            'meta' => ['version' => 'v2']
        ]);
    }
}

// Routes
Router::version('v1', function() {
    Router::get('/users', [\App\Controllers\V1\UserController::class, 'index']);
});

Router::version('v2', function() {
    Router::get('/users', [\App\Controllers\V2\UserController::class, 'index']);
});
```

### 2. Version-Aware Controllers

Handle multiple versions in one controller:

```php
class UserController
{
    public function index(Request $request)
    {
        $users = User::all();

        return match($request->api_version_number) {
            2 => $this->formatV2($users),
            default => $this->formatV1($users),
        };
    }

    private function formatV1($users) {
        return json(['users' => $users]);
    }

    private function formatV2($users) {
        return json([
            'data' => $users,
            'meta' => ['count' => $users->count()]
        ]);
    }
}
```

### 3. Transformers/Resources

Use transformation layers:

```php
class UserResource
{
    public static function collection($users, $version)
    {
        return match($version) {
            'v2' => self::transformV2($users),
            default => self::transformV1($users),
        };
    }
}
```

## Deprecation Management

### Mark Version as Deprecated

```php
// config/api.php
'deprecated_versions' => ['v1'],
```

### Response Headers

Deprecated versions automatically include warning headers:

```http
X-API-Version-Deprecated: true
X-API-Deprecation-Info: API version v1 is deprecated. Please migrate to a newer version.
```

### Sunset Dates

Track when versions will be removed:

```php
// config/api.php
'deprecation_dates' => [
    'v1' => '2026-12-31',  // v1 will be sunset on this date
],
```

## Migration Guide

### Migrating from v1 to v2

1. **Review Changes**
   ```php
   // v1 response
   {
       "users": [...]
   }

   // v2 response (wrapped in data)
   {
       "data": [...],
       "meta": {"count": 10}
   }
   ```

2. **Update Client Code**
   ```javascript
   // v1
   const users = response.users;

   // v2
   const users = response.data;
   ```

3. **Update URL**
   ```
   /api/v1/users → /api/v2/users
   ```

4. **Test Thoroughly**
   - Verify all endpoints work
   - Check response formats
   - Test error handling

## Best Practices

### 1. Version Breaking Changes Only

**Version when:**
- Response format changes
- Required parameters change
- Behavior changes significantly

**Don't version when:**
- Adding optional parameters
- Adding new endpoints
- Fixing bugs

### 2. Support Multiple Versions

Maintain at least 2 versions simultaneously to allow gradual migration:

```php
'supported_versions' => ['v1', 'v2', 'v3'],
'deprecated_versions' => ['v1'],  // v1 deprecated but still works
```

### 3. Document Changeslogx

For each version, document:
- Breaking changes
- New features
- Deprecated features
- Migration guide

### 4. Use Semantic Versioning (in headers)

```http
X-API-Version: 2.1.0
X-API-Min-Version: 2.0.0
X-API-Max-Version: 2.9.9
```

### 5. Test All Versions

```bash
# Run API versioning tests
php sixorbit test api-versioning

# Test each version manually
curl http://api.example.com/api/v1/users
curl http://api.example.com/api/v2/users
```

## Testing

### Run Tests

```bash
php sixorbit test api-versioning
```

### Manual Testing

```bash
# Test v1
curl -X GET http://localhost/api/v1/users

# Test v2
curl -X GET http://localhost/api/v2/users

# Test header-based
curl -H "Accept: application/vnd.api.v2+json" http://localhost/api/users

# Test default fallback
curl -X GET http://localhost/api/users  # Should use default (v1)
```

## Common Patterns

### Versioned Responses

```php
class ApiResponse
{
    public static function format($data, $version)
    {
        return match($version) {
            'v2' => [
                'data' => $data,
                'meta' => ['version' => 'v2', 'timestamp' => time()],
            ],
            default => $data,  // v1 format
        };
    }
}
```

### Version-Specific Validation

```php
public function validateStore(Request $request)
{
    $rules = match($request->api_version_number) {
        2 => [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'metadata' => 'array',  // New in v2
        ],
        default => [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ],
    };

    return $request->validate($rules);
}
```

### Gradual Feature Rollout

```php
public function show(Request $request, $id)
{
    $user = User::find($id);

    // Feature only available in v2+
    if ($request->api_version_number >= 2) {
        $user->load('profile', 'settings');
    }

    return ApiResponse::format($user, $request->api_version);
}
```

## Troubleshooting

### Version Not Detected

Check:
1. Middleware registered in routes
2. URL format correct: `/api/v1/...`
3. Accept header format: `application/vnd.api.v1+json`

### Wrong Version Used

Check precedence:
1. URL version overrides header
2. Header overrides default
3. Default from config

### Routes Not Found

Verify:
1. `Router::version()` wrapping routes
2. API prefix in config (`api.prefix`)
3. Route cache cleared (if applicable)

## Performance

- **Negligible overhead**: Version detection is a simple regex match
- **No database queries**: Configuration loaded once
- **Cached routes**: Route matching happens normally
- **Header parsing**: Only when needed (fallback)

## Related Documentation

- [Routing](ROUTING.md)
- [Middleware](MIDDLEWARE.md)
- [API Design Best Practices](API-DESIGN.md)
- [Configuration](CONFIGURATION.md)

## Examples

### Complete Example

```php
// config/api.php
return [
    'default_version' => 'v1',
    'supported_versions' => ['v1', 'v2'],
    'deprecated_versions' => [],
];

// routes/api.php
Router::version('v1', function() {
    Router::get('/posts', [PostController::class, 'index']);
    Router::post('/posts', [PostController::class, 'store']);
});

Router::version('v2', ['middleware' => 'throttle:60'], function() {
    Router::get('/posts', [PostControllerV2::class, 'index']);
    Router::post('/posts', [PostControllerV2::class, 'store']);
    Router::get('/posts/{id}/comments', [PostControllerV2::class, 'comments']);  // New in v2
});

// app/Controllers/PostController.php (v1)
class PostController
{
    public function index(Request $request)
    {
        return json(['posts' => Post::all()]);
    }
}

// app/Controllers/PostControllerV2.php (v2)
class PostControllerV2
{
    public function index(Request $request)
    {
        return json([
            'data' => Post::with('author')->get(),
            'meta' => ['version' => 'v2', 'count' => Post::count()],
        ]);
    }

    public function comments(Request $request, $id)
    {
        return json([
            'data' => Post::findOrFail($id)->comments,
        ]);
    }
}
```

## Support

For issues or questions:
- GitHub: https://github.com/sixorbit/backend-framework
- Documentation: `/docs`
