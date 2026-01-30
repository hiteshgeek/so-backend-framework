<?php

/**
 * Demo Routes
 *
 * Comprehensive routing demonstration showcasing ALL features of the Router.
 * All routes are prefixed with /api/demo.
 *
 * Features demonstrated:
 * - Basic HTTP methods (GET, POST, PUT, PATCH, DELETE)
 * - Route parameters with constraints (whereNumber, whereSlug, whereAlpha, etc.)
 * - Resource routes (apiResource - full CRUD)
 * - Nested resource routes (products/{id}/reviews)
 * - Route groups with prefix and middleware
 * - Named routes with URL generation
 * - Redirect routes (301 & 302)
 * - Fallback route (404 catch-all)
 * - Rate-limited routes (ThrottleMiddleware)
 * - Multiple HTTP methods (match)
 * - Closures and controller actions
 * - Query scopes via controller
 * - Soft delete management (admin routes)
 */

use Core\Routing\Router;
use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Controllers\Api\Demo\DemoProductController;
use App\Controllers\Api\Demo\DemoReviewController;
use App\Middleware\AuthMiddleware;
use App\Middleware\ThrottleMiddleware;
use App\Middleware\LogRequestMiddleware;

// =============================================
// A) Basic HTTP Methods - Closure Routes
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // GET - Simple ping endpoint
    Router::get('/ping', function (Request $request) {
        return JsonResponse::success([
            'pong' => true,
            'timestamp' => date('c'),
            'method' => $request->method(),
            'ip' => $request->ip(),
        ], 'Pong!');
    })->name('demo.ping');

    // POST - Echo back the input
    Router::post('/echo', function (Request $request) {
        return JsonResponse::success([
            'you_sent' => $request->all(),
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method(),
        ], 'Echo response');
    })->name('demo.echo');

    // PUT - Method demonstration
    Router::put('/method-test', function (Request $request) {
        return JsonResponse::success([
            'method' => 'PUT',
            'description' => 'Used for full resource replacement',
            'data' => $request->all(),
        ]);
    })->name('demo.method.put');

    // PATCH - Method demonstration
    Router::patch('/method-test', function (Request $request) {
        return JsonResponse::success([
            'method' => 'PATCH',
            'description' => 'Used for partial resource updates',
            'data' => $request->all(),
        ]);
    })->name('demo.method.patch');

    // DELETE - Method demonstration
    Router::delete('/method-test', function (Request $request) {
        return JsonResponse::success([
            'method' => 'DELETE',
            'description' => 'Used for resource deletion',
        ]);
    })->name('demo.method.delete');

    // ANY - Accepts all HTTP methods
    Router::any('/any-method', function (Request $request) {
        return JsonResponse::success([
            'method' => $request->method(),
            'message' => 'This endpoint accepts any HTTP method',
        ]);
    })->name('demo.any');

});

// =============================================
// B) Route Parameters & Constraints
//    Uses /lookup/ prefix to avoid conflict with apiResource routes
// =============================================

