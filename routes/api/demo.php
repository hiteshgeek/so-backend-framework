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
use App\Controllers\Api\Demo\ValidationDemoController;
use App\Middleware\AuthMiddleware;
use App\Middleware\ThrottleMiddleware;
use App\Middleware\LogRequestMiddleware;

// =============================================
// A) Frontend Validation Demo
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // Validation demo for frontend validation page
    Router::post('/validate-contact', [ValidationDemoController::class, 'validateContact'])
        ->name('demo.validate.contact');

});

// =============================================
// B) Basic HTTP Methods - Closure Routes
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
// M) Optional Route Parameters
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    // Optional ID - returns all users if no ID, specific user if ID provided
    Router::get('/users/{id?}', function (Request $request, $id = null) {
        if ($id === null) {
            return JsonResponse::success([
                'message' => 'All users (no ID provided)',
                'users' => [
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                    ['id' => 3, 'name' => 'Charlie'],
                ],
                'note' => 'Optional parameter {id?} defaults to null',
            ], 'User list');
        }

        return JsonResponse::success([
            'user' => ['id' => $id, 'name' => 'User #' . $id],
            'note' => 'Optional parameter {id?} was provided',
        ], 'Single user');
    })->name('demo.users.optional');

    // Optional page with default value
    Router::get('/posts/{page?}', function (Request $request, int $page = 1) {
        return JsonResponse::success([
            'page' => $page,
            'posts' => array_map(fn($i) => ['id' => $i, 'title' => "Post $i"], range(($page-1)*10+1, $page*10)),
            'note' => 'Optional parameter {page?} defaults to 1',
        ], "Posts page $page");
    })->whereNumber('page')->name('demo.posts.paginated');

});

// =============================================
// N) Route Model Binding
// =============================================

