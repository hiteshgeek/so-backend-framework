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

        const el = id => document.getElementById(id);

        function render() {
            const toc = el('tocList');
            let t = '';
            S.forEach(s => {
                t += '<li><a href="#' + s.id + '" onclick="expand(\'' + s.id + '\')"><span class="mdi mdi-' + s.icon + '"></span> ' + s.title + '</a></li>';
            });
            toc.innerHTML = t;

            const wrap = el('sections');
            let h = '';
            S.forEach((sec, si) => {
                h += '<div class="section" id="' + sec.id + '">';
                h += '<div class="section-title" onclick="toggleSec(this)"><span class="mdi mdi-' + sec.icon + '"></span> ' + sec.title + '<span class="mdi mdi-chevron-down arrow"></span></div>';
                h += '<p class="section-desc">' + sec.desc + '</p>';
                if (sec.code) {
                    h += '<div class="section-code"><div class="section-code-header"><span class="section-code-lang">PHP</span></div><div class="section-code-body">' + esc(sec.code) + '</div></div>';
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
        render();
        S.forEach(s => {
            const sec = document.getElementById(s.id);
            if (sec) observer.observe(sec);
        });
