<?php

/**
 * API Routes
 *
 * This file loads all API route modules.
 * Add new route files to routes/api/ directory.
 */

use Core\Routing\Router;
use Core\Http\Request;

// ==========================================
// Load API Route Modules
// ==========================================

// User API routes
require __DIR__ . '/api/users.php';

// Product API routes (uncomment when ready)
require __DIR__ . '/api/products.php';

// Order API routes (uncomment when ready)
require __DIR__ . '/api/orders.php';

// Demo routes (routing feature showcase)
require __DIR__ . '/api/demo.php';

// ==========================================
// Add more API modules here:
// ==========================================
// require __DIR__ . '/api/categories.php';
// require __DIR__ . '/api/payments.php';
// require __DIR__ . '/api/reports.php';

// ==========================================
// General API Routes
// ==========================================

// API health check
Router::get('/api/health', function (Request $request) {
    return \Core\Http\JsonResponse::success([
        'status' => 'ok',
        'version' => '1.0.0',
        'timestamp' => date('c'),
    ]);
})->name('api.health');

// API route tester - interactive HTML page (matches docs design)
Router::get('/api/test', function (Request $request) {
    return \Core\Http\Response::view('api/test');
})->name('api.test');

// ==========================================
// API v2 Routes (Future)
// ==========================================
Router::group(['prefix' => 'api/v2'], function () {
    // Add v2 routes here when ready
});
