<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Route Tester - SO Framework Documentation</title>
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--primary:#2563eb;--primary-dark:#1d4ed8;--primary-light:#3b82f6;--primary-bg:#eff6ff;--success:#10b981;--success-bg:#d1fae5;--surface:#ffffff;--background:#f8fafc;--text:#1e293b;--text-secondary:#64748b;--text-muted:#94a3b8;--border:#e2e8f0;--border-light:#f1f5f9;--code-bg:#0f172a;--code-text:#e2e8f0;--shadow-sm:0 1px 2px rgba(0,0,0,0.05);--shadow:0 4px 6px -1px rgba(0,0,0,0.1);--radius:8px;--radius-sm:4px}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;font-size:15px;line-height:1.6;color:var(--text);background:var(--background);-webkit-font-smoothing:antialiased;padding-bottom:60px}
.docs-header{background:var(--primary);color:#fff;height:64px;padding:0 24px;display:flex;align-items:center;position:sticky;top:0;z-index:100;box-shadow:var(--shadow)}
.docs-header-inner{max-width:1200px;margin:0 auto;width:100%;display:flex;justify-content:space-between;align-items:center}
.docs-header h1{font-size:18px;font-weight:600;display:flex;align-items:center;gap:10px}
.docs-header h1 .mdi{font-size:24px}
.docs-header .subtitle{font-size:14px;opacity:.8;margin-left:16px;font-weight:400}
.docs-nav-link{color:#fff;text-decoration:none;padding:8px 16px;background:rgba(255,255,255,.15);border-radius:var(--radius);font-size:14px;font-weight:500;display:flex;align-items:center;gap:6px;transition:background .2s}
.docs-nav-link:hover{background:rgba(255,255,255,.25)}
.docs-layout{max-width:1200px;margin:0 auto;padding:24px;display:grid;grid-template-columns:240px 1fr;gap:24px}
.docs-sidebar{position:sticky;top:88px;height:fit-content;max-height:calc(100vh - 112px);overflow-y:auto;background:var(--surface);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--border)}
.docs-sidebar::-webkit-scrollbar{width:6px}
.docs-sidebar::-webkit-scrollbar-track{background:transparent}
.docs-sidebar::-webkit-scrollbar-thumb{background:var(--border);border-radius:3px}
.docs-sidebar h3{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);padding:12px 14px 10px;display:flex;align-items:center;gap:6px;border-bottom:1px solid var(--border-light);background:linear-gradient(180deg,var(--background) 0%,var(--surface) 100%)}
.docs-sidebar h3 .mdi{font-size:14px;color:var(--primary)}
.docs-sidebar ul{list-style:none;padding:4px 0}
.docs-sidebar a{display:flex;align-items:center;gap:6px;padding:5px 14px;color:var(--text);text-decoration:none;font-size:13px;font-weight:500;line-height:1.4;border-left:3px solid transparent;transition:all .2s}
.docs-sidebar a .mdi{font-size:16px;color:var(--primary-light);flex-shrink:0;opacity:.85}
.docs-sidebar a:hover{background:linear-gradient(90deg,var(--primary-bg),transparent);color:var(--primary-dark);border-left-color:var(--primary-light)}
.docs-sidebar a.active{background:linear-gradient(90deg,var(--primary-bg),rgba(37,99,235,.05));color:var(--primary-dark);border-left-color:var(--primary);font-weight:600}
.docs-content{background:var(--surface);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--border);padding:32px 48px;min-width:0}
.page-title{font-size:28px;font-weight:700;margin-bottom:8px;display:flex;align-items:center;gap:12px;padding-bottom:16px;border-bottom:2px solid var(--primary)}
.page-title .mdi{font-size:32px;color:var(--primary)}
.page-subtitle{color:var(--text-secondary);font-size:15px;margin-bottom:32px;line-height:1.7}
.section{margin-bottom:32px;scroll-margin-top:88px}
.section-title{font-size:20px;font-weight:600;color:var(--primary-dark);margin-bottom:6px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none}
.section-title .mdi{font-size:22px}
.section-title .arrow{font-size:16px;color:var(--text-muted);margin-left:auto;transition:transform .2s}
.section.collapsed .arrow{transform:rotate(-90deg)}
.section-desc{color:var(--text-secondary);font-size:14px;margin-bottom:16px;line-height:1.6}
.section-code{margin-bottom:16px;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm)}
.section-code-header{background:#1e293b;padding:6px 16px;display:flex;justify-content:space-between;align-items:center}
.section-code-lang{font-size:11px;font-weight:500;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em}
.section-code-body{background:var(--code-bg);padding:16px 20px;overflow-x:auto;font-family:'JetBrains Mono',monospace;font-size:13px;line-height:1.7;color:var(--code-text);white-space:pre-wrap}
.route-list{display:flex;flex-direction:column;gap:8px}
.section.collapsed .route-list,.section.collapsed .section-code,.section.collapsed .section-desc{display:none}
.route-card{border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:all .15s}
.route-card:hover{border-color:var(--primary-light);box-shadow:var(--shadow)}
.route-card.active{border-color:var(--primary);box-shadow:0 0 0 1px var(--primary),var(--shadow)}
.btn-test{padding:4px 14px;border-radius:var(--radius-sm);border:1px solid var(--primary);background:var(--primary-bg);color:var(--primary);font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .15s;display:flex;align-items:center;gap:4px;margin-left:auto;flex-shrink:0}
.btn-test:hover{background:var(--primary);color:#fff}
.btn-test .mdi{font-size:14px}
.route-header{display:flex;align-items:center;gap:12px;padding:10px 16px;background:var(--background)}
.api-method{display:inline-block;padding:3px 10px;border-radius:var(--radius-sm);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.03em;font-family:'JetBrains Mono',monospace;flex-shrink:0;min-width:60px;text-align:center}
.api-method-get{background:#d1fae5;color:#065f46}
.api-method-post{background:#dbeafe;color:#1e40af}
.api-method-put{background:#fef3c7;color:#92400e}
.api-method-patch{background:#e0e7ff;color:#3730a3}
.api-method-delete{background:#fee2e2;color:#991b1b}
.api-method-any{background:#f3e8ff;color:#6b21a8}
.api-path{font-family:'JetBrains Mono',monospace;font-size:13px;color:var(--text);word-break:break-all}
.api-path-param{color:var(--primary);font-weight:600}
.route-tag{font-size:10px;font-weight:600;background:var(--primary-bg);color:var(--primary);padding:2px 8px;border-radius:10px;text-transform:uppercase;letter-spacing:.03em;margin-left:auto;flex-shrink:0}
.route-body{padding:10px 16px;border-top:1px solid var(--border-light)}
.route-desc{font-size:14px;color:var(--text-secondary);line-height:1.5;margin-bottom:4px}
.route-usage{font-size:13px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;line-height:1.5}
.response-wrap{position:fixed;bottom:0;left:0;right:0;background:var(--surface);border-top:2px solid var(--primary);box-shadow:0 -4px 12px rgba(0,0,0,.1);transition:transform .3s;transform:translateY(100%);z-index:100;max-height:50vh;display:flex;flex-direction:column}
.response-wrap.show{transform:translateY(0)}
.res-bar{display:flex;align-items:center;gap:12px;padding:10px 20px;background:var(--background);border-bottom:1px solid var(--border);flex-shrink:0}
.res-bar .res-url{font-family:'JetBrains Mono',monospace;font-size:13px;color:var(--text-secondary);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.res-bar .res-status{font-weight:700;font-size:12px;padding:3px 12px;border-radius:var(--radius-sm)}
.res-bar .res-status.s2xx{background:#d1fae5;color:#065f46}
.res-bar .res-status.s3xx{background:#fef3c7;color:#92400e}
.res-bar .res-status.s4xx{background:#fee2e2;color:#991b1b}
.res-bar .res-status.s5xx{background:#fce7f3;color:#9d174d}
.res-bar .res-time{color:var(--text-muted);font-size:13px}
.res-bar .close-btn{background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:20px;padding:4px 8px;border-radius:var(--radius-sm)}
.res-bar .close-btn:hover{background:var(--border-light);color:var(--text)}
.res-body{overflow:auto;padding:16px 20px;flex:1}
.res-body pre{font-family:'JetBrains Mono',monospace;font-size:13px;color:var(--code-text);background:var(--code-bg);padding:16px 20px;border-radius:var(--radius);white-space:pre-wrap;word-break:break-word}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:200;align-items:center;justify-content:center}
.modal-overlay.show{display:flex}
.modal{background:var(--surface);border:1px solid var(--border);border-radius:12px;width:520px;max-width:90vw;max-height:80vh;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,.2)}
.modal-head{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
.modal-head h3{font-size:16px;font-weight:600;color:var(--text)}
.modal-body{padding:20px;overflow:auto;flex:1}
.modal-body label{display:block;color:var(--text-secondary);font-size:13px;font-weight:500;margin-bottom:6px}
.modal-body input{width:100%;padding:9px 12px;background:var(--background);border:1px solid var(--border);border-radius:6px;color:var(--text);font-family:'JetBrains Mono',monospace;font-size:13px;margin-bottom:16px}
.modal-body input:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.modal-body textarea{width:100%;height:180px;padding:12px;background:var(--code-bg);border:1px solid #334155;border-radius:6px;color:var(--code-text);font-family:'JetBrains Mono',monospace;font-size:13px;resize:vertical;line-height:1.6}
.modal-body textarea:focus{outline:none;border-color:var(--primary)}
.modal-foot{padding:12px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:8px}
.btn{padding:8px 20px;border-radius:6px;border:none;font-size:14px;cursor:pointer;font-weight:600;font-family:inherit;transition:all .15s}
.btn-send{background:var(--primary);color:#fff}
.btn-send:hover{background:var(--primary-dark)}
.btn-cancel{background:var(--background);color:var(--text-secondary);border:1px solid var(--border)}
.btn-cancel:hover{background:var(--border-light)}
@media(max-width:900px){.docs-layout{grid-template-columns:1fr}.docs-sidebar{position:relative;top:0;max-height:200px;order:-1}.docs-content{padding:24px}}
@media(max-width:600px){.docs-header h1 .subtitle{display:none}.docs-content{padding:16px}.route-header{flex-wrap:wrap}}
</style>
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <h1>
            <span class="mdi mdi-api"></span>
            Route Tester
            <span class="subtitle">Interactive API Testing</span>
        </h1>
        <a href="/docs" class="docs-nav-link">
            <span class="mdi mdi-arrow-left"></span> Back to Docs
        </a>
    </div>
</header>

<main class="docs-layout">

<nav class="docs-sidebar">
    <h3><span class="mdi mdi-format-list-bulleted"></span> Sections</h3>
    <ul id="tocList"></ul>
</nav>

<article class="docs-content">
    <div class="page-title">
        <span class="mdi mdi-routes"></span>
        Demo Route Tester
    </div>
    <p class="page-subtitle">
        Click any route to send a request and view the response. Routes with POST, PUT, or PATCH methods
        open an editor for the request body. All 13 sections below demonstrate different features of the Router.
    </p>
    <div id="sections"></div>
</article>

</main>

<div class="response-wrap" id="resPanel">
    <div class="res-bar">
        <span class="api-method" id="resMethod"></span>
        <span class="res-url" id="resUrl"></span>
        <span class="res-status" id="resStatus"></span>
        <span class="res-time" id="resTime"></span>
        <button class="close-btn" onclick="closeRes()"><span class="mdi mdi-close"></span></button>
    </div>
    <div class="res-body"><pre id="resBody"></pre></div>
</div>

<div class="modal-overlay" id="modal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="modalTitle">Send Request</h3>
            <button class="close-btn" onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:20px;padding:4px"><span class="mdi mdi-close"></span></button>
        </div>
        <div class="modal-body">
            <label>URL</label>
            <input type="text" id="modalUrl">
            <label>Request Body (JSON)</label>
            <textarea id="modalBody">{}</textarea>
        </div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
            <button class="btn btn-send" id="modalSend"><span class="mdi mdi-send" style="margin-right:4px"></span>Send</button>
        </div>
    </div>
</div>

<script>
const S=[
{id:'http-methods',icon:'swap-horizontal',title:'Basic HTTP Methods',desc:'Register routes for each HTTP method using Router::get(), post(), put(), patch(), delete(), any().',code:"Router::get('/ping', function (Request $request) { ... });\nRouter::post('/echo', function (Request $request) { ... });\nRouter::any('/any-method', function (Request $request) { ... });",routes:[
{m:'GET',url:'/api/demo/ping',d:'Returns pong with timestamp, method, and client IP address',u:"Router::get($uri, Closure) \u2014 register a GET route with a closure handler"},
{m:'POST',url:'/api/demo/echo',d:'Echoes back the posted JSON body along with content type',u:"Router::post($uri, Closure) \u2014 $request->all() returns all posted data",body:'{"message":"Hello from route tester!"}'},
{m:'PUT',url:'/api/demo/method-test',d:'PUT method \u2014 conventionally used for full resource replacement',u:"Router::put($uri, Closure) \u2014 register a PUT route for full resource updates",body:'{"key":"value"}'},
{m:'PATCH',url:'/api/demo/method-test',d:'PATCH method \u2014 conventionally used for partial resource updates',u:"Router::patch($uri, Closure) \u2014 register a PATCH route for partial updates",body:'{"key":"patched"}'},
{m:'DELETE',url:'/api/demo/method-test',d:'DELETE method \u2014 conventionally used for resource deletion',u:"Router::delete($uri, Closure) \u2014 register a DELETE route"},
{m:'GET',url:'/api/demo/any-method',d:'Accepts any HTTP method (GET, POST, PUT, PATCH, DELETE)',u:"Router::any($uri, Closure) \u2014 matches ALL HTTP methods on a single URI"}
]},
{id:'param-constraints',icon:'regex',title:'Route Parameter Constraints',desc:'Restrict route parameters to specific patterns using ->whereNumber(), ->whereSlug(), ->whereAlpha(), ->whereIn(), and custom regex.',code:"Router::get('/by-id/{id}', ...)->whereNumber('id');\nRouter::get('/status/{status}', ...)->whereIn('status', ['active','inactive','draft']);\nRouter::get('/year/{year}', ...)->where('year', '[0-9]{4}');",routes:[
{m:'GET',url:'/api/demo/lookup/by-id/1',d:'Only matches numeric IDs \u2014 try /by-id/abc to see it fail',u:"->whereNumber('id') constrains {id} to [0-9]+ regex",tag:'whereNumber'},
{m:'GET',url:'/api/demo/lookup/by-slug/laptop-pro-15',d:'Matches slugs: letters, numbers, and dashes',u:"->whereSlug('slug') constrains {slug} to [a-zA-Z0-9-]+ pattern",tag:'whereSlug'},
{m:'GET',url:'/api/demo/lookup/by-sku/LP15001',d:'Matches alphanumeric only (no dashes or special characters)',u:"->whereAlphaNumeric('sku') constrains {sku} to [a-zA-Z0-9]+",tag:'whereAlphaNum'},
{m:'GET',url:'/api/demo/lookup/category/electronics',d:'Matches letters only (no numbers allowed)',u:"->whereAlpha('name') constrains {name} to [a-zA-Z]+",tag:'whereAlpha'},
{m:'GET',url:'/api/demo/lookup/uuid/550e8400-e29b-41d4-a716-446655440000',d:'Validates full UUID format',u:"->whereUuid('uuid') constrains {uuid} to standard UUID regex",tag:'whereUuid'},
{m:'GET',url:'/api/demo/lookup/status/active',d:'Only allows: active, inactive, or draft',u:"->whereIn('status', ['active','inactive','draft']) restricts to a fixed list",tag:'whereIn'},
{m:'GET',url:'/api/demo/lookup/year/2026',d:'Only matches exactly 4 digits',u:"->where('year', '[0-9]{4}') \u2014 custom regex constraint",tag:'where'},
{m:'GET',url:'/api/demo/lookup/catalog/electronics/2',d:'Combines alphabetic category with numeric page parameter',u:"->whereAlpha('category')->whereNumber('page') \u2014 chain multiple constraints",tag:'multi'}
]},
{id:'model-scopes',icon:'filter-variant',title:'Model Scoped Queries',desc:'Model scopes like scopeActive, scopeByCategory, and scopePriceBetween filter queries using Product::active()->get().',code:"// In Product model:\npublic function scopeActive($query) {\n    return $query->where('status', '=', 'active');\n}\n\n// Usage:\nProduct::active()->get();\nProduct::priceBetween(100, 500)->get();",routes:[
{m:'GET',url:'/api/demo/products/active',d:'Calls Product::active()->get() to fetch only active products',u:"scopeActive adds WHERE status = 'active' \u2014 defined in model, called statically"},
{m:'GET',url:'/api/demo/products/category/5',d:'Calls Product::byCategory(5)->get() to filter by category',u:"scopeByCategory($id) adds WHERE category_id = ? \u2014 scope with parameter"},
{m:'GET',url:'/api/demo/products/price/100/500',d:'Calls Product::priceBetween(100, 500)->get() for price range',u:"scopePriceBetween($min, $max) adds WHERE price >= ? AND price <= ?"}
]},
{id:'api-resource',icon:'database',title:'Resource Routes (apiResource)',desc:'Router::apiResource() auto-generates 5 RESTful CRUD routes mapped to controller methods: index, store, show, update, destroy.',code:"Router::apiResource('products', DemoProductController::class);\n\n// Generates:\n//   GET    /products        \u2192 index()      POST   /products      \u2192 store()\n//   GET    /products/{id}   \u2192 show($id)    PUT    /products/{id} \u2192 update($id)\n//   DELETE /products/{id}   \u2192 destroy($id)",routes:[
{m:'GET',url:'/api/demo/products',d:'index() \u2014 paginated list with filtering, sorting, and search',u:"Query params: ?status=active&category_id=5&search=laptop&sort=price&order=DESC&page=1&per_page=10"},
{m:'POST',url:'/api/demo/products',d:'store() \u2014 creates a new product with validation',u:"Validates: category_id (required|integer), name (required), slug, sku, price (numeric), stock, status",body:'{"category_id":1,"name":"Test Product","slug":"test-product","sku":"TP001","price":29.99,"stock":10,"status":"draft","description":"Created via route tester"}'},
{m:'GET',url:'/api/demo/products/1',d:'show($id) \u2014 returns product with category, reviews, and tags loaded',u:"Loads related data via Category::find(), Review::where(), and JOIN on product_tags pivot table"},
{m:'PUT',url:'/api/demo/products/1',d:'update($id) \u2014 partial field update, only modifies fields in request body',u:"Uses Product::find($id) then sets each field and calls $product->save()",body:'{"name":"Updated Product Name","price":39.99}'},
{m:'DELETE',url:'/api/demo/products/15',d:'destroy($id) \u2014 soft deletes via SoftDeletes trait (sets deleted_at)',u:"Calls $product->delete() which sets deleted_at timestamp. Use admin/restore to undo"}
]},
{id:'nested-resources',icon:'file-tree',title:'Nested Resource Routes',desc:'Reviews nested under products: /products/{productId}/reviews/{id}. All queries are scoped to the parent product.',code:"Router::get('/products/{productId}/reviews', [DemoReviewController::class, 'index'])\n    ->whereNumber('productId')->name('demo.products.reviews.index');",routes:[
{m:'GET',url:'/api/demo/products/1/reviews',d:'List all reviews for product #1',u:"Scoped query: WHERE product_id = $productId. Supports ?approved=1&sort=rating&order=DESC"},
{m:'POST',url:'/api/demo/products/1/reviews',d:'Create a new review under product #1',u:"Auto-sets product_id from URL. Validates: user_id, rating (1-5), title (min:3), comment (min:10)",body:'{"user_id":1,"rating":5,"title":"Great product!","comment":"This is an amazing product, highly recommend it."}'},
{m:'GET',url:'/api/demo/products/1/reviews/1',d:'Show review #1 for product #1',u:"Ensures review belongs to product: WHERE id = ? AND product_id = ?"},
{m:'PUT',url:'/api/demo/products/1/reviews/1',d:'Update review #1',u:"Can update: rating, title, comment, is_approved. Scoped to product",body:'{"rating":4,"title":"Updated review"}'},
{m:'DELETE',url:'/api/demo/products/1/reviews/12',d:'Delete review #12 from product #1',u:"Hard delete (reviews don\u2019t use SoftDeletes). Verifies review belongs to product"}
]},
{id:'middleware-groups',icon:'shield-lock',title:'Route Groups with Middleware',desc:'Router::group() with prefix and middleware array. Admin routes are protected by AuthMiddleware.',code:"Router::group(['prefix' => 'api/demo/admin', 'middleware' => [AuthMiddleware::class]], function () {\n    Router::get('/stats', [DemoProductController::class, 'stats']);\n    Router::patch('/products/{id}/restore', [...]);\n});",routes:[
{m:'GET',url:'/api/demo/admin/stats',d:'Returns total, active, and trashed product counts',u:"AuthMiddleware runs before handler. Returns 401 if not authenticated",tag:'Auth'},
{m:'GET',url:'/api/demo/admin/products',d:'Shows all products including soft-deleted ones',u:"Uses Product::withTrashed() to include deleted_at != NULL records",tag:'Auth'},
{m:'DELETE',url:'/api/demo/admin/products/15/force',d:'Permanently removes product from database',u:"Calls $product->forceDelete() \u2014 runs DELETE FROM instead of setting deleted_at",tag:'Auth'},
{m:'PATCH',url:'/api/demo/admin/products/15/restore',d:'Restores a soft-deleted product',u:"Calls $product->restore() \u2014 sets deleted_at = NULL. Only works on trashed records",tag:'Auth'}
]},
{id:'named-routes',icon:'tag-text',title:'Named Routes & URL Generation',desc:'Chain ->name() on any route. Use Router::has() to check existence and Router::url() to generate URLs.',code:"Router::get('/ping', ...)->name('demo.ping');\n\nRouter::has('demo.ping');            // true\n$router->url('demo.ping');           // full URL\n$router->url('demo.products.show', ['id' => 5]);  // with parameters",routes:[
{m:'GET',url:'/api/demo/routes',d:'Lists all 32 named demo routes with methods and URIs',u:"Iterates Router::getNamedRoutes(), filters by 'demo.' prefix"},
{m:'GET',url:'/api/demo/has-route/demo.ping',d:'Checks if a named route exists and returns its generated URL',u:"Router::has($name) returns bool. app(Router::class)->url($name) generates full URL"}
]},
{id:'redirects',icon:'redo',title:'Redirect Routes',desc:'Router::redirect() for 302 temporary and Router::permanentRedirect() for 301 permanent redirects.',code:"Router::permanentRedirect('/old-products', '/api/demo/products');  // 301\nRouter::redirect('/legacy', '/api/demo/ping');                      // 302",routes:[
{m:'GET',url:'/api/demo/old-products',d:'Permanent redirect (301) to /api/demo/products \u2014 browser follows',u:"Router::permanentRedirect() sends 301 + Location header. Browser caches permanently",tag:'301'},
{m:'GET',url:'/api/demo/legacy',d:'Temporary redirect (302) to /api/demo/ping',u:"Router::redirect() sends 302 + Location header. Browser does not cache",tag:'302'}
]},
{id:'match',icon:'call-split',title:'Multiple HTTP Methods (match)',desc:'Router::match() registers a single handler for multiple HTTP methods.',code:"Router::match(['GET', 'POST'], '/api/demo/search', [DemoProductController::class, 'search']);",routes:[
{m:'GET',url:'/api/demo/search?q=laptop',d:'Search via GET with ?q= query parameter',u:"Searches product name, SKU, and description with LIKE"},
{m:'POST',url:'/api/demo/search',d:'Search via POST with JSON body',u:'Same handler, different input method: {"q":"term"}',body:'{"q":"phone"}'}
]},
{id:'rate-limit',icon:'speedometer',title:'Rate-Limited Routes',desc:'ThrottleMiddleware with parameters passed via "ClassName:param1,param2" syntax.',code:"Router::group(['middleware' => [ThrottleMiddleware::class . ':10,1']], function () {\n    Router::post('/contact', function ($request) { ... });\n});\n// ThrottleMiddleware receives: handle($request, $next, $maxAttempts=10, $decayMinutes=1)",routes:[
{m:'POST',url:'/api/demo/contact',d:'Max 10 requests per minute, then returns 429 Too Many Requests',u:"ThrottleMiddleware:10,1 \u2014 10 max attempts, 1 minute decay window",body:'{"name":"John","email":"john@test.com","message":"Hello!"}',tag:'Throttle'}
]},
{id:'logging',icon:'math-log',title:'Logging Middleware',desc:'Routes grouped with LogRequestMiddleware \u2014 logs every request before it reaches the handler.',code:"Router::group(['prefix' => 'api/demo/logged', 'middleware' => [LogRequestMiddleware::class]], function () {\n    Router::get('/action', function ($request) { ... });\n});",routes:[
{m:'GET',url:'/api/demo/logged/action',d:'Request method, URI, and IP are logged before the handler runs',u:"LogRequestMiddleware calls $next($request) after logging. Demonstrates middleware pipeline",tag:'LogRequest'}
]},
{id:'route-info',icon:'information',title:'Route Information & Debugging',desc:'Introspect the active route at runtime using Router::currentRouteName() and Router::currentRouteAction().',code:"Router::currentRouteName();     // 'demo.currentRoute'\nRouter::currentRouteAction();   // 'Closure' or 'Controller@method'\nRouter::current();              // Route object",routes:[
{m:'GET',url:'/api/demo/current-route',d:'Returns route name, action, method, URI, IP, user-agent, and request detection flags',u:"$request->expectsJson() checks Accept header. $request->ajax() checks X-Requested-With"}
]},
{id:'fallback',icon:'alert-circle',title:'Fallback Route',desc:'Router::fallback() catches all unmatched routes \u2014 registered last, acts as a custom 404 handler.',code:"Router::fallback(function (Request $request) {\n    return JsonResponse::error('Route not found', 404, [\n        'help_url' => '/api/demo/routes'\n    ]);\n});",routes:[
{m:'GET',url:'/api/demo/this-does-not-exist',d:'Returns 404 JSON with available route count and help URL',u:"Fallback must be registered after all other routes. Matches any method and any unmatched URI"}
]}
];

const el=id=>document.getElementById(id);

function render(){
const toc=el('tocList');let t='';
S.forEach(s=>{t+='<li><a href="#'+s.id+'" onclick="expand(\''+s.id+'\')"><span class="mdi mdi-'+s.icon+'"></span> '+s.title+'</a></li>';});
toc.innerHTML=t;

const wrap=el('sections');let h='';
S.forEach((sec,si)=>{
h+='<div class="section" id="'+sec.id+'">';
h+='<div class="section-title" onclick="toggleSec(this)"><span class="mdi mdi-'+sec.icon+'"></span> '+sec.title+'<span class="mdi mdi-chevron-down arrow"></span></div>';
h+='<p class="section-desc">'+sec.desc+'</p>';
if(sec.code){h+='<div class="section-code"><div class="section-code-header"><span class="section-code-lang">PHP</span></div><div class="section-code-body">'+esc(sec.code)+'</div></div>';}
h+='<div class="route-list">';
sec.routes.forEach((r,ri)=>{
const mc=r.m.toLowerCase();
const uh=esc(r.url).replace(/\{([^}]+)\}/g,'<span class="api-path-param">{$1}</span>');
const tg=r.tag?'<span class="route-tag">'+r.tag+'</span>':'';
h+='<div class="route-card">';
h+='<div class="route-header"><span class="api-method api-method-'+mc+'">'+r.m+'</span><span class="api-path">'+uh+'</span>'+tg+'<button class="btn-test" onclick="fire('+si+','+ri+')"><span class="mdi mdi-play"></span> Test</button></div>';
h+='<div class="route-body"><div class="route-desc">'+r.d+'</div>';
if(r.u)h+='<div class="route-usage">'+r.u+'</div>';
h+='</div></div>';
});
h+='</div></div>';
});
wrap.innerHTML=h;
}

function esc(s){const d=document.createElement('div');d.textContent=s;return d.innerHTML;}
function toggleSec(el){el.closest('.section').classList.toggle('collapsed');}
function expand(id){const s=document.getElementById(id);if(s)s.classList.remove('collapsed');}

function fire(si,ri){
const r=S[si].routes[ri];const m=r.m==='ANY'?'GET':r.m;
if(['POST','PUT','PATCH'].includes(m)){openModal(m,r.url,r.body||'{}');return;}
sendRequest(m,r.url);
}

function openModal(method,url,body){
el('modalTitle').textContent=method+'  '+url;
el('modalUrl').value=url;
try{el('modalBody').value=JSON.stringify(JSON.parse(body),null,2);}catch(e){el('modalBody').value=body;}
el('modal').classList.add('show');
el('modalSend').onclick=()=>{closeModal();sendRequest(method,el('modalUrl').value,el('modalBody').value);};
}
function closeModal(){el('modal').classList.remove('show');}

async function sendRequest(method,url,body){
const m=el('resMethod');m.textContent=method;m.className='api-method api-method-'+method.toLowerCase();
el('resUrl').textContent=url;el('resStatus').textContent='...';el('resStatus').className='res-status';
el('resTime').textContent='';el('resBody').textContent='Loading...';el('resPanel').classList.add('show');
const opts={method,headers:{'Accept':'application/json'}};
if(body&&!['GET','HEAD','DELETE'].includes(method)){opts.headers['Content-Type']='application/json';opts.body=body;}
const t0=performance.now();
try{
const res=await fetch(url,opts);const ms=Math.round(performance.now()-t0);const text=await res.text();
el('resStatus').textContent=res.status+' '+res.statusText;
if(res.status<300)el('resStatus').className='res-status s2xx';
else if(res.status<400)el('resStatus').className='res-status s3xx';
else if(res.status<500)el('resStatus').className='res-status s4xx';
else el('resStatus').className='res-status s5xx';
el('resTime').textContent=ms+'ms';
try{el('resBody').textContent=JSON.stringify(JSON.parse(text),null,2);}catch(e){el('resBody').textContent=text||'(empty response)';}
}catch(err){el('resStatus').textContent='Error';el('resStatus').className='res-status s5xx';el('resBody').textContent=err.message;}
}

function closeRes(){el('resPanel').classList.remove('show');}

const observer=new IntersectionObserver(entries=>{
entries.forEach(e=>{if(e.isIntersecting){
document.querySelectorAll('.docs-sidebar a').forEach(a=>a.classList.remove('active'));
const link=document.querySelector('.docs-sidebar a[href="#'+e.target.id+'"]');
if(link)link.classList.add('active');
}});
},{rootMargin:'-80px 0px -60% 0px'});

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeRes();closeModal();}});
render();
S.forEach(s=>{const sec=document.getElementById(s.id);if(sec)observer.observe(sec);});
</script>
</body>
</html>
