<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\UserController;

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
