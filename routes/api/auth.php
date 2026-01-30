<?php

/**
 * API Authentication Routes
 *
 * JSON endpoints for authentication (register, login, logout)
 * Used by AJAX calls and API clients
 */

use Core\Routing\Router;
use App\Controllers\AuthApiController;
use App\Controllers\PasswordApiController;
use App\Middleware\AuthMiddleware;
use App\Middleware\ThrottleMiddleware;

// Auth endpoints (rate-limited: 5 attempts per minute)
Router::post('/api/auth/register', [AuthApiController::class, 'register'])
    ->middleware([ThrottleMiddleware::class . ':5,1']);

Router::post('/api/auth/login', [AuthApiController::class, 'login'])
    ->middleware([ThrottleMiddleware::class . ':5,1']);

// Logout (requires authentication)
Router::post('/api/auth/logout', [AuthApiController::class, 'logout'])
    ->middleware([AuthMiddleware::class]);

// Password reset endpoints (rate-limited: 5 attempts per minute)
Router::post('/api/password/forgot', [PasswordApiController::class, 'sendResetLink'])
    ->middleware([ThrottleMiddleware::class . ':5,1']);

Router::post('/api/password/reset', [PasswordApiController::class, 'reset'])
    ->middleware([ThrottleMiddleware::class . ':5,1']);
