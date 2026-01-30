<?php

/**
 * User API Routes
 */

use Core\Routing\Router;
use App\Controllers\Api\V1\UserController;
use App\Controllers\UserApiController;
use App\Middleware\AuthMiddleware;

// Protected API routes (requires authentication)
Router::group(['prefix' => 'api', 'middleware' => [AuthMiddleware::class]], function () {
    Router::get('/users', [UserApiController::class, 'index'])->name('api.users.index');
    Router::get('/users/{id}', [UserApiController::class, 'show'])->name('api.users.show');
    Router::post('/users', [UserApiController::class, 'store'])->name('api.users.store');
    Router::put('/users/{id}', [UserApiController::class, 'update'])->name('api.users.update');
    Router::delete('/users/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
});

// API v1 routes (public)
Router::group(['prefix' => 'api/v1'], function () {
    Router::get('/users', [UserController::class, 'index'])->name('api.v1.users.index');
    Router::get('/users/{id}', [UserController::class, 'show'])->name('api.v1.users.show');
    Router::post('/users', [UserController::class, 'store'])->name('api.v1.users.store');
    Router::put('/users/{id}', [UserController::class, 'update'])->name('api.v1.users.update');
    Router::delete('/users/{id}', [UserController::class, 'destroy'])->name('api.v1.users.destroy');
});