Router::group(['prefix' => 'api/demo/binding'], function () {

    // Automatic model injection by ID
    Router::get('/products/{id}', function (Request $request, int $id) {
        try {
            $product = \App\Models\Product::find($id);
            if (!$product) {
                // Return mock data for demo
                return JsonResponse::success([
                    'product' => [
                        'id' => $id,
                        'name' => "Demo Product #$id",
                        'slug' => "demo-product-$id",
                        'price' => 99.99,
                        'stock' => 50,
                        'status' => 'active'
                    ],
                    'note' => 'Model auto-loaded from database using Product::find($id)',
                    'demo_mode' => 'Using mock data - database not configured',
                ], 'Route Model Binding (by ID)');
            }
            return JsonResponse::success([
                'product' => $product->toArray(),
                'note' => 'Model auto-loaded from database using Product::find($id)',
            ], 'Route Model Binding (by ID)');
        } catch (\Exception $e) {
            // Return mock data on error
            return JsonResponse::success([
                'product' => [
                    'id' => $id,
                    'name' => "Demo Product #$id",
                    'slug' => "demo-product-$id",
                    'price' => 99.99,
                    'stock' => 50,
                    'status' => 'active'
                ],
                'note' => 'Model auto-loaded from database using Product::find($id)',
                'demo_mode' => 'Using mock data - database not configured',
            ], 'Route Model Binding (by ID)');
        }
    })->whereNumber('id')->name('demo.binding.product');

    // Model binding by slug (custom key)
    Router::get('/products-by-slug/{slug}', function (Request $request, string $slug) {
        try {
            $result = \App\Models\Product::where('slug', '=', $slug)->first();

            if (!$result) {
                // Return mock data for demo
                return JsonResponse::success([
                    'product' => [
                        'id' => 1,
                        'name' => ucwords(str_replace('-', ' ', $slug)),
                        'slug' => $slug,
                        'price' => 1299.99,
                        'stock' => 25,
                        'status' => 'active'
                    ],
                    'note' => 'Model auto-loaded by custom key (slug)',
                    'demo_mode' => 'Using mock data - no matching product found',
                ], 'Route Model Binding (by slug)');
            }

            // where()->first() returns array, not Model instance
            return JsonResponse::success([
                'product' => $result,
                'note' => 'Model auto-loaded by custom key (slug)',
            ], 'Route Model Binding (by slug)');
        } catch (\Exception $e) {
            // Return mock data on error
            return JsonResponse::success([
                'product' => [
                    'id' => 1,
                    'name' => ucwords(str_replace('-', ' ', $slug)),
                    'slug' => $slug,
                    'price' => 1299.99,
                    'stock' => 25,
                    'status' => 'active'
                ],
                'note' => 'Model auto-loaded by custom key (slug)',
                'demo_mode' => 'Using mock data - database error: ' . $e->getMessage(),
            ], 'Route Model Binding (by slug)');
        }
    })->whereSlug('slug')->name('demo.binding.productBySlug');

    // Model binding with 404 demonstration
    Router::get('/categories/{id}', function (Request $request, int $id) {
        try {
            $category = \App\Models\Category::find($id);

            // For IDs > 900, demonstrate 404
            if ($id > 900 || !$category) {
                return JsonResponse::error('Category not found - Model binding returns 404 for missing resources', 404);
            }

            if ($category) {
                return JsonResponse::success([
                    'category' => $category->toArray(),
                    'note' => 'Automatic 404 when model not found',
                ], 'Category loaded');
            }

            // Return mock data for demo
            return JsonResponse::success([
                'category' => [
                    'id' => $id,
                    'name' => "Demo Category #$id",
                    'slug' => "demo-category-$id",
                ],
                'note' => 'Automatic 404 when model not found (try ID 999 to see 404)',
                'demo_mode' => 'Using mock data - database not configured',
            ], 'Category loaded');
        } catch (\Exception $e) {
            // Return mock data on error (except for demo 404)
            if ($id > 900) {
                return JsonResponse::error('Category not found - Model binding returns 404 for missing resources', 404);
            }
            return JsonResponse::success([
                'category' => [
                    'id' => $id,
                    'name' => "Demo Category #$id",
                    'slug' => "demo-category-$id",
                ],
                'note' => 'Automatic 404 when model not found (try ID 999 to see 404)',
                'demo_mode' => 'Using mock data - database not configured',
            ], 'Category loaded');
        }
    })->whereNumber('id')->name('demo.binding.category');

});

// =============================================
// O) Multiple Middleware Chaining
// =============================================

// Create a simple middleware chain demonstrator
Router::group([
    'prefix' => 'api/demo/secure',
    'middleware' => [
        AuthMiddleware::class,
        ThrottleMiddleware::class . ':30,1',
        LogRequestMiddleware::class,
    ]
], function () {

    Router::post('/data', function (Request $request) {
        return JsonResponse::success([
            'message' => 'Request passed through 3 middleware layers',
            'middleware_chain' => [
                '1. AuthMiddleware - Authentication check',
                '2. ThrottleMiddleware - Rate limiting (30/min)',
                '3. LogRequestMiddleware - Request logging',
            ],
            'data' => $request->all(),
        ], 'Multi-middleware chain success');
    })->name('demo.secure.data');

    Router::get('/status', function (Request $request) {
        return JsonResponse::success([
            'authenticated' => true,
            'rate_limit_remaining' => '30 per minute',
            'logged' => true,
            'note' => 'This route has 3 chained middleware',
        ], 'Secure status');
    })->name('demo.secure.status');

});

// =============================================
// P) File Upload Routes
// =============================================