Router::group(['prefix' => 'api/demo/lookup'], function () {

    // whereNumber - Only numeric IDs
    Router::get('/by-id/{id}', function (Request $request, int $id) {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }
        return JsonResponse::success($product->toArray(), 'Product by numeric ID (whereNumber)');
    })->whereNumber('id')->name('demo.lookup.byId');

    // whereSlug - Slug pattern (letters, numbers, dashes)
    Router::get('/by-slug/{slug}', function (Request $request, string $slug) {
        $product = \App\Models\Product::where('slug', '=', $slug)->first();
        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }
        return JsonResponse::success($product, 'Product by slug (whereSlug)');
    })->whereSlug('slug')->name('demo.lookup.bySlug');

    // whereAlphaNumeric - SKU lookup
    Router::get('/by-sku/{sku}', function (Request $request, string $sku) {
        $product = \App\Models\Product::where('sku', '=', $sku)->first();
        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }
        return JsonResponse::success($product, 'Product by SKU (whereAlphaNumeric)');
    })->whereAlphaNumeric('sku')->name('demo.lookup.bySku');

    // whereAlpha - Only alphabetic characters
    Router::get('/category/{name}', function (Request $request, string $name) {
        $category = \App\Models\Category::where('slug', '=', strtolower($name))->first();
        if (!$category) {
            return JsonResponse::error('Category not found', 404);
        }
        return JsonResponse::success($category, 'Category by name (whereAlpha)');
    })->whereAlpha('name')->name('demo.lookup.byName');

    // whereUuid - UUID format validation
    Router::get('/uuid/{uuid}', function (Request $request, string $uuid) {
        return JsonResponse::success([
            'uuid' => $uuid,
            'message' => 'Valid UUID format accepted (whereUuid)',
        ]);
    })->whereUuid('uuid')->name('demo.lookup.uuid');

    // whereIn - Only specific values allowed
    Router::get('/status/{status}', function (Request $request, string $status) {
        $products = \App\Models\Product::where('status', '=', $status)
            ->whereNull('deleted_at')
            ->get();
        return JsonResponse::success([
            'status' => $status,
            'count' => count($products),
            'products' => $products,
        ], "Products by status (whereIn)");
    })->whereIn('status', ['active', 'inactive', 'draft'])->name('demo.lookup.byStatus');

    // Custom where - Regular expression constraint
    Router::get('/year/{year}', function (Request $request, string $year) {
        return JsonResponse::success([
            'year' => $year,
            'message' => 'Valid 4-digit year (custom regex constraint)',
        ]);
    })->where('year', '[0-9]{4}')->name('demo.lookup.year');

    // Multiple constraints on different parameters
    Router::get('/catalog/{category}/{page}', function (Request $request, string $category, int $page) {
        return JsonResponse::success([
            'category' => $category,
            'page' => $page,
            'message' => 'Multiple parameter constraints (whereAlpha + whereNumber)',
        ]);
    })->whereAlpha('category')->whereNumber('page')->name('demo.lookup.catalog');

});

// =============================================
// C) Scoped Query Routes (registered BEFORE apiResource
//    so static segments like /active don't match {id})
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // Active products (using model scope)
    Router::get('/products/active', [DemoProductController::class, 'active'])
        ->name('demo.products.active');

    // Products by category (using model scope)
    Router::get('/products/category/{categoryId}', [DemoProductController::class, 'byCategory'])
        ->whereNumber('categoryId')
        ->name('demo.products.byCategory');

    // Products in price range (using model scope)
    Router::get('/products/price/{min}/{max}', [DemoProductController::class, 'priceRange'])
        ->where(['min' => '[0-9]+\.?[0-9]*', 'max' => '[0-9]+\.?[0-9]*'])
        ->name('demo.products.priceRange');

});

// =============================================
// D) Resource Routes (Full CRUD via apiResource)
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // apiResource generates 5 routes:
    //   GET    /api/demo/products          → index
    //   POST   /api/demo/products          → store
    //   GET    /api/demo/products/{id}     → show
    //   PUT    /api/demo/products/{id}     → update
    //   DELETE /api/demo/products/{id}     → destroy
    Router::apiResource('products', DemoProductController::class);

});

// =============================================
// E) Nested Resource Routes (Reviews under Products)
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // List reviews for a product
    Router::get('/products/{productId}/reviews', [DemoReviewController::class, 'index'])
        ->whereNumber('productId')
        ->name('demo.products.reviews.index');

    // Create a review for a product
    Router::post('/products/{productId}/reviews', [DemoReviewController::class, 'store'])
        ->whereNumber('productId')
        ->name('demo.products.reviews.store');

    // Show a specific review for a product
    Router::get('/products/{productId}/reviews/{id}', [DemoReviewController::class, 'show'])
        ->whereNumber('productId', 'id')
        ->name('demo.products.reviews.show');

    // Update a review
    Router::put('/products/{productId}/reviews/{id}', [DemoReviewController::class, 'update'])
        ->whereNumber('productId', 'id')
        ->name('demo.products.reviews.update');

    // Delete a review
    Router::delete('/products/{productId}/reviews/{id}', [DemoReviewController::class, 'destroy'])
        ->whereNumber('productId', 'id')
        ->name('demo.products.reviews.destroy');

});

// =============================================
// F) Route Groups with Prefix & Middleware
// =============================================

// Admin routes - protected by AuthMiddleware
Router::group(['prefix' => 'api/demo/admin', 'middleware' => [AuthMiddleware::class]], function () {

    // Admin stats
    Router::get('/stats', [DemoProductController::class, 'stats'])
        ->name('demo.admin.stats');

    // Admin product list (includes soft-deleted)
    Router::get('/products', [DemoProductController::class, 'adminIndex'])
        ->name('demo.admin.products');

    // Force delete a product permanently
    Router::delete('/products/{id}/force', [DemoProductController::class, 'forceDestroy'])
        ->whereNumber('id')
        ->name('demo.admin.products.forceDelete');

    // Restore a soft-deleted product
    Router::patch('/products/{id}/restore', [DemoProductController::class, 'restore'])
        ->whereNumber('id')
        ->name('demo.admin.products.restore');

});

