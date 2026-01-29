<?php

/**
 * Order API Routes
 *
 * Example: Add your order controller and uncomment
 */

use Core\Routing\Router;
// use App\Controllers\Api\OrderController;
// use App\Middleware\AuthMiddleware;

// Router::group(['prefix' => 'api/v1', 'middleware' => [AuthMiddleware::class]], function () {
//     // All order routes require authentication
//     Router::get('/orders', [OrderController::class, 'index'])->name('api.orders.index');
//     Router::get('/orders/{id}', [OrderController::class, 'show'])->name('api.orders.show');
//     Router::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');
//     Router::put('/orders/{id}', [OrderController::class, 'update'])->name('api.orders.update');
//     Router::delete('/orders/{id}', [OrderController::class, 'cancel'])->name('api.orders.cancel');
//
//     // Order-specific actions
//     Router::post('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('api.orders.confirm');
//     Router::post('/orders/{id}/ship', [OrderController::class, 'ship'])->name('api.orders.ship');
//     Router::post('/orders/{id}/complete', [OrderController::class, 'complete'])->name('api.orders.complete');
// });