Router::group(['prefix' => 'api/demo'], function () {

    Router::post('/upload', function (Request $request) {
        $file = $request->file('document');

        if (!$file) {
            return JsonResponse::error('No file uploaded', 400);
        }

        return JsonResponse::success([
            'name' => $file->getClientFilename(),
            'size' => $file->getSize(),
            'type' => $file->getClientMediaType(),
            'size_formatted' => round($file->getSize() / 1024, 2) . ' KB',
            'note' => 'File uploaded successfully (not saved to disk in demo)',
        ], 'File upload successful');
    })->name('demo.upload');

    Router::post('/upload/multiple', function (Request $request) {
        $files = $request->files();

        if (empty($files)) {
            return JsonResponse::error('No files uploaded', 400);
        }

        $uploaded = [];
        foreach ($files as $key => $file) {
            if (is_array($file)) {
                foreach ($file as $f) {
                    $uploaded[] = [
                        'field' => $key,
                        'name' => $f->getClientFilename(),
                        'size' => $f->getSize(),
                        'type' => $f->getClientMediaType(),
                    ];
                }
            } else {
                $uploaded[] = [
                    'field' => $key,
                    'name' => $file->getClientFilename(),
                    'size' => $file->getSize(),
                    'type' => $file->getClientMediaType(),
                ];
            }
        }

        return JsonResponse::success([
            'count' => count($uploaded),
            'files' => $uploaded,
        ], 'Multiple files uploaded');
    })->name('demo.upload.multiple');

});

// =============================================
// Q) Content Negotiation (JSON/XML/Plain Text)
// =============================================

Router::get('/api/demo/content-negotiation/{id}', function (Request $request, int $id) {
    try {
        $product = \App\Models\Product::find($id);

        if (!$product) {
            // Use mock data
            $product = (object) [
                'id' => $id,
                'name' => "Demo Product #$id",
                'price' => 99.99,
                'stock' => 50,
                'status' => 'active'
            ];
        } else {
            // Convert Model to object for consistent handling
            $product = (object) $product->toArray();
        }
    } catch (\Exception $e) {
        // Use mock data on error
        $product = (object) [
            'id' => $id,
            'name' => "Demo Product #$id",
            'price' => 99.99,
            'stock' => 50,
            'status' => 'active'
        ];
    }

    $acceptHeader = $request->header('Accept', 'application/json');

    // Check what format the client wants
    if (str_contains($acceptHeader, 'application/xml') || str_contains($acceptHeader, 'text/xml')) {
        // Return XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<product>';
        $xml .= '<id>' . htmlspecialchars($product->id) . '</id>';
        $xml .= '<name>' . htmlspecialchars($product->name) . '</name>';
        $xml .= '<price>' . htmlspecialchars($product->price) . '</price>';
        $xml .= '<note>Content negotiation: XML format requested via Accept header</note>';
        $xml .= '</product>';

        return new \Core\Http\Response($xml, 200, ['Content-Type' => 'application/xml']);
    } elseif (str_contains($acceptHeader, 'text/plain')) {
        // Return plain text
        $text = "Product #{$product->id}\n";
        $text .= "Name: {$product->name}\n";
        $text .= "Price: \${$product->price}\n";
        $text .= "\nNote: Content negotiation - plain text format requested via Accept header";

        return new \Core\Http\Response($text, 200, ['Content-Type' => 'text/plain']);
    } else {
        // Default: JSON
        return JsonResponse::success([
            'product' => (array) $product,
            'note' => 'Content negotiation: JSON format (default)',
            'tip' => 'Try with Accept: application/xml or Accept: text/plain',
        ], 'Product data');
    }
})->whereNumber('id')->name('demo.contentNegotiation');

// =============================================
// R) Response Transformation Middleware
// =============================================

// Simulated response wrapper middleware
Router::get('/api/demo/wrapped/data', function (Request $request) {
    // In a real scenario, middleware would wrap this response
    $data = ['message' => 'This is the actual data'];

    // Simulate what ResponseTransformMiddleware would do
    return JsonResponse::success([
        'success' => true,
        'data' => $data,
        'metadata' => [
            'timestamp' => date('c'),
            'request_id' => uniqid('req_'),
            'version' => '1.0',
        ],
        'note' => 'Response wrapped in standardized envelope',
    ], 'Wrapped response');
})->name('demo.wrapped.data');