// =============================================
// G) Named Routes - List all registered demo routes
// =============================================

Router::get('/api/demo/routes', function (Request $request) {
    $namedRoutes = Router::getNamedRoutes();

    $demoRoutes = [];
    foreach ($namedRoutes as $name => $route) {
        if (str_starts_with($name, 'demo.')) {
            $demoRoutes[] = [
                'name' => $name,
                'methods' => $route->getMethods(),
                'uri' => $route->getUri(),
            ];
        }
    }

    return JsonResponse::success([
        'count' => count($demoRoutes),
        'routes' => $demoRoutes,
        'tip' => 'Use Router::url("demo.ping") to generate URLs from named routes',
    ], 'All named demo routes');
})->name('demo.routes');

// =============================================
// H) Redirect Routes (301 & 302)
// =============================================

// Permanent redirect (301) - old URL to new URL
Router::permanentRedirect('/api/demo/old-products', '/api/demo/products');

// Temporary redirect (302) - legacy alias
Router::redirect('/api/demo/legacy', '/api/demo/ping');

// =============================================
// I) Multiple HTTP Methods (match)
// =============================================

// Accept both GET and POST for search
Router::match(['GET', 'POST'], '/api/demo/search', [DemoProductController::class, 'search'])
    ->name('demo.search');

// =============================================
// J) Rate-Limited Routes
// =============================================

Router::group(['prefix' => 'api/demo', 'middleware' => [ThrottleMiddleware::class . ':10,1']], function () {

    // Rate-limited contact endpoint (10 requests per minute)
    Router::post('/contact', function (Request $request) {
        return JsonResponse::success([
            'message' => 'Contact form submitted',
            'data' => $request->only(['name', 'email', 'message']),
            'rate_limit' => '10 requests per minute',
        ], 'Contact received');
    })->name('demo.contact');

});

// =============================================
// K) Middleware with Logging
// =============================================

Router::group(['prefix' => 'api/demo/logged', 'middleware' => [LogRequestMiddleware::class]], function () {

    Router::get('/action', function (Request $request) {
        return JsonResponse::success([
            'message' => 'This request was logged by LogRequestMiddleware',
            'method' => $request->method(),
            'uri' => $request->uri(),
        ]);
    })->name('demo.logged.action');

});

// (Scoped query routes moved to section C, before apiResource)

// =============================================
// L) Route Information & Debugging (Scoped routes in section C)
// =============================================

Router::get('/api/demo/current-route', function (Request $request) {
    return JsonResponse::success([
        'route_name' => Router::currentRouteName(),
        'route_action' => Router::currentRouteAction(),
        'method' => $request->method(),
        'uri' => $request->uri(),
        'full_url' => $request->fullUrl(),
        'is_ajax' => $request->ajax(),
        'expects_json' => $request->expectsJson(),
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ], 'Current route info');
})->name('demo.currentRoute');

// Check if named route exists and generate URL
Router::get('/api/demo/has-route/{name}', function (Request $request, string $name) {
    $exists = Router::has($name);
    $router = app(Router::class);
    $url = $exists ? $router->url($name) : null;

    return JsonResponse::success([
        'name' => $name,
        'exists' => $exists,
        'url' => $url,
    ], $exists ? 'Route exists' : 'Route not found');
})->name('demo.hasRoute');

// =============================================
// M) Fallback Route (404 catch-all for demo prefix)
// =============================================
// Note: This is registered last to catch unmatched demo routes.
// The global fallback applies to ALL unmatched routes.

Router::fallback(function (Request $request) {
    $demoRoutes = Router::getNamedRoutes();
    $available = [];

    foreach ($demoRoutes as $name => $route) {
        if (str_starts_with($name, 'demo.')) {
            $available[] = [
                'name' => $name,
                'methods' => $route->getMethods(),
                'uri' => $route->getUri(),
            ];
        }
    }

    return JsonResponse::error('Route not found. Check /api/demo/routes for available endpoints.', 404, [
        'requested_uri' => $request->uri(),
        'requested_method' => $request->method(),
        'available_demo_routes' => count($available),
        'help_url' => '/api/demo/routes',
    ]);
});
