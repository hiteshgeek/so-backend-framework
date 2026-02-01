<?php

/**
 * Web Routes
 *
 * This file loads all web route modules.
 * Add new route files to routes/web/ directory.
 */

use Core\Routing\Router;
use Core\Http\Request;
use Core\Http\Response;

// ==========================================
// Home Route
// ==========================================
Router::get('/', function (Request $request) {
    return Response::view('welcome');
})->name('home');

// ==========================================
// Load Route Modules
// ==========================================

// Authentication routes (login, register, password reset)
require __DIR__ . '/web/auth.php';

// Dashboard routes (protected admin area)
require __DIR__ . '/web/dashboard.php';

// Documentation routes
require __DIR__ . '/web/docs.php';

// Media routes (file upload and access)
require __DIR__ . '/web/media.php';

// ==========================================
// Add more route modules here:
// ==========================================
// require __DIR__ . '/web/users.php';
// require __DIR__ . '/web/products.php';
// require __DIR__ . '/web/settings.php';

// ==========================================
// Misc Routes
// ==========================================

// Example route with parameters
Router::get('/users/{id}', function (Request $request, $id) {
    return \Core\Http\JsonResponse::success([
        'user_id' => $id,
        'message' => 'User details',
    ]);
})->whereNumber('id');
