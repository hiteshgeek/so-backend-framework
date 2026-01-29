<?php

/**
 * Dashboard Routes
 *
 * Protected admin/dashboard routes
 */

use Core\Routing\Router;
use App\Controllers\DashboardController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

Router::group(['prefix' => 'dashboard', 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]], function () {

    // Dashboard home
    Router::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User management
    Router::get('/users/create', [DashboardController::class, 'create'])->name('dashboard.users.create');
    Router::post('/users', [DashboardController::class, 'store'])->name('dashboard.users.store');
    Router::get('/users/{id}/edit', [DashboardController::class, 'edit'])->name('dashboard.users.edit');
    Router::post('/users/{id}', [DashboardController::class, 'update'])->name('dashboard.users.update');
    Router::delete('/users/{id}', [DashboardController::class, 'destroy'])->name('dashboard.users.destroy');

    // Add more dashboard routes here...
});
