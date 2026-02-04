# Middleware Implementation Summary

## Overview

Middleware provides a mechanism to filter HTTP requests entering your application. This document summarizes the middleware implementation in the framework.

## Available Middleware

### Authentication Middleware

**AuthMiddleware** - Ensures user is authenticated before accessing protected routes.

### CORS Middleware

**CorsMiddleware** - Handles Cross-Origin Resource Sharing headers.

### CSRF Protection

**CsrfMiddleware** - Protects against Cross-Site Request Forgery attacks.

### Rate Limiting

**RateLimitMiddleware** - Prevents abuse by limiting request frequency.

### API Authentication

**ApiAuthMiddleware** - JWT-based authentication for API routes.

## Implementation Details

Middleware can be applied globally or to specific routes/route groups.

```php
// Apply to route group
Router::group(['middleware' => ['auth']], function() {
    Router::get('/dashboard', [DashboardController::class, 'index']);
});

// Apply to single route
Router::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth', 'admin');
```

## Creating Custom Middleware

See [Custom Middleware Guide](/docs/dev-custom-middleware) for step-by-step instructions.

## Testing

Middleware tests are located in `tests/Feature/Middleware/` directory.

## Related Documentation

- [Middleware Guide](/docs/middleware)
- [Creating Custom Middleware](/docs/dev-custom-middleware)
- [Security Layer](/docs/security-layer)
