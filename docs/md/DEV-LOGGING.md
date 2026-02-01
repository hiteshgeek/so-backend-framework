# Logging & Debugging - Developer Guide

**SO Framework** | **Application Logging** | **Version 1.0**

A practical guide to logging errors, debugging, and monitoring application behavior.

---

## Table of Contents

1. [Overview](#overview)
2. [Basic Logging](#basic-logging)
3. [Log Levels](#log-levels)
4. [Log Channels](#log-channels)
5. [Context Data](#context-data)
6. [Common Patterns](#common-patterns)
7. [Best Practices](#best-practices)

---

## Overview

The framework provides a PSR-3 inspired logger for recording application events, errors, and debugging information.

### Key Features

- Multiple log levels (emergency to debug)
- Daily log rotation
- Multiple channels
- Context data support
- Exception logging

### Accessing the Logger

Use the `logger()` helper function:

```php
logger()->info('User logged in');
logger()->error('Payment failed', ['order_id' => 123]);
logger()->debug('Cache hit', ['key' => 'users.all']);
```

---

## Basic Logging

### Log a Message

```php
logger()->info('Application started');
logger()->warning('Disk space low');
logger()->error('Database connection failed');
```

### Log with Context

```php
logger()->info('Order created', [
    'order_id' => $order->id,
    'user_id' => $user->id,
    'total' => $order->total,
]);
```

---

## Log Levels

The framework supports 8 log levels (RFC 5424):

### 1. Emergency

System is unusable:

```php
logger()->emergency('Application crashed', ['exception' => $e]);
```

### 2. Alert

Action must be taken immediately:

```php
logger()->alert('Payment gateway down');
```

### 3. Critical

Critical conditions:

```php
logger()->critical('Database is full');
```

### 4. Error

Runtime errors that don't require immediate action:

```php
logger()->error('Failed to send email', [
    'to' => $user->email,
    'error' => $exception->getMessage(),
]);
```

### 5. Warning

Exceptional occurrences that are not errors:

```php
logger()->warning('Deprecated API called', [
    'method' => 'oldMethod',
    'caller' => debug_backtrace()[1]['function'],
]);
```

### 6. Notice

Normal but significant events:

```php
logger()->notice('User email changed', [
    'user_id' => $user->id,
    'old_email' => $oldEmail,
    'new_email' => $newEmail,
]);
```

### 7. Info

Interesting events:

```php
logger()->info('User logged in', ['user_id' => $user->id]);
logger()->info('Cache cleared');
```

### 8. Debug

Detailed debug information:

```php
logger()->debug('Query executed', [
    'sql' => $sql,
    'bindings' => $bindings,
    'time' => $executionTime,
]);
```

---

## Log Channels

Organize logs by channel for different purposes:

### Default Channel

```php
// Uses default channel (usually 'daily')
logger()->info('Default log');
```

### Specific Channels

```php
// Database operations
logger()->channel('database')->info('Query executed', ['sql' => $sql]);

// Security events
logger()->channel('security')->warning('Failed login attempt', ['ip' => $ip]);

// Payment transactions
logger()->channel('payments')->error('Payment failed', ['error' => $e->getMessage()]);
```

### Channel Configuration

**config/logging.php:**

```php
return [
    'default' => 'daily',

    'channels' => [
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'level' => 'debug',
            'days' => 14, // Keep logs for 14 days
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/app.log'),
            'level' => 'debug',
        ],

        'security' => [
            'driver' => 'daily',
            'path' => storage_path('logs/security.log'),
            'level' => 'warning',
            'days' => 90, // Keep security logs longer
        ],
    ],
];
```

---

## Context Data

### Placeholder Interpolation

```php
logger()->info('User {username} updated profile', [
    'username' => $user->name,
    'user_id' => $user->id,
]);

// Output: User john_doe updated profile {"user_id":42}
```

### Logging Exceptions

```php
try {
    // Some operation
} catch (\Exception $e) {
    logger()->error('Operation failed', [
        'exception' => $e,
        'user_id' => auth()->user()['id'] ?? null,
    ]);
}

// Logs detailed exception info with stack trace
```

### Logging Arrays

```php
logger()->debug('Request data', [
    'method' => 'POST',
    'url' => '/api/users',
    'data' => $request->all(),
]);
```

### Logging Objects

```php
// Automatically converts objects to string representation
logger()->info('Order processed', [
    'order' => $order, // Logged as class name or __toString() output
]);
```

---

## Common Patterns

### Request/Response Logging

```php
public function handle(Request $request, Closure $next): Response
{
    $start = microtime(true);

    logger()->info('Incoming request', [
        'method' => $request->method(),
        'uri' => $request->uri(),
        'ip' => $request->ip(),
    ]);

    $response = $next($request);

    $duration = round((microtime(true) - $start) * 1000, 2);

    logger()->info('Request completed', [
        'method' => $request->method(),
        'uri' => $request->uri(),
        'status' => $response->getStatusCode(),
        'duration_ms' => $duration,
    ]);

    return $response;
}
```

### Database Query Logging

```php
$start = microtime(true);
$users = DB::table('users')->where('active', true)->get();
$duration = microtime(true) - $start;

logger()->debug('Query executed', [
    'sql' => 'SELECT * FROM users WHERE active = ?',
    'bindings' => [true],
    'duration_ms' => round($duration * 1000, 2),
    'rows' => count($users),
]);
```

### Failed Job Logging

```php
public function failed(\Exception $exception): void
{
    logger()->error('Job failed', [
        'job' => static::class,
        'data' => $this->userId,
        'exception' => $exception,
        'attempts' => $this->attempts,
    ]);
}
```

### Authentication Logging

```php
// Successful login
logger()->channel('security')->info('User logged in', [
    'user_id' => $user->id,
    'ip' => $request->ip(),
]);

// Failed login
logger()->channel('security')->warning('Failed login attempt', [
    'email' => $request->input('email'),
    'ip' => $request->ip(),
]);

// Logout
logger()->channel('security')->info('User logged out', [
    'user_id' => auth()->user()['id'],
]);
```

### Cache Events

```php
// Cache hit
logger()->debug('Cache hit', [
    'key' => $key,
    'ttl' => $ttl,
]);

// Cache miss
logger()->debug('Cache miss', [
    'key' => $key,
]);

// Cache cleared
logger()->info('Cache cleared', [
    'keys' => $keys,
]);
```

### Email Logging

```php
try {
    Mail::to($user->email)->send(new WelcomeEmail($user));

    logger()->info('Email sent', [
        'to' => $user->email,
        'type' => 'welcome',
    ]);
} catch (\Exception $e) {
    logger()->error('Email failed', [
        'to' => $user->email,
        'type' => 'welcome',
        'exception' => $e,
    ]);
}
```

---

## Best Practices

### 1. Use Appropriate Log Levels

```php
// Bad - using error for non-errors
logger()->error('User logged in');

// Good - use info for informational messages
logger()->info('User logged in');

// Bad - using info for errors
logger()->info('Payment failed');

// Good - use error for actual errors
logger()->error('Payment failed', ['exception' => $e]);
```

### 2. Include Context

```php
// Bad - no context
logger()->error('Update failed');

// Good - include helpful context
logger()->error('User update failed', [
    'user_id' => $userId,
    'fields' => array_keys($data),
    'error' => $e->getMessage(),
]);
```

### 3. Avoid Logging Sensitive Data

```php
// Bad - logging passwords
logger()->debug('Login attempt', [
    'email' => $email,
    'password' => $password, // NEVER LOG PASSWORDS
]);

// Good - log without sensitive data
logger()->debug('Login attempt', [
    'email' => $email,
]);

// Bad - logging full credit cards
logger()->info('Payment processed', [
    'card_number' => $cardNumber, // NEVER LOG CARD NUMBERS
]);

// Good - log masked data
logger()->info('Payment processed', [
    'card_last4' => substr($cardNumber, -4),
]);
```

### 4. Use Channels for Organization

```php
// Organize related logs
logger()->channel('security')->warning('Brute force detected');
logger()->channel('payments')->error('Payment gateway timeout');
logger()->channel('database')->debug('Slow query detected');
```

### 5. Log Exceptions Properly

```php
try {
    // Operation
} catch (\Exception $e) {
    // Good - logs full exception details
    logger()->error('Operation failed', [
        'exception' => $e,
        'context' => $additionalContext,
    ]);

    // Re-throw if needed
    throw $e;
}
```

### 6. Clean Up Debug Logs

```php
// Development
if (config('app.debug')) {
    logger()->debug('Debug info', $data);
}

// Remove before production
// logger()->debug('Testing...'); // REMOVE THESE
```

### 7. Monitor Log File Sizes

Logs rotate automatically, but monitor storage:

```bash
# Check log size
du -sh storage/logs/

# Clear old logs manually if needed
find storage/logs -name "*.log" -mtime +30 -delete
```

---

## Complete Example

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Order;
use App\Services\PaymentService;

class OrderController
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(Request $request): Response
    {
        $user = auth()->user();

        logger()->info('Order creation started', [
            'user_id' => $user['id'],
            'items_count' => count($request->input('items', [])),
        ]);

        try {
            // Create order
            $order = Order::create([
                'user_id' => $user['id'],
                'items' => $request->input('items'),
                'total' => $request->input('total'),
            ]);

            logger()->info('Order created', [
                'order_id' => $order->id,
                'total' => $order->total,
            ]);

            // Process payment
            logger()->debug('Processing payment', [
                'order_id' => $order->id,
                'amount' => $order->total,
            ]);

            $payment = $this->paymentService->charge($order);

            logger()->channel('payments')->info('Payment successful', [
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'amount' => $order->total,
            ]);

            return redirect("/orders/{$order->id}")
                ->with('success', 'Order placed successfully');

        } catch (\Exception $e) {
            logger()->channel('payments')->error('Order processing failed', [
                'user_id' => $user['id'],
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return redirect()->back()
                ->withErrors(['order' => 'Failed to process order. Please try again.']);
        }
    }
}
```

---

**Related Documentation:**
- [Error Handling](/docs/dev/error-handling) - Exception handling
- [Security](/docs/dev/security) - Security best practices

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
