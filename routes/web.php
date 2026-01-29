<?php

use Core\Routing\Router;
use Core\Http\Request;
use Core\Http\Response;
use App\Controllers\DocsController;
use App\Controllers\AuthController;
use App\Controllers\PasswordController;
use App\Controllers\DashboardController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\CsrfMiddleware;

// Home route
Router::get('/', function (Request $request) {
    return Response::view('welcome');
});

// Documentation routes
Router::get('/docs', [DocsController::class, 'index']);
Router::get('/docs/comprehensive', [DocsController::class, 'comprehensive']);
Router::get('/docs/{file}', [DocsController::class, 'show']);

// Authentication routes - wrapped in CSRF middleware
Router::group(['middleware' => [CsrfMiddleware::class]], function () {

    // Guest routes (redirect to dashboard if authenticated)
    Router::group(['middleware' => [GuestMiddleware::class]], function () {
        Router::get('/register', [AuthController::class, 'showRegister']);
        Router::post('/register', [AuthController::class, 'register']);

        Router::get('/login', [AuthController::class, 'showLogin']);
        Router::post('/login', [AuthController::class, 'login']);

        Router::get('/password/forgot', [PasswordController::class, 'showForgotForm']);
        Router::post('/password/forgot', [PasswordController::class, 'sendResetLink']);

        Router::get('/password/reset/{token}', [PasswordController::class, 'showResetForm']);
        Router::post('/password/reset', [PasswordController::class, 'reset']);
    });

    // Protected routes (require authentication)
    Router::group(['middleware' => [AuthMiddleware::class]], function () {
        Router::get('/dashboard', [DashboardController::class, 'index']);
        Router::get('/dashboard/users/{id}/edit', [DashboardController::class, 'edit']);
        Router::post('/dashboard/users/{id}', [DashboardController::class, 'update']);
        Router::delete('/dashboard/users/{id}', [DashboardController::class, 'destroy']);

        Router::post('/logout', [AuthController::class, 'logout']);
    });
});

// Example JSON API route
Router::get('/api/test', function (Request $request) {
    return \Core\Http\JsonResponse::success([
        'message' => 'Framework is working!',
        'version' => '1.0.0',
    ]);
});

// Example route with parameters
Router::get('/users/{id}', function (Request $request, $id) {
    return \Core\Http\JsonResponse::success([
        'user_id' => $id,
        'message' => 'User details',
    ]);
});
