# Error Handling & Custom Error Pages - Developer Guide

**SO Framework** | **Exception Handling & Error Pages** | **Version 1.0**

A practical guide to handling errors gracefully, creating custom exception classes, and building user-friendly error pages.

---

## Table of Contents

1. [Overview](#overview)
2. [Try-Catch Patterns](#try-catch-patterns)
3. [Custom Exception Classes](#custom-exception-classes)
4. [HTTP Exceptions](#http-exceptions)
5. [Custom Error Pages](#custom-error-pages)
6. [Exception Logging](#exception-logging)
7. [User-Friendly Error Messages](#user-friendly-error-messages)
8. [Best Practices](#best-practices)

---

## Overview

Proper error handling makes your application robust, secure, and user-friendly by catching errors gracefully and providing helpful feedback.

### Key Concepts

- **Exceptions** - Objects representing errors
- **Try-Catch** - Blocks for catching and handling exceptions
- **Custom Exceptions** - Application-specific error types
- **Error Pages** - User-friendly views for errors
- **Logging** - Recording errors for debugging

### Framework Exception Classes

```php
Core\Exceptions\HttpException              // Generic HTTP errors
Core\Exceptions\NotFoundException          // 404 errors
Core\Exceptions\AuthenticationException    // Auth failures
Core\Exceptions\AuthorizationException     // Permission denied
Core\Exceptions\EncryptionException        // Encryption errors
Core\Exceptions\LockoutException           // Account lockouts
Core\Validation\ValidationException        // Validation errors
```

---

## Try-Catch Patterns

### Basic Try-Catch

```php
try {
    // Code that might throw an exception
    $user = User::findOrFail($id);
} catch (\Exception $e) {
    // Handle the error
    logger()->error('User not found', ['id' => $id, 'error' => $e->getMessage()]);
    return redirect()->back()->withErrors(['error' => 'User not found']);
}
```

### Multiple Catch Blocks

Handle different exception types differently:

```php
try {
    $user = User::findOrFail($id);
    $user->update($data);

} catch (\Core\Exceptions\NotFoundException $e) {
    // Handle not found
    return redirect()->back()->withErrors(['error' => 'User not found']);

} catch (\Core\Validation\ValidationException $e) {
    // Handle validation errors
    return redirect()->back()->withErrors($e->errors());

} catch (\Exception $e) {
    // Handle all other exceptions
    logger()->error('Update failed', ['exception' => $e]);
    return redirect()->back()->withErrors(['error' => 'Update failed']);
}
```

### Finally Block

Execute code regardless of whether exception was thrown:

```php
$file = null;

try {
    $file = fopen('data.txt', 'r');
    $content = fread($file, filesize('data.txt'));

} catch (\Exception $e) {
    logger()->error('File read failed', ['exception' => $e]);

} finally {
    // Always close the file
    if ($file) {
        fclose($file);
    }
}
```

### Try-Catch in Controllers

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Order;

class OrderController
{
    public function store(Request $request): Response
    {
        try {
            // Validate input
            $data = validate($request->all(), [
                'items' => 'required|array',
                'total' => 'required|numeric',
            ]);

            // Create order
            $order = Order::create([
                'user_id' => auth()->user()['id'],
                'items' => json_encode($data['items']),
                'total' => $data['total'],
                'status' => 'pending',
            ]);

            logger()->info('Order created', ['order_id' => $order->id]);

            return redirect("/orders/{$order->id}")
                ->with('success', 'Order placed successfully');

        } catch (\Core\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            logger()->error('Order creation failed', [
                'exception' => $e,
                'user_id' => auth()->user()['id'] ?? null,
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to create order. Please try again.'])
                ->withInput();
        }
    }
}
```

---

## Custom Exception Classes

Create custom exceptions for specific application errors.

### Creating a Custom Exception

**app/Exceptions/PaymentFailedException.php:**

```php
<?php

namespace App\Exceptions;

use Exception;

class PaymentFailedException extends Exception
{
    protected $paymentId;
    protected $reason;

    public function __construct(
        string $message,
        ?string $paymentId = null,
        ?string $reason = null
    ) {
        parent::__construct($message);
        $this->paymentId = $paymentId;
        $this->reason = $reason;
    }

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
```

### Using Custom Exceptions

```php
use App\Exceptions\PaymentFailedException;

class PaymentService
{
    public function charge(Order $order): Payment
    {
        try {
            $payment = $this->gateway->charge([
                'amount' => $order->total,
                'currency' => 'USD',
            ]);

            if ($payment->status !== 'success') {
                throw new PaymentFailedException(
                    'Payment was declined',
                    $payment->id,
                    $payment->decline_reason
                );
            }

            return $payment;

        } catch (PaymentFailedException $e) {
            logger()->error('Payment failed', [
                'payment_id' => $e->getPaymentId(),
                'reason' => $e->getReason(),
                'order_id' => $order->id,
            ]);

            throw $e; // Re-throw to caller
        }
    }
}
```

### Business Logic Exceptions

```php
namespace App\Exceptions;

class InsufficientStockException extends \Exception
{
    protected $product;
    protected $requested;
    protected $available;

    public function __construct(string $product, int $requested, int $available)
    {
        $this->product = $product;
        $this->requested = $requested;
        $this->available = $available;

        parent::__construct(
            "Insufficient stock for {$product}. Requested: {$requested}, Available: {$available}"
        );
    }

    public function getProduct(): string
    {
        return $this->product;
    }

    public function getRequested(): int
    {
        return $this->requested;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }
}
```

### Using Business Logic Exceptions

```php
use App\Exceptions\InsufficientStockException;

class InventoryService
{
    public function reserveStock(string $productId, int $quantity): void
    {
        $product = Product::find($productId);

        if ($product->stock < $quantity) {
            throw new InsufficientStockException(
                $product->name,
                $quantity,
                $product->stock
            );
        }

        $product->update(['stock' => $product->stock - $quantity]);
    }
}

// Controller usage
try {
    $this->inventoryService->reserveStock($productId, $quantity);

} catch (InsufficientStockException $e) {
    return redirect()->back()->withErrors([
        'error' => "Only {$e->getAvailable()} items available for {$e->getProduct()}"
    ]);
}
```

---

## HTTP Exceptions

Use HTTP exceptions to abort with specific status codes.

### Using abort() Helper

```php
// 404 Not Found
abort(404, 'Page not found');

// 403 Forbidden
abort(403, 'Access denied');

// 500 Internal Server Error
abort(500, 'Something went wrong');
```

### Throwing HTTP Exceptions

```php
use Core\Exceptions\HttpException;
use Core\Exceptions\NotFoundException;
use Core\Exceptions\AuthorizationException;

// Throw 404
throw new NotFoundException('User not found');

// Throw 403
throw new AuthorizationException('You do not have permission to access this resource');

// Throw custom HTTP code
throw new HttpException('Payment required', 402);
```

### Controller Examples

```php
public function show(Request $request, int $id): Response
{
    $post = Post::find($id);

    if (!$post) {
        abort(404, 'Post not found');
    }

    // Check authorization
    if ($post->user_id !== auth()->user()['id']) {
        abort(403, 'You cannot view this post');
    }

    return Response::view('posts/show', ['post' => $post]);
}
```

### API HTTP Exceptions

```php
use Core\Http\JsonResponse;

public function destroy(Request $request, int $id): JsonResponse
{
    $resource = Resource::find($id);

    if (!$resource) {
        return new JsonResponse([
            'error' => 'Not found',
            'message' => 'Resource not found',
        ], 404);
    }

    if ($resource->user_id !== auth()->user()['id']) {
        return new JsonResponse([
            'error' => 'Forbidden',
            'message' => 'You do not have permission to delete this resource',
        ], 403);
    }

    $resource->delete();

    return new JsonResponse([
        'message' => 'Resource deleted successfully',
    ]);
}
```

---

## Custom Error Pages

Create user-friendly error pages for common HTTP errors.

### 404 Error Page

**resources/views/errors/404.php:**

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            font-weight: bold;
        }
        h2 {
            font-size: 2rem;
            margin: 1rem 0;
        }
        p {
            font-size: 1.2rem;
            margin: 1rem 0 2rem;
            opacity: 0.9;
        }
        a {
            display: inline-block;
            padding: 1rem 2rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        a:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>The page you're looking for doesn't exist or has been moved.</p>
        <a href="<?= url('/') ?>">Go Home</a>
    </div>
</body>
</html>
```

### 500 Error Page

**resources/views/errors/500.php:**

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            font-weight: bold;
        }
        h2 {
            font-size: 2rem;
            margin: 1rem 0;
        }
        p {
            font-size: 1.2rem;
            margin: 1rem 0 2rem;
            opacity: 0.9;
        }
        a {
            display: inline-block;
            padding: 1rem 2rem;
            background: white;
            color: #f5576c;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        a:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>500</h1>
        <h2>Server Error</h2>
        <p>Something went wrong on our end. We're working to fix it!</p>
        <a href="<?= url('/') ?>">Go Home</a>
    </div>
</body>
</html>
```

### 403 Forbidden Page

**resources/views/errors/403.php:**

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 - Forbidden</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ffa751 0%, #ffe259 100%);
            color: #333;
        }
        .error-container { text-align: center; padding: 2rem; }
        h1 { font-size: 8rem; margin: 0; font-weight: bold; }
        h2 { font-size: 2rem; margin: 1rem 0; }
        p { font-size: 1.2rem; margin: 1rem 0 2rem; }
        a {
            display: inline-block;
            padding: 1rem 2rem;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <h2>Access Forbidden</h2>
        <p>You don't have permission to access this resource.</p>
        <a href="<?= url('/') ?>">Go Home</a>
    </div>
</body>
</html>
```

### Rendering Error Pages

```php
// In exception handler or controller
public function handleNotFound(): Response
{
    return Response::view('errors/404', [], 404);
}

public function handleServerError(\Exception $e): Response
{
    // Log the error
    logger()->error('Server error', ['exception' => $e]);

    // Show friendly error page
    return Response::view('errors/500', [], 500);
}
```

---

## Exception Logging

Log exceptions for debugging and monitoring.

### Basic Exception Logging

```php
try {
    $result = performOperation();

} catch (\Exception $e) {
    logger()->error('Operation failed', [
        'exception' => $e,
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);

    throw $e; // Re-throw or handle
}
```

### Logging with Context

```php
try {
    $order = Order::create($data);

} catch (\Exception $e) {
    logger()->error('Order creation failed', [
        'exception' => $e,
        'user_id' => auth()->user()['id'] ?? null,
        'data' => $data,
        'ip' => request()->ip(),
    ]);

    return redirect()->back()->withErrors(['error' => 'Order creation failed']);
}
```

### Channel-Specific Logging

```php
try {
    $payment = $this->processPayment($order);

} catch (\Exception $e) {
    logger()->channel('payments')->error('Payment processing failed', [
        'exception' => $e,
        'order_id' => $order->id,
        'amount' => $order->total,
    ]);

    throw new PaymentFailedException('Payment failed', $order->id);
}
```

### Security Event Logging

```php
try {
    $user = $this->authenticateUser($credentials);

} catch (AuthenticationException $e) {
    logger()->channel('security')->warning('Failed login attempt', [
        'email' => $credentials['email'],
        'ip' => request()->ip(),
        'user_agent' => request()->header('User-Agent'),
    ]);

    return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
}
```

---

## User-Friendly Error Messages

### For End Users

```php
// Bad - technical jargon
return redirect()->back()->withErrors([
    'error' => 'PDOException: SQLSTATE[23000]: Integrity constraint violation'
]);

// Good - user-friendly message
return redirect()->back()->withErrors([
    'error' => 'This email address is already registered. Please use a different email.'
]);
```

### API Error Responses

```php
// Bad - exposing internal details
return new JsonResponse([
    'error' => $e->getMessage(), // Could expose sensitive info
], 500);

// Good - generic but helpful
return new JsonResponse([
    'error' => 'Server Error',
    'message' => 'An unexpected error occurred. Please try again later.',
    'code' => 'ERR_INTERNAL',
], 500);
```

### Development vs Production

```php
// Show detailed errors in development
if (config('app.debug')) {
    return new JsonResponse([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTrace(),
    ], 500);
}

// Show generic errors in production
return new JsonResponse([
    'error' => 'Internal Server Error',
    'message' => 'An unexpected error occurred. Please try again later.',
], 500);
```

### Validation Error Messages

```php
// Custom validation messages
$messages = [
    'email.required' => 'Please enter your email address',
    'email.email' => 'Please enter a valid email address',
    'password.required' => 'Please enter a password',
    'password.min' => 'Password must be at least 8 characters',
];

try {
    $data = validate($request->all(), $rules, $messages);
} catch (ValidationException $e) {
    return redirect()->back()
        ->withErrors($e->errors())
        ->withInput();
}
```

---

## Best Practices

### 1. Always Log Exceptions

```php
try {
    $result = riskyOperation();
} catch (\Exception $e) {
    // ALWAYS log before handling
    logger()->error('Operation failed', ['exception' => $e]);

    // Then handle gracefully
    return redirect()->back()->withErrors(['error' => 'Operation failed']);
}
```

### 2. Don't Catch and Ignore

```php
// Bad - swallowing exceptions
try {
    doSomething();
} catch (\Exception $e) {
    // Nothing here - error is lost!
}

// Good - at least log it
try {
    doSomething();
} catch (\Exception $e) {
    logger()->error('doSomething failed', ['exception' => $e]);
}
```

### 3. Catch Specific Exceptions First

```php
try {
    $user = User::findOrFail($id);
} catch (NotFoundException $e) {
    // Handle not found specifically
    return redirect()->back()->withErrors(['error' => 'User not found']);
} catch (DatabaseException $e) {
    // Handle database errors
    logger()->error('Database error', ['exception' => $e]);
    return redirect()->back()->withErrors(['error' => 'Database error']);
} catch (\Exception $e) {
    // Catch-all for other errors
    logger()->error('Unexpected error', ['exception' => $e]);
    return redirect()->back()->withErrors(['error' => 'Unexpected error']);
}
```

### 4. Use Finally for Cleanup

```php
$lock = null;

try {
    $lock = cache()->lock('operation', 10);
    $lock->get();

    performOperation();

} catch (\Exception $e) {
    logger()->error('Operation failed', ['exception' => $e]);
} finally {
    // Always release the lock
    if ($lock) {
        $lock->release();
    }
}
```

### 5. Don't Expose Sensitive Information

```php
// Bad
catch (\Exception $e) {
    return new JsonResponse(['error' => $e->getMessage()], 500);
}

// Good
catch (\Exception $e) {
    logger()->error('Error occurred', ['exception' => $e]);
    return new JsonResponse(['error' => 'An error occurred'], 500);
}
```

### 6. Re-throw When Appropriate

```php
public function processOrder(Order $order): void
{
    try {
        $this->validateOrder($order);
        $this->chargePayment($order);

    } catch (PaymentFailedException $e) {
        // Log locally
        logger()->error('Payment failed', ['order_id' => $order->id]);

        // Re-throw to caller
        throw $e;
    }
}
```

### 7. Use Custom Exceptions for Business Logic

```php
// Good - clear intent
throw new InsufficientStockException($product, $requested, $available);

// Instead of generic
throw new \Exception("Not enough stock");
```

---

**Related Documentation:**
- [Logging](/docs/dev/logging) - Application logging
- [Security](/docs/dev/security) - Security best practices
- [API Controllers](/docs/dev/api-controllers) - API error handling

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
