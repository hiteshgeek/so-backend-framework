<?php

/**
 * User API Routes
 *
 * Protected endpoints requiring authentication.
 * All routes use UserService for business logic and authorization checks.
 */

use Core\Routing\Router;
use App\Controllers\User\UserApiController;
use App\Middleware\AuthMiddleware;

// Protected API routes (requires authentication)
Router::group(['prefix' => 'api', 'middleware' => [AuthMiddleware::class]], function () {
    Router::get('/users', [UserApiController::class, 'index'])->name('api.users.index');
    Router::get('/users/{id}', [UserApiController::class, 'show'])->name('api.users.show');
    Router::post('/users', [UserApiController::class, 'store'])->name('api.users.store');
    Router::put('/users/{id}', [UserApiController::class, 'update'])->name('api.users.update');
    Router::delete('/users/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
});
