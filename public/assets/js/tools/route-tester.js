        // Route grouping for sidebar organization
        const groups = [
            {
                name: 'Fundamentals',
                icon: 'star',
                sections: ['http-methods', 'param-constraints', 'optional-params']
            },
            {
                name: 'Resource Management',
                icon: 'database',
                sections: ['model-scopes', 'api-resource', 'nested-resources', 'model-binding']
            },
            {
                name: 'Middleware & Security',
                icon: 'shield',
                sections: ['middleware-groups', 'middleware-chain', 'rate-limit', 'logging']
            },
            {
                name: 'Advanced Routing',
                icon: 'routes',
                sections: ['named-routes', 'redirects', 'match', 'custom-constraints', 'fallback']
            },
            {
                name: 'Request/Response',
                icon: 'swap-horizontal-circle',
                sections: ['content-negotiation', 'response-transform', 'file-upload']
            },
            {
                name: 'Debugging & Performance',
                icon: 'speedometer',
                sections: ['route-info', 'performance']
            }
        ];

        // Current active tab
        let currentTab = 'routes';

        // API Groups (mirrors structure of groups array)
        const apiGroups = [
            {
                name: 'Authentication',
                icon: 'shield-account',
                sections: ['auth-register', 'auth-login', 'auth-logout', 'auth-remember']
            },
            {
                name: 'Password Management',
                icon: 'lock-reset',
                sections: ['password-forgot', 'password-reset']
            },
            {
                name: 'User CRUD (Protected)',
                icon: 'shield-lock',
                sections: ['users-protected']
            },
            {
                name: 'User CRUD (Public v1)',
                icon: 'account-multiple',
                sections: ['users-public']
            },
            {
                name: 'Error Handling',
                icon: 'alert-circle',
                sections: ['errors']
            }
        ];

        const S = [{
                id: 'http-methods',
                icon: 'swap-horizontal',
                title: 'Basic HTTP Methods',
                desc: 'Register routes for each HTTP method using Router::get(), post(), put(), patch(), delete(), any().',
                code: "Router::get('/ping', function (Request $request) { ... });\nRouter::post('/echo', function (Request $request) { ... });\nRouter::any('/any-method', function (Request $request) { ... });",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/ping',
                        d: 'Returns pong with timestamp, method, and client IP address',
                        u: "Router::get($uri, Closure) \u2014 register a GET route with a closure handler"
                    },
                    {
                        m: 'POST',
                        url: '/api/demo/echo',
                        d: 'Echoes back the posted JSON body along with content type',
                        u: "Router::post($uri, Closure) \u2014 $request->all() returns all posted data",
                        body: '{"message":"Hello from route tester!"}'
                    },
                    {
                        m: 'PUT',
                        url: '/api/demo/method-test',
                        d: 'PUT method \u2014 conventionally used for full resource replacement',
                        u: "Router::put($uri, Closure) \u2014 register a PUT route for full resource updates",
                        body: '{"key":"value"}'
                    },
                    {
                        m: 'PATCH',
                        url: '/api/demo/method-test',
                        d: 'PATCH method \u2014 conventionally used for partial resource updates',
                        u: "Router::patch($uri, Closure) \u2014 register a PATCH route for partial updates",
                        body: '{"key":"patched"}'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/demo/method-test',
                        d: 'DELETE method \u2014 conventionally used for resource deletion',
                        u: "Router::delete($uri, Closure) \u2014 register a DELETE route"
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/any-method',
                        d: 'Accepts any HTTP method (GET, POST, PUT, PATCH, DELETE)',
                        u: "Router::any($uri, Closure) \u2014 matches ALL HTTP methods on a single URI"
                    }
                ]
            },
            {
                id: 'param-constraints',
                icon: 'regex',
                title: 'Route Parameter Constraints',
                desc: 'Restrict route parameters to specific patterns using ->whereNumber(), ->whereSlug(), ->whereAlpha(), ->whereIn(), and custom regex.',
                code: "Router::get('/by-id/{id}', ...)->whereNumber('id');\nRouter::get('/status/{status}', ...)->whereIn('status', ['active','inactive','draft']);\nRouter::get('/year/{year}', ...)->where('year', '[0-9]{4}');",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/lookup/by-id/1',
                        d: 'Only matches numeric IDs \u2014 try /by-id/abc to see it fail',
                        u: "->whereNumber('id') constrains {id} to [0-9]+ regex",
                        tag: 'whereNumber'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/by-slug/laptop-pro-15',
                        d: 'Matches slugs: letters, numbers, and dashes',
                        u: "->whereSlug('slug') constrains {slug} to [a-zA-Z0-9-]+ pattern",
                        tag: 'whereSlug'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/by-sku/LP15001',
                        d: 'Matches alphanumeric only (no dashes or special characters)',
                        u: "->whereAlphaNumeric('sku') constrains {sku} to [a-zA-Z0-9]+",
                        tag: 'whereAlphaNum'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/category/electronics',
                        d: 'Matches letters only (no numbers allowed)',
                        u: "->whereAlpha('name') constrains {name} to [a-zA-Z]+",
                        tag: 'whereAlpha'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/uuid/550e8400-e29b-41d4-a716-446655440000',
                        d: 'Validates full UUID format',
                        u: "->whereUuid('uuid') constrains {uuid} to standard UUID regex",
                        tag: 'whereUuid'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/status/active',
                        d: 'Only allows: active, inactive, or draft',
                        u: "->whereIn('status', ['active','inactive','draft']) restricts to a fixed list",
                        tag: 'whereIn'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/year/2026',
                        d: 'Only matches exactly 4 digits',
                        u: "->where('year', '[0-9]{4}') \u2014 custom regex constraint",
                        tag: 'where'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/lookup/catalog/electronics/2',
                        d: 'Combines alphabetic category with numeric page parameter',
                        u: "->whereAlpha('category')->whereNumber('page') \u2014 chain multiple constraints",
                        tag: 'multi'
                    }
                ]
            },
            {
                id: 'model-scopes',
                icon: 'filter-variant',
                title: 'Model Scoped Queries',
                desc: 'Model scopes like scopeActive, scopeByCategory, and scopePriceBetween filter queries using Product::active()->get().',
                code: "// In Product model:\npublic function scopeActive($query) {\n    return $query->where('status', '=', 'active');\n}\n\n// Usage:\nProduct::active()->get();\nProduct::priceBetween(100, 500)->get();",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/products/active',
                        d: 'Calls Product::active()->get() to fetch only active products',
                        u: "scopeActive adds WHERE status = 'active' \u2014 defined in model, called statically"
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/products/category/5',
                        d: 'Calls Product::byCategory(5)->get() to filter by category',
                        u: "scopeByCategory($id) adds WHERE category_id = ? \u2014 scope with parameter"
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/products/price/100/500',
                        d: 'Calls Product::priceBetween(100, 500)->get() for price range',
                        u: "scopePriceBetween($min, $max) adds WHERE price >= ? AND price <= ?"
                    }
                ]
            },
            {
                id: 'api-resource',
                icon: 'database',
                title: 'Resource Routes (apiResource)',
                desc: 'Router::apiResource() auto-generates 5 RESTful CRUD routes mapped to controller methods: index, store, show, update, destroy.',
                code: "Router::apiResource('products', DemoProductController::class);\n\n// Generates:\n//   GET    /products        \u2192 index()      POST   /products      \u2192 store()\n//   GET    /products/{id}   \u2192 show($id)    PUT    /products/{id} \u2192 update($id)\n//   DELETE /products/{id}   \u2192 destroy($id)",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/products',
                        d: 'index() \u2014 paginated list with filtering, sorting, and search',
                        u: "Query params: ?status=active&category_id=5&search=laptop&sort=price&order=DESC&page=1&per_page=10"
                    },
                    {
                        m: 'POST',
                        url: '/api/demo/products',
                        d: 'store() \u2014 creates a new product with validation',
                        u: "Validates: category_id (required|integer), name (required), slug, sku, price (numeric), stock, status",
                        body: '{"category_id":1,"name":"Test Product","slug":"test-product","sku":"TP001","price":29.99,"stock":10,"status":"draft","description":"Created via route tester"}'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/products/1',
                        d: 'show($id) \u2014 returns product with category, reviews, and tags loaded',
                        u: "Loads related data via Category::find(), Review::where(), and JOIN on product_tags pivot table"
                    },
                    {
                        m: 'PUT',
                        url: '/api/demo/products/1',
                        d: 'update($id) \u2014 partial field update, only modifies fields in request body',
                        u: "Uses Product::find($id) then sets each field and calls $product->save()",
                        body: '{"name":"Updated Product Name","price":39.99}'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/demo/products/15',
                        d: 'destroy($id) \u2014 soft deletes via SoftDeletes trait (sets deleted_at)',
                        u: "Calls $product->delete() which sets deleted_at timestamp. Use admin/restore to undo"
                    }
                ]
            },
            {
                id: 'nested-resources',
                icon: 'file-tree',
                title: 'Nested Resource Routes',
                desc: 'Reviews nested under products: /products/{productId}/reviews/{id}. All queries are scoped to the parent product.',
                code: "Router::get('/products/{productId}/reviews', [DemoReviewController::class, 'index'])\n    ->whereNumber('productId')->name('demo.products.reviews.index');",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/products/1/reviews',
                        d: 'List all reviews for product #1',
                        u: "Scoped query: WHERE product_id = $productId. Supports ?approved=1&sort=rating&order=DESC"
                    },
                    {
                        m: 'POST',
                        url: '/api/demo/products/1/reviews',
                        d: 'Create a new review under product #1',
                        u: "Auto-sets product_id from URL. Validates: user_id, rating (1-5), title (min:3), comment (min:10)",
                        body: '{"user_id":1,"rating":5,"title":"Great product!","comment":"This is an amazing product, highly recommend it."}'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/products/1/reviews/1',
                        d: 'Show review #1 for product #1',
                        u: "Ensures review belongs to product: WHERE id = ? AND product_id = ?"
                    },
                    {
                        m: 'PUT',
                        url: '/api/demo/products/1/reviews/1',
                        d: 'Update review #1',
                        u: "Can update: rating, title, comment, is_approved. Scoped to product",
                        body: '{"rating":4,"title":"Updated review"}'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/demo/products/1/reviews/12',
                        d: 'Delete review #12 from product #1',
                        u: "Hard delete (reviews don\u2019t use SoftDeletes). Verifies review belongs to product"
                    }
                ]
            },
            {
                id: 'middleware-groups',
                icon: 'shield-lock',
                title: 'Route Groups with Middleware',
                desc: 'Router::group() with prefix and middleware array. Admin routes are protected by AuthMiddleware.',
                code: "Router::group(['prefix' => 'api/demo/admin', 'middleware' => [AuthMiddleware::class]], function () {\n    Router::get('/stats', [DemoProductController::class, 'stats']);\n    Router::patch('/products/{id}/restore', [...]);\n});",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/admin/stats',
                        d: 'Returns total, active, and trashed product counts',
                        u: "AuthMiddleware runs before handler. Returns 401 if not authenticated",
                        tag: 'Auth'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/admin/products',
                        d: 'Shows all products including soft-deleted ones',
                        u: "Uses Product::withTrashed() to include deleted_at != NULL records",
                        tag: 'Auth'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/demo/admin/products/15/force',
                        d: 'Permanently removes product from database',
                        u: "Calls $product->forceDelete() \u2014 runs DELETE FROM instead of setting deleted_at",
                        tag: 'Auth'
                    },
                    {
                        m: 'PATCH',
                        url: '/api/demo/admin/products/15/restore',
                        d: 'Restores a soft-deleted product',
                        u: "Calls $product->restore() \u2014 sets deleted_at = NULL. Only works on trashed records",
                        tag: 'Auth'
                    }
                ]
            },
            {
                id: 'named-routes',
                icon: 'tag-text',
                title: 'Named Routes & URL Generation',
                desc: 'Chain ->name() on any route. Use Router::has() to check existence and Router::url() to generate URLs.',
                code: "Router::get('/ping', ...)->name('demo.ping');\n\nRouter::has('demo.ping');            // true\n$router->url('demo.ping');           // full URL\n$router->url('demo.products.show', ['id' => 5]);  // with parameters",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/routes',
                        d: 'Lists all 32 named demo routes with methods and URIs',
                        u: "Iterates Router::getNamedRoutes(), filters by 'demo.' prefix"
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/has-route/demo.ping',
                        d: 'Checks if a named route exists and returns its generated URL',
                        u: "Router::has($name) returns bool. app(Router::class)->url($name) generates full URL"
                    }
                ]
            },
            {
                id: 'redirects',
                icon: 'redo',
                title: 'Redirect Routes',
                desc: 'Router::redirect() for 302 temporary and Router::permanentRedirect() for 301 permanent redirects.',
                code: "Router::permanentRedirect('/old-products', '/api/demo/products');  // 301\nRouter::redirect('/legacy', '/api/demo/ping');                      // 302",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/old-products',
                        d: 'Permanent redirect (301) to /api/demo/products \u2014 browser follows',
                        u: "Router::permanentRedirect() sends 301 + Location header. Browser caches permanently",
                        tag: '301'
                    },
                    {
                        m: 'GET',
                        url: '/api/demo/legacy',
                        d: 'Temporary redirect (302) to /api/demo/ping',
                        u: "Router::redirect() sends 302 + Location header. Browser does not cache",
                        tag: '302'
                    }
                ]
            },
            {
                id: 'match',
                icon: 'call-split',
                title: 'Multiple HTTP Methods (match)',
                desc: 'Router::match() registers a single handler for multiple HTTP methods.',
                code: "Router::match(['GET', 'POST'], '/api/demo/search', [DemoProductController::class, 'search']);",
                routes: [{
                        m: 'GET',
                        url: '/api/demo/search?q=laptop',
                        d: 'Search via GET with ?q= query parameter',
                        u: "Searches product name, SKU, and description with LIKE"
                    },
                    {
                        m: 'POST',
                        url: '/api/demo/search',
                        d: 'Search via POST with JSON body',
                        u: 'Same handler, different input method: {"q":"term"}',
                        body: '{"q":"phone"}'
                    }
                ]
            },
            {
                id: 'rate-limit',
                icon: 'speedometer',
                title: 'Rate-Limited Routes',
                desc: 'ThrottleMiddleware with parameters passed via "ClassName:param1,param2" syntax.',
                code: "Router::group(['middleware' => [ThrottleMiddleware::class . ':10,1']], function () {\n    Router::post('/contact', function ($request) { ... });\n});\n// ThrottleMiddleware receives: handle($request, $next, $maxAttempts=10, $decayMinutes=1)",
                routes: [{
                    m: 'POST',
                    url: '/api/demo/contact',
                    d: 'Max 10 requests per minute, then returns 429 Too Many Requests',
                    u: "ThrottleMiddleware:10,1 \u2014 10 max attempts, 1 minute decay window",
                    body: '{"name":"John","email":"john@test.com","message":"Hello!"}',
                    tag: 'Throttle'
                }]
            },
            {
                id: 'logging',
                icon: 'math-log',
                title: 'Logging Middleware',
                desc: 'Routes grouped with LogRequestMiddleware \u2014 logs every request before it reaches the handler.',
                code: "Router::group(['prefix' => 'api/demo/logged', 'middleware' => [LogRequestMiddleware::class]], function () {\n    Router::get('/action', function ($request) { ... });\n});",
                routes: [{
                    m: 'GET',
                    url: '/api/demo/logged/action',
                    d: 'Request method, URI, and IP are logged before the handler runs',
                    u: "LogRequestMiddleware calls $next($request) after logging. Demonstrates middleware pipeline",
                    tag: 'LogRequest'
                }]
            },
            {
                id: 'route-info',
                icon: 'information',
                title: 'Route Information & Debugging',
                desc: 'Introspect the active route at runtime using Router::currentRouteName() and Router::currentRouteAction().',
                code: "Router::currentRouteName();     // 'demo.currentRoute'\nRouter::currentRouteAction();   // 'Closure' or 'Controller@method'\nRouter::current();              // Route object",
                routes: [{
                    m: 'GET',
                    url: '/api/demo/current-route',
                    d: 'Returns route name, action, method, URI, IP, user-agent, and request detection flags',
                    u: "$request->expectsJson() checks Accept header. $request->ajax() checks X-Requested-With"
                }]
            },
            {
                id: 'fallback',
                icon: 'alert-circle',
                title: 'Fallback Route',
                desc: 'Router::fallback() catches all unmatched routes \u2014 registered last, acts as a custom 404 handler.',
                code: "Router::fallback(function (Request $request) {\n    return JsonResponse::error('Route not found', 404, [\n        'help_url' => '/api/demo/routes'\n    ]);\n});",
                routes: [{
                    m: 'GET',
                    url: '/api/demo/this-does-not-exist',
                    d: 'Returns 404 JSON with available route count and help URL',
                    u: "Fallback must be registered after all other routes. Matches any method and any unmatched URI"
                }]
            }
        ];

        // API Sections (A array - mirrors S array structure)
        const A = [
            {
                id: 'auth-register',
                icon: 'account-plus',
                title: 'User Registration',
                desc: 'Create a new user account with validation. Password is automatically hashed using Argon2ID by the User model. Returns JSON response.',
                code: "// POST /api/auth/register\n// Validation rules:\n[\n    'name' => 'required|min:2|max:255',\n    'email' => 'required|email|unique:users,email',\n    'password' => 'required|min:8|confirmed',\n]\n\n// On success (201):\nreturn JsonResponse::success([\n    'message' => 'Account created successfully!',\n    'user' => [...],\n    'demo_token' => '...',\n], 201);",
                routes: [{
                    m: 'POST',
                    url: '/api/auth/register',
                    d: 'Register new user - validates and creates account',
                    u: 'Requires: name (min:2), email (unique), password (min:8), password_confirmation. Returns 201 with user data and demo token',
                    body: '{"name":"John Doe","email":"john@example.com","password":"SecurePass123!","password_confirmation":"SecurePass123!"}',
                    tag: 'Register'
                }]
            },
            {
                id: 'auth-login',
                icon: 'login',
                title: 'User Login',
                desc: 'Authenticate user with email and password. Returns JSON response with user data and demo token. Throttled to 5 attempts per minute.',
                code: "// POST /api/auth/login\nif (auth()->attempt($credentials, $remember)) {\n    return JsonResponse::success([\n        'message' => 'Login successful!',\n        'user' => [...],\n        'demo_token' => '...',\n    ]);\n}\nreturn JsonResponse::error('Invalid email or password', 401);",
                routes: [{
                    m: 'POST',
                    url: '/api/auth/login',
                    d: 'Login with email and password - returns JSON with token',
                    u: 'Rate limited: 5 attempts/minute. Returns 200 with user data on success, 401 on failure',
                    body: '{"email":"john@example.com","password":"SecurePass123!"}',
                    tag: 'Auth'
                }]
            },
            {
                id: 'auth-remember',
                icon: 'checkbox-marked-circle',
                title: 'Remember Me',
                desc: 'Login with persistent authentication. Creates a remember token valid for 30 days that auto-authenticates on future visits.',
                code: "// POST /api/auth/login with remember=1\nauth()->attempt($credentials, true);\n\n// Backend:\n// 1. Generates random 32-byte token\n// 2. Hashes token (SHA256) before DB storage\n// 3. Sets HTTP-only cookie (30 days)\n// 4. Auto-login via cookie on future requests",
                routes: [{
                    m: 'POST',
                    url: '/api/auth/login',
                    d: 'Login with remember=1 - creates 30-day persistent session',
                    u: 'Sets remember_token cookie that bypasses login on return visits. Returns JSON with remember:true',
                    body: '{"email":"john@example.com","password":"SecurePass123!","remember":"1"}',
                    tag: 'Remember'
                }]
            },
            {
                id: 'auth-logout',
                icon: 'logout',
                title: 'User Logout',
                desc: 'Destroys session and clears remember token. Requires active authentication. Returns JSON response.',
                code: "// POST /api/auth/logout (requires AuthMiddleware)\nauth()->logout();\n\nreturn JsonResponse::success([\n    'message' => 'Logged out successfully'\n]);\n\n// Backend:\n// 1. Destroys session data\n// 2. Clears remember_token from database\n// 3. Deletes remember cookie\n// 4. Regenerates session ID",
                routes: [{
                    m: 'POST',
                    url: '/api/auth/logout',
                    d: 'Logout current user - destroys session and remember token',
                    u: 'Requires: active session (AuthMiddleware). Returns 200 with success message, or 401 if not authenticated',
                    tag: 'Auth Required'
                }]
            },
            {
                id: 'password-forgot',
                icon: 'email-lock',
                title: 'Forgot Password',
                desc: 'Request a password reset token. Generates secure token stored in database, valid for 1 hour. Demo returns token in JSON, production sends email.',
                code: "// POST /api/password/forgot\n$token = bin2hex(random_bytes(32));\n$hashedToken = hash('sha256', $token);\n\napp('db')->table('password_resets')->insert([\n    'email' => $email,\n    'token' => $hashedToken,\n    'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),\n]);\n\nreturn JsonResponse::success([\n    'demo_token' => $token,\n    'demo_reset_url' => '/password/reset/' . $token,\n]);",
                routes: [{
                    m: 'POST',
                    url: '/api/password/forgot',
                    d: 'Request password reset token - generates token valid for 1 hour',
                    u: 'Throttled: 5/min. Returns 200 with demo token/URL. Production sends email. Always returns 200 (no user enumeration)',
                    body: '{"email":"john@example.com"}',
                    tag: 'Throttled'
                }]
            },
            {
                id: 'password-reset',
                icon: 'lock-reset',
                title: 'Reset Password',
                desc: 'Reset password using token from forgot password request. Validates token expiration, updates password (auto-hashed), deletes used token, and returns JSON.',
                code: "// POST /api/password/reset\n$hashedToken = hash('sha256', $token);\n\n$reset = app('db')->table('password_resets')\n    ->where('email', '=', $email)\n    ->where('token', '=', $hashedToken)\n    ->where('expires_at', '>', date('Y-m-d H:i:s'))\n    ->first();\n\nif (!$reset) {\n    return JsonResponse::error('Invalid or expired token', 400);\n}\n\n$user->password = $newPassword; // Auto-hashed\n$user->save();\n\nreturn JsonResponse::success(['message' => 'Password reset successfully!']);",
                routes: [{
                    m: 'POST',
                    url: '/api/password/reset',
                    d: 'Reset password with token - validates and updates password',
                    u: 'Requires: token (from forgot request), email, password (min:8), password_confirmation. Returns 200 on success, 400/422 on error',
                    body: '{"token":"abc123...","email":"john@example.com","password":"NewSecurePass123!","password_confirmation":"NewSecurePass123!"}',
                    tag: 'Throttled'
                }]
            },
            {
                id: 'users-protected',
                icon: 'shield-lock',
                title: 'Protected User CRUD',
                desc: 'User CRUD endpoints protected by AuthMiddleware. Requires valid session or JWT token. Returns 401 if not authenticated.',
                code: "// routes/api/users.php\nRouter::group([\n    'prefix' => 'api',\n    'middleware' => [AuthMiddleware::class]\n], function () {\n    Router::get('/users', [UserApiController::class, 'index']);\n    Router::post('/users', [UserApiController::class, 'store']);\n    Router::get('/users/{id}', [UserApiController::class, 'show']);\n    Router::put('/users/{id}', [UserApiController::class, 'update']);\n    Router::delete('/users/{id}', [UserApiController::class, 'destroy']);\n});",
                routes: [
                    {
                        m: 'GET',
                        url: '/api/users',
                        d: 'List all users (requires authentication)',
                        u: 'AuthMiddleware checks session/JWT. Returns array of users or 401 if not authenticated',
                        tag: 'Auth Required'
                    },
                    {
                        m: 'POST',
                        url: '/api/users',
                        d: 'Create new user (requires authentication)',
                        u: 'Validates: name (required|min:2), email (required|email|unique), password (required|min:8|confirmed). Returns 201 or 422',
                        body: '{"name":"Jane Smith","email":"jane@example.com","password":"Password123!","password_confirmation":"Password123!"}',
                        tag: 'Auth Required'
                    },
                    {
                        m: 'GET',
                        url: '/api/users/1',
                        d: 'Get specific user by ID (requires authentication)',
                        u: 'Returns user object or 404 if not found. Requires auth or returns 401',
                        tag: 'Auth Required'
                    },
                    {
                        m: 'PUT',
                        url: '/api/users/1',
                        d: 'Update user (requires authentication)',
                        u: 'Partial updates supported. Password optional. Returns 200 or 422',
                        body: '{"name":"Jane Doe","email":"jane.doe@example.com"}',
                        tag: 'Auth Required'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/users/2',
                        d: 'Delete user (requires authentication)',
                        u: 'Cannot delete own account (returns 403). Returns 200 on success',
                        tag: 'Auth Required'
                    }
                ]
            },
            {
                id: 'users-public',
                icon: 'account-multiple',
                title: 'Public User API (v1)',
                desc: 'Version 1 user endpoints - public access, no authentication required. Useful for testing and public registration flows.',
                code: "// routes/api/users.php\nRouter::group(['prefix' => 'api/v1'], function () {\n    Router::get('/users', [UserController::class, 'index']);\n    Router::post('/users', [UserController::class, 'store']);\n    Router::get('/users/{id}', [UserController::class, 'show']);\n    Router::put('/users/{id}', [UserController::class, 'update']);\n    Router::delete('/users/{id}', [UserController::class, 'destroy']);\n});",
                routes: [
                    {
                        m: 'GET',
                        url: '/api/v1/users',
                        d: 'List all users (public access)',
                        u: 'Returns array of users with count. No authentication required'
                    },
                    {
                        m: 'POST',
                        url: '/api/v1/users',
                        d: 'Create user via public API',
                        u: 'Simpler validation than protected API. Returns 422 on validation errors, 201 on success',
                        body: '{"name":"Public User","email":"public@example.com","password":"TestPass123!"}'
                    },
                    {
                        m: 'GET',
                        url: '/api/v1/users/1',
                        d: 'Get user by ID (public)',
                        u: 'Returns 404 if not found, 200 with user object if found. No auth required'
                    },
                    {
                        m: 'PUT',
                        url: '/api/v1/users/1',
                        d: 'Update user via public API',
                        u: 'Uses fill() for mass assignment. Returns 200 on success',
                        body: '{"name":"Updated Name"}'
                    },
                    {
                        m: 'DELETE',
                        url: '/api/v1/users/3',
                        d: 'Delete user via public API',
                        u: 'Hard delete. No restrictions. Returns 200 on success'
                    }
                ]
            },
            {
                id: 'errors',
                icon: 'alert-circle',
                title: 'Error Response Examples',
                desc: 'Common HTTP error responses: 401 Unauthorized, 404 Not Found, 422 Unprocessable Entity. Test error handling and validation.',
                code: "// Common error responses:\n\n// 401 Unauthorized\nreturn JsonResponse::error('Unauthorized', 401);\n\n// 404 Not Found\nreturn JsonResponse::error('Resource not found', 404);\n\n// 422 Validation Error\nreturn JsonResponse::error('Validation failed', 422, [\n    'errors' => $validator->errors()\n]);",
                routes: [
                    {
                        m: 'GET',
                        url: '/api/users/999999',
                        d: '404 Not Found - request non-existent user',
                        u: 'Protected endpoint returns 401 if not authenticated, 404 if authenticated but user not found',
                        tag: 'Error'
                    },
                    {
                        m: 'POST',
                        url: '/api/users',
                        d: '401 Unauthorized - protected endpoint without auth',
                        u: 'AuthMiddleware blocks request and returns 401 before reaching controller',
                        body: '{}',
                        tag: 'Error'
                    },
                    {
                        m: 'POST',
                        url: '/api/v1/users',
                        d: '422 Validation Error - invalid data',
                        u: 'Missing required fields or invalid format triggers validation errors',
                        body: '{"name":"A"}',
                        tag: 'Error'
                    }
                ]
            }
        ];

        const el = id => document.getElementById(id);

        // Switch between Routes and APIs tabs
        function switchMainTab(tab) {
            currentTab = tab;

            // Update tab buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.tab === tab);
            });

            // Update content panels
            document.getElementById('routes-content').classList.toggle('active', tab === 'routes');
            document.getElementById('apis-content').classList.toggle('active', tab === 'apis');

            // Re-render sidebar
            renderSidebar();

            // Render API sections if switching to APIs tab
            if (tab === 'apis') {
                if (!document.querySelector('#api-sections .section')) {
                    renderApiSections();
                }
                updateAuthStatus();
            }

            // Update URL hash
            window.history.replaceState(null, '', '#' + tab);
        }

        // Render sidebar with grouping
        function renderSidebar() {
            const sidebar = el('tocList');
            let t = '';

            const activeGroups = currentTab === 'routes' ? groups : apiGroups;
            const activeSections = currentTab === 'routes' ? S : A;

            activeGroups.forEach((group, gi) => {
                t += '<h3><span class="mdi mdi-' + group.icon + '"></span> ' + group.name + '</h3>';
                t += '<ul>';

                group.sections.forEach(sectionId => {
                    const s = activeSections.find(sec => sec.id === sectionId);
                    if (s) {
                        const routeCount = s.routes.length;
                        t += '<li><a href="#' + s.id + '" onclick="expand(\'' + s.id + '\')"><span class="mdi mdi-' + s.icon + '"></span> ' + s.title + ' <span class="route-count-badge">' + routeCount + '</span></a></li>';
                    }
                });

                t += '</ul>';
            });

            sidebar.innerHTML = t;
        }

        // Render routes tab content
        function render() {
            const wrap = el('sections');
            let h = '';
            S.forEach((sec, si) => {
                h += '<div class="section" id="' + sec.id + '">';
                h += '<div class="section-title"><span class="mdi mdi-' + sec.icon + '"></span> ' + sec.title + '</div>';
                h += '<p class="section-desc">' + sec.desc + '</p>';
                if (sec.code) {
                    h += '<div class="code-container"><div class="code-header"><span class="code-lang">PHP</span><button class="code-copy" onclick="copyCode(this)" aria-label="Copy code"><span class="mdi mdi-content-copy"></span></button></div><pre class="code-block"><code class="language-php">' + esc(sec.code) + '</code></pre></div>';
                }
                h += '<div class="route-list">';
                sec.routes.forEach((r, ri) => {
                    const mc = r.m.toLowerCase();
                    const uh = esc(r.url).replace(/\{([^}]+)\}/g, '<span class="api-path-param">{$1}</span>');
                    const tg = r.tag ? '<span class="route-tag">' + r.tag + '</span>' : '';
                    h += '<div class="route-card">';
                    h += '<div class="route-header"><span class="api-method api-method-' + mc + '">' + r.m + '</span><span class="api-path">' + uh + '</span>' + tg + '<button class="btn-test" onclick="fire(' + si + ',' + ri + ')"><span class="mdi mdi-play"></span> Test</button></div>';
                    h += '<div class="route-body"><div class="route-desc">' + r.d + '</div>';
                    if (r.u) h += '<div class="route-usage">' + r.u + '</div>';
                    h += '</div></div>';
                });
                h += '</div></div>';
            });
            wrap.innerHTML = h;

            // Apply syntax highlighting
            if (typeof hljs !== 'undefined') {
                document.querySelectorAll('#sections .code-block code').forEach(block => {
                    if (!block.dataset.highlighted) {
                        hljs.highlightElement(block);
                        block.dataset.highlighted = 'yes';
                    }
                });
            }
        }

        // Render API sections
        function renderApiSections() {
            const wrap = el('api-sections');
            let h = '';

            A.forEach((sec, si) => {
                h += '<div class="section" id="' + sec.id + '">';
                h += '<div class="section-title"><span class="mdi mdi-' + sec.icon + '"></span> ' + sec.title + '</div>';
                h += '<p class="section-desc">' + sec.desc + '</p>';

                if (sec.code) {
                    h += '<div class="code-container"><div class="code-header"><span class="code-lang">PHP</span><button class="code-copy" onclick="copyCode(this)" aria-label="Copy code"><span class="mdi mdi-content-copy"></span></button></div><pre class="code-block"><code class="language-php">' + esc(sec.code) + '</code></pre></div>';
                }

                h += '<div class="route-list">';
                sec.routes.forEach((r, ri) => {
                    const mc = r.m.toLowerCase();
                    const uh = esc(r.url).replace(/\{([^}]+)\}/g, '<span class="api-path-param">{$1}</span>');
                    const tg = r.tag ? '<span class="route-tag">' + r.tag + '</span>' : '';
                    h += '<div class="route-card">';
                    h += '<div class="route-header"><span class="api-method api-method-' + mc + '">' + r.m + '</span><span class="api-path">' + uh + '</span>' + tg + '<button class="btn-test" onclick="fireApi(' + si + ',' + ri + ')"><span class="mdi mdi-play"></span> Test</button></div>';
                    h += '<div class="route-body"><div class="route-desc">' + r.d + '</div>';
                    if (r.u) h += '<div class="route-usage">' + r.u + '</div>';
                    h += '</div></div>';
                });
                h += '</div></div>';
            });

            wrap.innerHTML = h;

            // Apply syntax highlighting
            if (typeof hljs !== 'undefined') {
                document.querySelectorAll('#api-sections .code-block code').forEach(block => {
                    if (!block.dataset.highlighted) {
                        hljs.highlightElement(block);
                        block.dataset.highlighted = 'yes';
                    }
                });
            }
        }

        function esc(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        }

        function toggleSec(el) {
            el.closest('.section').classList.toggle('collapsed');
        }

        function expand(id) {
            const s = document.getElementById(id);
            if (s) s.classList.remove('collapsed');
        }

        function fire(si, ri) {
            const r = S[si].routes[ri];
            const m = r.m === 'ANY' ? 'GET' : r.m;
            if (['POST', 'PUT', 'PATCH'].includes(m)) {
                openModal(m, r.url, r.body || '{}');
                return;
            }
            sendRequest(m, r.url);
        }

        function openModal(method, url, body) {
            el('modalTitle').textContent = method + '  ' + url;
            el('modalUrl').value = url;
            try {
                el('modalBody').value = JSON.stringify(JSON.parse(body), null, 2);
            } catch (e) {
                el('modalBody').value = body;
            }
            el('modal').classList.add('show');
            el('modalSend').onclick = () => {
                closeModal();
                sendRequest(method, el('modalUrl').value, el('modalBody').value);
            };
        }

        function closeModal() {
            el('modal').classList.remove('show');
        }

        // Mock auth token management
        function getAuthToken() {
            return sessionStorage.getItem('demo_auth_token');
        }

        function setAuthToken(token) {
            sessionStorage.setItem('demo_auth_token', token);
            updateAuthStatus();
        }

        function clearAuth() {
            sessionStorage.removeItem('demo_auth_token');
            updateAuthStatus();
        }

        function updateAuthStatus() {
            const token = getAuthToken();
            const statusDiv = el('authStatus');
            const statusText = el('authStatusText');
            const clearBtn = el('clearAuthBtn');

            if (!statusDiv) return; // Not on APIs tab

            if (token) {
                statusDiv.classList.add('authenticated');
                statusDiv.querySelector('.mdi').className = 'mdi mdi-account-check';
                statusText.textContent = 'Authenticated (Demo Token)';
                clearBtn.style.display = 'flex';
            } else {
                statusDiv.classList.remove('authenticated');
                statusDiv.querySelector('.mdi').className = 'mdi mdi-account-off';
                statusText.textContent = 'Not authenticated';
                clearBtn.style.display = 'none';
            }
        }

        // Fire API request (for APIs tab)
        function fireApi(si, ri) {
            const r = A[si].routes[ri];
            const m = r.m === 'ANY' ? 'GET' : r.m;

            // Check if this is a login request
            const isLoginRequest = r.url === '/login' && m === 'POST';

            if (['POST', 'PUT', 'PATCH'].includes(m)) {
                // Open modal with isApiRequest flag
                openModalForApi(m, r.url, r.body || '{}', isLoginRequest);
                return;
            }

            sendApiRequest(m, r.url, null, isLoginRequest);
        }

        function openModalForApi(method, url, body, isLoginRequest) {
            el('modal').classList.add('show');
            el('modalTitle').textContent = method + ' Request';
            el('modalUrl').value = url;
            try {
                el('modalBody').value = JSON.stringify(JSON.parse(body), null, 2);
            } catch (e) {
                el('modalBody').value = body;
            }

            // Store for send button
            el('modalSend').onclick = function() {
                sendApiRequest(method, el('modalUrl').value, el('modalBody').value, isLoginRequest);
                closeModal();
            };
        }

        async function sendApiRequest(method, url, body, isLoginRequest = false) {
            // Show loading in response panel
            const m = el('resMethod');
            m.textContent = method;
            m.className = 'api-method api-method-' + method.toLowerCase();
            el('resUrl').textContent = url;
            el('resStatus').textContent = '...';
            el('resStatus').className = 'res-status';
            el('resTime').textContent = '';
            el('resBody').textContent = 'Loading...';
            el('resPanel').classList.add('show');

            const opts = {
                method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };

            // Add auth token if available (except for login/register requests)
            if (!isLoginRequest && !url.includes('/register')) {
                const token = getAuthToken();
                if (token) {
                    opts.headers['Authorization'] = 'Bearer ' + token;
                }
            }

            if (body && !['GET', 'HEAD', 'DELETE'].includes(method)) {
                opts.body = body;
            }

            const t0 = performance.now();
            try {
                const res = await fetch(url, opts);
                const ms = Math.round(performance.now() - t0);
                const text = await res.text();

                // Handle login/register success - extract demo token from JSON response
                if ((isLoginRequest || url.includes('/api/auth/register')) && res.ok && text) {
                    try {
                        const jsonData = JSON.parse(text);
                        if (jsonData.data && jsonData.data.demo_token) {
                            setAuthToken(jsonData.data.demo_token);
                        } else if (jsonData.demo_token) {
                            setAuthToken(jsonData.demo_token);
                        }
                    } catch (e) {
                        // If JSON parsing fails, ignore
                    }
                }

                // Update status display
                el('resStatus').textContent = res.status + ' ' + res.statusText;
                if (res.status < 300) el('resStatus').className = 'res-status s2xx';
                else if (res.status < 400) el('resStatus').className = 'res-status s3xx';
                else if (res.status < 500) el('resStatus').className = 'res-status s4xx';
                else el('resStatus').className = 'res-status s5xx';

                el('resTime').textContent = ms + 'ms';

                // Format and highlight response
                try {
                    const formatted = JSON.stringify(JSON.parse(text), null, 2);
                    const codeEl = document.createElement('code');
                    codeEl.className = 'language-json';
                    codeEl.textContent = formatted;

                    if (typeof hljs !== 'undefined') {
                        hljs.highlightElement(codeEl);
                    }

                    el('resBody').innerHTML = '';
                    el('resBody').appendChild(codeEl);
                } catch (e) {
                    el('resBody').textContent = text || '(empty response)';
                }
            } catch (err) {
                el('resStatus').textContent = 'Error';
                el('resStatus').className = 'res-status s5xx';

                const errorJson = JSON.stringify({ error: err.message }, null, 2);
                const codeEl = document.createElement('code');
                codeEl.className = 'language-json';
                codeEl.textContent = errorJson;

                if (typeof hljs !== 'undefined') {
                    hljs.highlightElement(codeEl);
                }

                el('resBody').innerHTML = '';
                el('resBody').appendChild(codeEl);
            }
        }

        async function sendRequest(method, url, body) {
            const m = el('resMethod');
            m.textContent = method;
            m.className = 'api-method api-method-' + method.toLowerCase();
            el('resUrl').textContent = url;
            el('resStatus').textContent = '...';
            el('resStatus').className = 'res-status';
            el('resTime').textContent = '';
            el('resBody').textContent = 'Loading...';
            el('resPanel').classList.add('show');
            const opts = {
                method,
                headers: {
                    'Accept': 'application/json'
                }
            };
            if (body && !['GET', 'HEAD', 'DELETE'].includes(method)) {
                opts.headers['Content-Type'] = 'application/json';
                opts.body = body;
            }
            const t0 = performance.now();
            try {
                const res = await fetch(url, opts);
                const ms = Math.round(performance.now() - t0);
                const text = await res.text();
                el('resStatus').textContent = res.status + ' ' + res.statusText;
                if (res.status < 300) el('resStatus').className = 'res-status s2xx';
                else if (res.status < 400) el('resStatus').className = 'res-status s3xx';
                else if (res.status < 500) el('resStatus').className = 'res-status s4xx';
                else el('resStatus').className = 'res-status s5xx';
                el('resTime').textContent = ms + 'ms';
                try {
                    el('resBody').textContent = JSON.stringify(JSON.parse(text), null, 2);
                } catch (e) {
                    el('resBody').textContent = text || '(empty response)';
                }
            } catch (err) {
                el('resStatus').textContent = 'Error';
                el('resStatus').className = 'res-status s5xx';
                el('resBody').textContent = err.message;
            }
        }

        function closeRes() {
            el('resPanel').classList.remove('show');
        }

        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    document.querySelectorAll('.docs-sidebar a').forEach(a => a.classList.remove('active'));
                    const link = document.querySelector('.docs-sidebar a[href="#' + e.target.id + '"]');
                    if (link) link.classList.add('active');
                }
            });
        }, {
            rootMargin: '-80px 0px -60% 0px'
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeRes();
                closeModal();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL hash for tab
            const hash = window.location.hash.slice(1);
            if (hash === 'apis') {
                currentTab = 'apis';
                document.querySelector('[data-tab="apis"]').classList.add('active');
                document.querySelector('[data-tab="routes"]').classList.remove('active');
                document.getElementById('routes-content').classList.remove('active');
                document.getElementById('apis-content').classList.add('active');
            }

            // Render initial content
            render(); // Routes content
            renderSidebar();

            // If APIs tab is active, render that too
            if (currentTab === 'apis') {
                renderApiSections();
                updateAuthStatus();
            }

            // Set up observers for routes tab
            S.forEach(s => {
                const sec = document.getElementById(s.id);
                if (sec) observer.observe(sec);
            });
        });