Router::get('/api/demo/wrapped/error', function (Request $request) {
    // Simulated error response with standard format
    return JsonResponse::error('Something went wrong', 500, [
        'error_code' => 'DEMO_ERROR',
        'metadata' => [
            'timestamp' => date('c'),
            'request_id' => uniqid('req_'),
        ],
        'note' => 'Errors also follow standardized format',
    ]);
})->name('demo.wrapped.error');

// =============================================
// S) Custom Route Constraints
// =============================================

Router::group(['prefix' => 'api/demo/locale'], function () {

    // Locale-specific routes with custom constraint
    Router::get('/{locale}/products', function (Request $request, string $locale) {
        try {
            $products = \App\Models\Product::whereNull('deleted_at')->limit(5)->get();

            if (empty($products)) {
                // Use mock data
                $products = [
                    ['id' => 1, 'name' => 'Product 1', 'price' => 19.99],
                    ['id' => 2, 'name' => 'Product 2', 'price' => 29.99],
                    ['id' => 3, 'name' => 'Product 3', 'price' => 39.99],
                ];
            }
        } catch (\Exception $e) {
            // Use mock data on error
            $products = [
                ['id' => 1, 'name' => 'Product 1', 'price' => 19.99],
                ['id' => 2, 'name' => 'Product 2', 'price' => 29.99],
                ['id' => 3, 'name' => 'Product 3', 'price' => 39.99],
            ];
        }

        return JsonResponse::success([
            'locale' => $locale,
            'message' => "Products in $locale language",
            'products' => $products,
            'note' => 'Custom constraint: locale must be en|es|fr|de',
        ], "Products ($locale)");
    })->where('locale', 'en|es|fr|de')->name('demo.locale.products');

    // Invalid locale returns 404
    Router::get('/{locale}/about', function (Request $request, string $locale) {
        return JsonResponse::success([
            'locale' => $locale,
            'message' => "About page in $locale",
            'note' => 'Try invalid locale (e.g., /zz/about) to see constraint in action',
        ], 'About page');
    })->where('locale', 'en|es|fr|de')->name('demo.locale.about');

});

// =============================================
// T) Route Performance Info
// =============================================

Router::get('/api/demo/performance', function (Request $request) {
    $startTime = microtime(true);

    // Simulate route resolution
    $namedRoutes = Router::getNamedRoutes();
    $demoRoutes = array_filter($namedRoutes, fn($name) => str_starts_with($name, 'demo.'), ARRAY_FILTER_USE_KEY);

    $endTime = microtime(true);
    $duration = round(($endTime - $startTime) * 1000, 2);

    return JsonResponse::success([
        'total_demo_routes' => count($demoRoutes),
        'resolution_time_ms' => $duration,
        'note' => 'Route caching (via route:cache) can improve this 10x',
        'tip' => 'Run: php sixorbit route:cache (if implemented)',
    ], 'Performance metrics');
})->name('demo.performance');

// =============================================
// U) Fallback Route (404 catch-all for API routes only)
// =============================================
// Note: This is registered last to catch unmatched routes.
// Only returns JSON for /api/* routes. Web routes will throw NotFoundException
// so they can be handled by ErrorHandler with HTML error pages.

Router::fallback(function (Request $request) {
    $uri = $request->uri();

    // Only handle API routes with JSON response
    if (str_starts_with($uri, '/api/')) {
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
            'requested_uri' => $uri,
            'requested_method' => $request->method(),
            'available_demo_routes' => count($available),
            'help_url' => '/api/demo/routes',
        ]);
    }

    // For frontend routes, don't throw exception - let them handle 404 themselves
    if (str_starts_with($uri, '/frontend/')) {
        return; // Let the route handle it
    }

    // For other non-API routes, throw NotFoundException to trigger HTML error pages
    throw new \Core\Exceptions\NotFoundException('Page not found: ' . $uri);
});
