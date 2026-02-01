# Context-Based API Permissions - Multi-Tenant Access Control

**Files:** `core/Api/RequestContext.php`, `core/Api/ContextPermissions.php`, `core/Api/InternalApiGuard.php`
**Purpose:** Different permission levels for web, mobile, cron, and external API consumers

---

## Table of Contents
- [Overview](#overview)
- [The Four Contexts](#the-four-contexts)
- [Configuration](#configuration)
- [Context Detection](#context-detection)
- [Permission Checking](#permission-checking)
- [Internal API Guard](#internal-api-guard)
- [Complete Examples](#complete-examples)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

---

## Overview

The SO Framework provides **context-based access control** that automatically detects the request source (web, mobile app, cron job, external API) and enforces different permission sets for each context.

**Why Context-Based Permissions?**

Traditional API authentication treats all authenticated requests equally. But in enterprise applications:
- **Web browsers** should have full UI access
- **Mobile apps** should only access user's own resources
- **Cron jobs** need system-level operations
- **External APIs** should have read-only access

**Features:**
- ✅ Automatic context detection (User-Agent, API key, signatures)
- ✅ 4 pre-defined contexts (web, mobile, cron, external)
- ✅ Per-context permission sets with wildcard support
- ✅ Per-context rate limiting
- ✅ Signature-based authentication for internal calls
- ✅ Production-tested for ERP/multi-tenant systems

**Architecture:**
```
┌─────────────────────────────────────────────────────────┐
│           CONTEXT-BASED ACCESS CONTROL                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │ Web Browser  │  │  Mobile App  │  │  Cron Job    │  │
│  │              │  │              │  │              │  │
│  │ Session Auth │  │  JWT Token   │  │  Signature   │  │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘  │
│         │                 │                 │          │
│         ▼                 ▼                 ▼          │
│  ┌─────────────────────────────────────────────────┐   │
│  │         RequestContext::detect()                │   │
│  │  - Check User-Agent                             │   │
│  │  - Check API key header                         │   │
│  │  - Check signature                              │   │
│  └─────────────────────────────────────────────────┘   │
│         │                                               │
│         ▼                                               │
│  ┌─────────────────────────────────────────────────┐   │
│  │  Detected Context: web | mobile | cron | external │   │
│  └─────────────────────────────────────────────────┘   │
│         │                                               │
│         ▼                                               │
│  ┌─────────────────────────────────────────────────┐   │
│  │     ContextPermissions::check()                 │   │
│  │  - Load permission set for context              │   │
│  │  - Check if action allowed                      │   │
│  │  - Apply rate limit for context                 │   │
│  └─────────────────────────────────────────────────┘   │
│         │                                               │
│         ├─── ✅ Allowed → Proceed                       │
│         └─── ❌ Denied → 403 Forbidden                  │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## The Four Contexts

### 1. Web Context

**Who:** Users accessing via web browser
**Authentication:** Session-based (cookies)
**Permissions:** Full access to UI operations
**Rate Limit:** 100 requests/minute

**Use Cases:**
- Dashboard access
- Form submissions
- CRUD operations via web UI
- Admin panels

**Example Permissions:**
```php
'web' => [
    'users.*',          // All user operations
    'products.*',       // All product operations
    'orders.*',         // All order operations
    'dashboard.view',   // Dashboard access
    'reports.*',        // All reports
]
```

---

### 2. Mobile Context

**Who:** Mobile apps (iOS, Android)
**Authentication:** JWT tokens
**Permissions:** Limited to user's own resources
**Rate Limit:** 60 requests/minute

**Use Cases:**
- Mobile app API calls
- User profile updates
- View own orders/data
- Push notifications

**Example Permissions:**
```php
'mobile' => [
    'user.profile.view',    // View own profile
    'user.profile.update',  // Update own profile
    'orders.view.own',      // View own orders only
    'products.view',        // Browse products (read-only)
    'cart.*',               // Shopping cart operations
]
```

**Restrictions:**
- Cannot access other users' data
- Cannot perform admin operations
- Cannot view system reports
- Read-only for most resources

---

### 3. Cron Context

**Who:** Scheduled tasks, background workers
**Authentication:** Signature-based (HMAC)
**Permissions:** System-level operations
**Rate Limit:** Unlimited (trusted internal)

**Use Cases:**
- Nightly report generation
- Database cleanup tasks
- Sending scheduled emails
- Data synchronization
- Invoice generation

**Example Permissions:**
```php
'cron' => [
    'system.*',             // All system operations
    'reports.generate',     // Generate reports
    'cleanup.*',            // All cleanup tasks
    'notifications.send',   // Send bulk notifications
    'invoices.generate',    // Generate invoices
]
```

**Authentication:**
```bash
# Cron job calls API with signature
curl -X POST /api/internal/reports/generate \
  -H "X-Internal-Signature: hmac_sha256_signature" \
  -H "X-Timestamp: 1706742000"
```

---

### 4. External Context

**Who:** Third-party integrations, partner APIs
**Authentication:** API key + JWT
**Permissions:** Read-only access to shared data
**Rate Limit:** 30 requests/minute

**Use Cases:**
- Partner integrations
- Data export to external systems
- Webhooks from third parties
- Public API access

**Example Permissions:**
```php
'external' => [
    'products.view',        // Browse product catalog (read-only)
    'orders.view.public',   // View public order data
    'webhooks.receive',     // Receive webhook callbacks
    'export.products',      // Export product data
]
```

**Restrictions:**
- Read-only access
- No sensitive data (prices visible, but not costs)
- No modification permissions
- Throttled heavily

---

## Configuration

### config/api.php

```php
<?php

return [
    // Default API version
    'default_version' => env('API_VERSION', 'v1'),

    // Supported API versions
    'supported_versions' => ['v1', 'v2'],

    // Deprecated versions (return warning header)
    'deprecated_versions' => [],

    // Context-based permissions
    'context_permissions' => [
        // Web context - Full UI access
        'web' => [
            'users.*',
            'products.*',
            'orders.*',
            'categories.*',
            'dashboard.*',
            'reports.*',
            'settings.*',
        ],

        // Mobile context - Limited to own resources
        'mobile' => [
            'user.profile.*',       // Own profile only
            'orders.view.own',      // Own orders only
            'products.view',        // Browse products
            'cart.*',               // Cart operations
            'wishlist.*',           // Wishlist operations
            'notifications.view',   // View notifications
        ],

        // Cron context - System operations
        'cron' => [
            'system.*',
            'reports.generate',
            'cleanup.*',
            'notifications.send.bulk',
            'invoices.generate',
            'backups.*',
            'analytics.process',
        ],

        // External context - Read-only
        'external' => [
            'products.view',
            'categories.view',
            'orders.view.public',
            'webhooks.receive',
            'export.products',
        ],
    ],

    // Rate limits per context (requests per minute)
    'rate_limits' => [
        'web' => 100,
        'mobile' => 60,
        'cron' => 0, // Unlimited for trusted internal calls
        'external' => 30,
    ],

    // Internal API signature secret (for cron jobs)
    'internal_signature_secret' => env('INTERNAL_API_SECRET', null),
];
```

### Environment Variables

**.env:**
```env
# API Configuration
API_VERSION=v1

# Internal API Secret (for cron job authentication)
INTERNAL_API_SECRET=your-secret-key-here-change-in-production
```

---

## Context Detection

### RequestContext Class

**File:** `core/Api/RequestContext.php`

```php
<?php

namespace Core\Api;

use Core\Http\Request;

class RequestContext
{
    /**
     * Detect request context
     *
     * @param Request $request
     * @return string Context: web|mobile|cron|external
     */
    public static function detect(Request $request): string
    {
        // 1. Check for internal signature (cron jobs)
        if (self::hasInternalSignature($request)) {
            return 'cron';
        }

        // 2. Check User-Agent for mobile apps
        $userAgent = $request->header('User-Agent', '');
        if (self::isMobileApp($userAgent)) {
            return 'mobile';
        }

        // 3. Check for external API key
        if ($request->header('X-API-Key')) {
            return 'external';
        }

        // 4. Default to web context
        return 'web';
    }

    /**
     * Check if request has internal signature
     */
    protected static function hasInternalSignature(Request $request): bool
    {
        return $request->header('X-Internal-Signature') !== null;
    }

    /**
     * Check if User-Agent indicates mobile app
     */
    protected static function isMobileApp(string $userAgent): bool
    {
        $mobileIdentifiers = [
            'MyApp-iOS',
            'MyApp-Android',
            'MyApp/Mobile',
        ];

        foreach ($mobileIdentifiers as $identifier) {
            if (str_contains($userAgent, $identifier)) {
                return true;
            }
        }

        return false;
    }
}
```

---

## Permission Checking

### ContextPermissions Class

**File:** `core/Api/ContextPermissions.php`

```php
<?php

namespace Core\Api;

class ContextPermissions
{
    protected string $context;
    protected array $permissions;

    public function __construct(string $context)
    {
        $this->context = $context;
        $this->permissions = config("api.context_permissions.{$context}", []);
    }

    /**
     * Check if action is allowed in current context
     *
     * @param string $action Action to check (e.g., 'users.create')
     * @return bool Allowed
     */
    public function can(string $action): bool
    {
        foreach ($this->permissions as $permission) {
            if ($this->matches($action, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Match action against permission pattern
     *
     * @param string $action Actual action
     * @param string $pattern Permission pattern (supports wildcards)
     * @return bool Matches
     */
    protected function matches(string $action, string $pattern): bool
    {
        // Exact match
        if ($action === $pattern) {
            return true;
        }

        // Wildcard match (e.g., 'users.*' matches 'users.create')
        if (str_ends_with($pattern, '.*')) {
            $prefix = substr($pattern, 0, -2);
            return str_starts_with($action, $prefix . '.');
        }

        // Wildcard all (e.g., '*' matches everything)
        if ($pattern === '*') {
            return true;
        }

        return false;
    }

    /**
     * Ensure action is allowed (throw exception if not)
     *
     * @param string $action Action to check
     * @throws \Exception
     */
    public function authorize(string $action): void
    {
        if (!$this->can($action)) {
            throw new \Exception(
                "Action '{$action}' not allowed in '{$this->context}' context",
                403
            );
        }
    }

    /**
     * Get all permissions for context
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
```

---

## Internal API Guard

### InternalApiGuard Class

**File:** `core/Api/InternalApiGuard.php`

```php
<?php

namespace Core\Api;

use Core\Http\Request;

class InternalApiGuard
{
    /**
     * Verify internal API signature
     *
     * @param Request $request
     * @return bool Valid signature
     */
    public static function verify(Request $request): bool
    {
        $signature = $request->header('X-Internal-Signature');
        $timestamp = $request->header('X-Timestamp');

        if (!$signature || !$timestamp) {
            return false;
        }

        // Check timestamp (prevent replay attacks)
        if (abs(time() - $timestamp) > 300) { // 5 minutes
            return false;
        }

        // Generate expected signature
        $secret = config('api.internal_signature_secret');
        $payload = $timestamp . $request->uri() . $request->method();
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        // Constant-time comparison
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Generate signature for internal API call
     *
     * @param string $uri Request URI
     * @param string $method HTTP method
     * @param int $timestamp Current timestamp
     * @return array Headers to include
     */
    public static function generateHeaders(string $uri, string $method, int $timestamp = null): array
    {
        $timestamp = $timestamp ?? time();
        $secret = config('api.internal_signature_secret');
        $payload = $timestamp . $uri . $method;
        $signature = hash_hmac('sha256', $payload, $secret);

        return [
            'X-Internal-Signature' => $signature,
            'X-Timestamp' => (string) $timestamp,
        ];
    }
}
```

---

## Complete Examples

### Example 1: Using Context Permissions in Controller

```php
<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Api\RequestContext;
use Core\Api\ContextPermissions;
use App\Models\User;

class UserController
{
    public function index(Request $request): JsonResponse
    {
        // Detect context
        $context = RequestContext::detect($request);
        $permissions = new ContextPermissions($context);

        // Check permission
        if (!$permissions->can('users.view')) {
            return JsonResponse::error('Forbidden', 403);
        }

        // Context-specific logic
        if ($context === 'mobile') {
            // Mobile: Only return current user
            $user = auth()->user();
            return json(['user' => $user]);
        }

        if ($context === 'web') {
            // Web: Return all users (paginated)
            $users = User::all();
            return json(['users' => $users]);
        }

        if ($context === 'external') {
            // External: Public data only
            $users = User::select(['id', 'name'])->get();
            return json(['users' => $users]);
        }

        return JsonResponse::error('Invalid context', 400);
    }

    public function store(Request $request): JsonResponse
    {
        $context = RequestContext::detect($request);
        $permissions = new ContextPermissions($context);

        // Only web and cron can create users
        if (!$permissions->can('users.create')) {
            return JsonResponse::error(
                'User creation not allowed in ' . $context . ' context',
                403
            );
        }

        // Create user
        $user = User::create($request->all());

        return json(['user' => $user], 201);
    }
}
```

### Example 2: Middleware for Context-Based Access Control

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Api\RequestContext;
use Core\Api\ContextPermissions;

class ContextPermissionMiddleware implements MiddlewareInterface
{
    protected string $requiredPermission;

    public function __construct(string $permission)
    {
        $this->requiredPermission = $permission;
    }

    public function handle(Request $request, callable $next): Response
    {
        // Detect context
        $context = RequestContext::detect($request);

        // Check permission
        $permissions = new ContextPermissions($context);

        if (!$permissions->can($this->requiredPermission)) {
            logger()->warning("Permission denied: {$this->requiredPermission} in {$context} context", [
                'uri' => $request->uri(),
                'user_id' => auth()->id(),
            ]);

            if ($request->expectsJson()) {
                return JsonResponse::error(
                    "Action '{$this->requiredPermission}' not allowed in '{$context}' context",
                    403
                );
            }

            return response('Forbidden', 403);
        }

        // Store context in request
        $request->context = $context;

        return $next($request);
    }
}
```

**Usage in routes:**

```php
<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\UserController;
use App\Middleware\ContextPermissionMiddleware;

// Require 'users.create' permission
Router::post('/api/v1/users', [UserController::class, 'store'])
    ->middleware(new ContextPermissionMiddleware('users.create'));

// Require 'reports.generate' permission (cron only)
Router::post('/api/internal/reports/generate', [ReportController::class, 'generate'])
    ->middleware(new ContextPermissionMiddleware('reports.generate'));
```

### Example 3: Cron Job with Signature Authentication

**Cron Job Script:**

```php
<?php

// cron/generate-reports.php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Api\InternalApiGuard;

$uri = '/api/internal/reports/generate';
$method = 'POST';
$timestamp = time();

// Generate signature
$headers = InternalApiGuard::generateHeaders($uri, $method, $timestamp);

// Make internal API call
$ch = curl_init('https://myapp.com' . $uri);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-Internal-Signature: ' . $headers['X-Internal-Signature'],
    'X-Timestamp: ' . $headers['X-Timestamp'],
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'report_type' => 'daily_sales',
    'date' => date('Y-m-d'),
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "Report generated successfully\n";
} else {
    echo "Failed to generate report: {$response}\n";
}
```

**API Controller:**

```php
<?php

namespace App\Controllers\Api\Internal;

use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Api\InternalApiGuard;

class ReportController
{
    public function generate(Request $request): JsonResponse
    {
        // Verify internal signature
        if (!InternalApiGuard::verify($request)) {
            logger()->warning('Invalid internal API signature', [
                'ip' => $request->ip(),
                'uri' => $request->uri(),
            ]);

            return JsonResponse::error('Unauthorized', 401);
        }

        // Generate report
        $reportType = $request->input('report_type');
        $date = $request->input('date');

        // ... report generation logic

        return json([
            'message' => 'Report generated',
            'report_type' => $reportType,
            'date' => $date,
        ]);
    }
}
```

---

## Best Practices

### 1. Use Context Detection Middleware

```php
<?php

// Add context to all API routes
Router::group(['prefix' => '/api', 'middleware' => [ContextDetectionMiddleware::class]], function() {
    // All routes inherit context detection
});
```

### 2. Log Permission Denials

```php
if (!$permissions->can($action)) {
    activity('security')
        ->withProperties([
            'action' => $action,
            'context' => $context,
            'user_id' => auth()->id(),
        ])
        ->log("Permission denied: {$action}");
}
```

### 3. Use Wildcard Permissions

```php
// Allow all product operations
'products.*'

// Allow all read operations
'*.view'

// Allow everything
'*'
```

### 4. Rotate Internal API Secrets

```bash
# Generate new secret
openssl rand -hex 32

# Update .env
INTERNAL_API_SECRET=new_secret_here

# Update all cron jobs
```

### 5. Monitor Context Usage

```php
activity('api-usage')
    ->withProperties([
        'context' => $context,
        'endpoint' => $request->uri(),
        'user_id' => auth()->id(),
    ])
    ->log('API call');
```

---

## Troubleshooting

### Permission Always Denied

**Check:**
1. Context detection is working
2. Permission exists in config for that context
3. Wildcard patterns match correctly

**Debug:**
```php
$context = RequestContext::detect($request);
$permissions = new ContextPermissions($context);

logger()->debug('Permission check', [
    'context' => $context,
    'action' => 'users.create',
    'allowed' => $permissions->can('users.create'),
    'all_permissions' => $permissions->getPermissions(),
]);
```

### Internal Signature Verification Failing

**Common causes:**
1. Clock skew (timestamp > 5 minutes old)
2. Wrong secret in `.env`
3. Signature generated incorrectly

**Debug:**
```php
logger()->debug('Signature verification', [
    'timestamp' => $request->header('X-Timestamp'),
    'time_diff' => abs(time() - $request->header('X-Timestamp')),
    'signature' => substr($request->header('X-Internal-Signature'), 0, 10) . '...',
]);
```

---

## See Also

- **[INTERNAL-API.md](/docs/internal-api)** - Internal API layer overview
- **[API-VERSIONING.md](/docs/api-versioning)** - API version management
- **[SECURITY-LAYER.md](/docs/security-layer)** - Security overview
- **[DEV-CUSTOM-MIDDLEWARE.md](/docs/dev-custom-middleware)** - Creating middleware

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Use Case:** Enterprise ERP, multi-tenant systems, microservices
