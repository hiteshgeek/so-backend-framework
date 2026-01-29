<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\UserController;
use App\Controllers\UserApiController;
use App\Middleware\AuthMiddleware;

// Protected API routes for dashboard (requires authentication)
Router::group(['prefix' => 'api', 'middleware' => [AuthMiddleware::class]], function () {
    // User CRUD operations
    Router::get('/users', [UserApiController::class, 'index']);
    Router::get('/users/{id}', [UserApiController::class, 'show']);
    Router::post('/users', [UserApiController::class, 'store']);
    Router::put('/users/{id}', [UserApiController::class, 'update']);
    Router::delete('/users/{id}', [UserApiController::class, 'destroy']);
});

// API v1 routes
Router::group(['prefix' => 'api/v1'], function () {

    // User routes
    Router::get('/users', [UserController::class, 'index']);
    Router::get('/users/{id}', [UserController::class, 'show']);
    Router::post('/users', [UserController::class, 'store']);
    Router::put('/users/{id}', [UserController::class, 'update']);
    Router::delete('/users/{id}', [UserController::class, 'destroy']);

    // Add more API routes here
});

// API v2 routes (future)
Router::group(['prefix' => 'api/v2'], function () {
    // Add v2 routes here
});
