<?php

/**
 * Product API Routes
 *
 * Example: Add your product controller and uncomment
 */

use Core\Routing\Router;
// use App\Controllers\Api\ProductController;
// use App\Middleware\AuthMiddleware;

// Router::group(['prefix' => 'api/v1'], function () {
//     // Public product routes
//     Router::get('/products', [ProductController::class, 'index'])->name('api.products.index');
//     Router::get('/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
//     Router::get('/products/category/{category}', [ProductController::class, 'byCategory'])->name('api.products.category');
//     Router::get('/products/search', [ProductController::class, 'search'])->name('api.products.search');
// });

// Router::group(['prefix' => 'api/v1', 'middleware' => [AuthMiddleware::class]], function () {
//     // Protected product routes (admin only)
//     Router::post('/products', [ProductController::class, 'store'])->name('api.products.store');
//     Router::put('/products/{id}', [ProductController::class, 'update'])->name('api.products.update');
//     Router::delete('/products/{id}', [ProductController::class, 'destroy'])->name('api.products.destroy');
// });
