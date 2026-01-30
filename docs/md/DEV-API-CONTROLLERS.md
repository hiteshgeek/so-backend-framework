# Building API Controllers

This guide walks through building API controllers in the SO Backend Framework. Every API controller action returns a `JsonResponse`, uses the `Request` object to read input, and leverages the query builder for filtering, sorting, and pagination.

## Table of Contents

1. [Overview](#overview)
2. [Creating an API Controller](#creating-an-api-controller)
3. [Success Responses](#success-responses)
4. [Error Responses](#error-responses)
5. [Filtering & Search](#filtering--search)
6. [Sorting](#sorting)
7. [Pagination](#pagination)
8. [Complete Example](#complete-example)

---

## Overview

API controllers live under `app/Controllers/Api/` and are organized by version or feature domain. Each controller method receives a `Core\Http\Request` and returns a `Core\Http\JsonResponse`. The framework automatically sets the `Content-Type: application/json` header and encodes the payload for you.

### Key Classes

| Class | Namespace | Purpose |
|-------|-----------|---------|
| `Request` | `Core\Http\Request` | Read query params, JSON body, headers, bearer tokens |
| `JsonResponse` | `Core\Http\JsonResponse` | Build structured JSON responses with status codes |
| `Validator` | `Core\Validation\Validator` | Validate incoming data against rules |
| `Model` | `Core\Model\Model` | Base model with query builder access |
| `QueryBuilder` | `Core\Database\QueryBuilder` | Fluent SQL builder with `where`, `orderBy`, `paginate` |

### Standard JSON Envelope

All responses follow a consistent envelope:

```
Success:  {"success": true,  "message": "...", "data": {...}}
Error:    {"success": false, "message": "...", "errors": {...}}
```

---

## Creating an API Controller

Place your controller under the `App\Controllers\Api` namespace. Each public method accepts a `Request` and returns a `JsonResponse`.

### Basic Structure

```php
<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\Product;

class ProductController
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::all();

        return JsonResponse::success(
            array_map(fn($p) => $p->toArray(), $products),
            'Products retrieved'
        );
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        return JsonResponse::success($product->toArray(), 'Product details');
    }
}
```

### Registering Routes

Define the routes in `routes/api/` to point at your controller:

```php
<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\ProductController;

Router::group(['prefix' => 'api/v1'], function () {
    Router::get('/products',      [ProductController::class, 'index']);
    Router::post('/products',     [ProductController::class, 'store']);
    Router::get('/products/{id}', [ProductController::class, 'show']);
    Router::put('/products/{id}', [ProductController::class, 'update']);
    Router::delete('/products/{id}', [ProductController::class, 'destroy']);
});
```

Or use `apiResource` to generate all five routes at once:

```php
Router::group(['prefix' => 'api/v1'], function () {
    Router::apiResource('products', ProductController::class);
});
```

---

## Success Responses

`JsonResponse` provides three static helpers for success cases.

### JsonResponse::success()

Returns a `200 OK` by default with the standard envelope.

```php
// Signature
JsonResponse::success(mixed $data, string $message = 'Success', int $code = 200): JsonResponse

// Usage
return JsonResponse::success($product->toArray(), 'Product retrieved');
```

Response body:

```json
{
    "success": true,
    "message": "Product retrieved",
    "data": {
        "name": "Widget",
        "price": 29.99
    }
}
```

You can pass any serialisable value as `$data` -- an associative array, a list of arrays, or `null`.

```php
// Returning a list
$users = User::all();
return JsonResponse::success(
    array_map(fn($u) => $u->toArray(), $users),
    'Users retrieved'
);
```

### JsonResponse::created()

A convenience wrapper around `success()` that sets the HTTP status to `201 Created`.

```php
// Signature
JsonResponse::created(mixed $data, string $message = 'Created'): JsonResponse

// Usage
$product = Product::create($request->only([
    'name', 'slug', 'sku', 'price', 'stock', 'status'
]));

return JsonResponse::created($product->toArray(), 'Product created');
```

Response (HTTP 201):

```json
{
    "success": true,
    "message": "Product created",
    "data": {
        "name": "Widget",
        "price": 29.99,
        "id": 42
    }
}
```

### JsonResponse::noContent()

Returns an empty `204 No Content` response. Useful after a successful deletion when there is nothing to return.

```php
// Signature
JsonResponse::noContent(): JsonResponse

// Usage
$product->delete();
return JsonResponse::noContent();
```

### Constructing a Custom Response

If you need a payload shape that does not fit the standard envelope, instantiate `JsonResponse` directly:

```php
return new JsonResponse([
    'status' => 'healthy',
    'uptime' => 99.97,
], 200);
```

---

## Error Responses

### JsonResponse::error()

Returns an error envelope with a message, HTTP status code, and an optional `errors` array (typically field-level validation errors).

```php
// Signature
JsonResponse::error(string $message, int $code = 400, array $errors = []): JsonResponse
```

### Common HTTP Status Codes

| Code | Constant Meaning | When to Use |
|------|------------------|-------------|
| 400 | Bad Request | Malformed or missing input |
| 401 | Unauthorized | No valid authentication token |
| 403 | Forbidden | Authenticated but not permitted |
| 404 | Not Found | Resource does not exist |
| 409 | Conflict | Duplicate or state conflict |
| 422 | Unprocessable Entity | Validation failure |
| 500 | Internal Server Error | Unexpected server-side failure |

### Validation Errors

Pair with `Validator` to return field-level errors under the `errors` key:

```php
use Core\Validation\Validator;

public function store(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'name'  => 'required|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return JsonResponse::error('Validation failed', 422, $validator->errors());
    }

    // proceed...
}
```

Response (HTTP 422):

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "email": ["The email must be a valid email address."]
    }
}
```

### Not Found

```php
$product = Product::find($id);

if (!$product) {
    return JsonResponse::error('Product not found', 404);
}
```

### Wrapping in Try/Catch

For operations that may throw, wrap the logic and return a `500` on failure:

```php
public function store(Request $request): JsonResponse
{
    try {
        $product = Product::create($request->only(['name', 'price']));
        return JsonResponse::created($product->toArray(), 'Product created');
    } catch (\Exception $e) {
        return JsonResponse::error('Failed to create product', 500);
    }
}
```

---

## Filtering & Search

Use `$request->input()` to read query parameters and conditionally append `where` clauses to the query builder.

### Basic Filtering

```php
public function index(Request $request): JsonResponse
{
    $query = Product::query();

    // Exact match: ?status=active
    if ($status = $request->input('status')) {
        $query->where('status', '=', $status);
    }

    // Foreign key: ?category_id=3
    if ($categoryId = $request->input('category_id')) {
        $query->where('category_id', '=', (int) $categoryId);
    }

    $products = $query->get();

    return JsonResponse::success($products, 'Products retrieved');
}
```

### Range Filtering

```php
// Price range: ?min_price=10&max_price=50
if ($minPrice = $request->input('min_price')) {
    $query->where('price', '>=', (float) $minPrice);
}
if ($maxPrice = $request->input('max_price')) {
    $query->where('price', '<=', (float) $maxPrice);
}
```

### Keyword Search with LIKE

```php
// Search: ?search=widget
if ($search = $request->input('search')) {
    $query->where('name', 'LIKE', "%{$search}%");
}
```

### Multi-Column Search

Use `orWhere` to search across several columns:

```php
if ($q = $request->input('q')) {
    $query->where('name', 'LIKE', "%{$q}%")
          ->orWhere('sku', 'LIKE', "%{$q}%")
          ->orWhere('description', 'LIKE', "%{$q}%");
}
```

### Additional Where Methods

The query builder supports several flavours of `where`:

```php
// IN clause: filter by multiple values
$query->whereIn('status', ['active', 'draft']);

// NOT IN clause
$query->whereNotIn('status', ['archived']);

// NULL checks
$query->whereNull('deleted_at');
$query->whereNotNull('published_at');

// BETWEEN
$query->whereBetween('price', 10.00, 99.99);

// Raw SQL (use sparingly)
$query->whereRaw('YEAR(created_at) = ?', [2026]);
```

---

## Sorting

Read sorting parameters from the request and validate them against an allow-list before passing to `orderBy`.

### Pattern

```php
// Read params with defaults: ?sort=price&order=desc
$sortBy    = $request->input('sort', 'id');
$sortOrder = strtoupper($request->input('order', 'ASC'));

// Validate direction
if (!in_array($sortOrder, ['ASC', 'DESC'])) {
    $sortOrder = 'ASC';
}

// Whitelist allowed columns to prevent SQL injection
$allowedSorts = ['id', 'name', 'price', 'stock', 'created_at'];

if (in_array($sortBy, $allowedSorts)) {
    $query->orderBy($sortBy, $sortOrder);
} else {
    $query->orderBy('id', 'ASC'); // safe fallback
}
```

### Why Whitelist?

Column names are interpolated directly into SQL. Accepting arbitrary user input for `ORDER BY` opens the door to SQL injection. Always compare against a known set of valid columns.

```php
// NEVER do this -- user input goes straight into SQL:
$query->orderBy($request->input('sort'), 'ASC');

// ALWAYS validate first:
$allowed = ['id', 'name', 'price', 'created_at'];
$sort = in_array($request->input('sort'), $allowed)
    ? $request->input('sort')
    : 'id';
$query->orderBy($sort, 'ASC');
```

---

## Pagination

The query builder provides `paginate()` and `simplePaginate()` for slicing result sets.

### paginate()

Returns the result page together with full pagination metadata.

```php
// Signature
$query->paginate(int $perPage = 15, int $page = 1): array
```

Reading parameters from the request:

```php
$page    = max(1, (int) $request->input('page', 1));
$perPage = min(50, max(1, (int) $request->input('per_page', 10)));

$results = $query->paginate($perPage, $page);

return JsonResponse::success($results, 'Products retrieved');
```

The returned array looks like:

```json
{
    "success": true,
    "message": "Products retrieved",
    "data": {
        "data": [
            {"id": 1, "name": "Widget A", "price": 9.99},
            {"id": 2, "name": "Widget B", "price": 14.99}
        ],
        "total": 87,
        "per_page": 10,
        "current_page": 1,
        "last_page": 9,
        "from": 1,
        "to": 10,
        "has_more": true
    }
}
```

| Field | Type | Description |
|-------|------|-------------|
| `data` | array | The records for the current page |
| `total` | int | Total number of matching records |
| `per_page` | int | Number of records requested per page |
| `current_page` | int | Current page number |
| `last_page` | int | Total number of pages |
| `from` | int | 1-based index of the first record on this page (0 if empty) |
| `to` | int | 1-based index of the last record on this page |
| `has_more` | bool | Whether there are more pages after this one |

### simplePaginate()

When you do not need the total count (which requires an extra `COUNT(*)` query), use `simplePaginate()`. It fetches one extra record to determine if there is a next page:

```php
$results = $query->simplePaginate($perPage, $page);
```

Returns:

```json
{
    "data": [ ... ],
    "per_page": 10,
    "current_page": 1,
    "has_more": true
}
```

### Capping per_page

Always clamp `per_page` to a sensible maximum so clients cannot request the entire table at once:

```php
$perPage = min(100, max(1, (int) $request->input('per_page', 15)));
```

---

## Complete Example

Below is a full `ProductController` that combines filtering, search, sorting, pagination, validation, and all five CRUD actions.

### The Model

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected static string $table = 'products';

    protected array $fillable = [
        'category_id', 'name', 'slug', 'sku',
        'price', 'stock', 'status', 'description',
    ];
}
```

### The Controller

```php
<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Validation\Validator;
use App\Models\Product;

class ProductController
{
    /**
     * GET /api/v1/products
     *
     * Query params:
     *   status      - exact match (active, inactive, draft)
     *   category_id - filter by category
     *   search      - LIKE search on name
     *   min_price   - minimum price
     *   max_price   - maximum price
     *   sort        - column to sort by (default: id)
     *   order       - ASC or DESC (default: ASC)
     *   page        - page number (default: 1)
     *   per_page    - results per page (default: 10, max: 50)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // ── Filters ─────────────────────────────────────
        if ($status = $request->input('status')) {
            $query->where('status', '=', $status);
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', '=', (int) $categoryId);
        }

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', (float) $minPrice);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // ── Sorting ─────────────────────────────────────
        $sortBy    = $request->input('sort', 'id');
        $sortOrder = strtoupper($request->input('order', 'ASC'));

        if (!in_array($sortOrder, ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }

        $allowedSorts = ['id', 'name', 'price', 'stock', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', 'ASC');
        }

        // ── Pagination ──────────────────────────────────
        $page    = max(1, (int) $request->input('page', 1));
        $perPage = min(50, max(1, (int) $request->input('per_page', 10)));

        $results = $query->paginate($perPage, $page);

        return JsonResponse::success($results, 'Products retrieved');
    }

    /**
     * GET /api/v1/products/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        return JsonResponse::success($product->toArray(), 'Product details');
    }

    /**
     * POST /api/v1/products
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'name'        => 'required|min:2|max:255',
            'slug'        => 'required|alpha_dash',
            'sku'         => 'required|alpha_num|max:50',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'status'      => 'required|in:active,inactive,draft',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        try {
            $product = Product::create($request->only([
                'category_id', 'name', 'slug', 'sku',
                'price', 'stock', 'status', 'description',
            ]));

            return JsonResponse::created($product->toArray(), 'Product created');
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to create product', 500);
        }
    }

    /**
     * PUT /api/v1/products/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name'   => 'min:2|max:255',
            'price'  => 'numeric',
            'stock'  => 'integer',
            'status' => 'in:active,inactive,draft',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        $fields = [
            'category_id', 'name', 'slug', 'sku',
            'price', 'stock', 'status', 'description',
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);
            if ($value !== null) {
                $product->$field = $value;
            }
        }

        $product->save();

        return JsonResponse::success($product->toArray(), 'Product updated');
    }

    /**
     * DELETE /api/v1/products/{id}
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $product->delete();

        return JsonResponse::noContent();
    }
}
```

### Registering the Routes

```php
<?php
// routes/api/products.php

use Core\Routing\Router;
use App\Controllers\Api\V1\ProductController;
use App\Middleware\JwtMiddleware;

Router::group([
    'prefix' => 'api/v1',
    'middleware' => [JwtMiddleware::class],
], function () {
    Router::get('/products',         [ProductController::class, 'index']);
    Router::get('/products/{id}',    [ProductController::class, 'show']);
    Router::post('/products',        [ProductController::class, 'store']);
    Router::put('/products/{id}',    [ProductController::class, 'update']);
    Router::delete('/products/{id}', [ProductController::class, 'destroy']);
});
```

### Sample Requests

**List with filters, sort, and pagination**

```
GET /api/v1/products?status=active&min_price=10&sort=price&order=desc&page=2&per_page=5
```

**Create a product**

```
POST /api/v1/products
Content-Type: application/json
Authorization: Bearer <token>

{
    "category_id": 3,
    "name": "Deluxe Widget",
    "slug": "deluxe-widget",
    "sku": "WDG100",
    "price": 49.99,
    "stock": 200,
    "status": "active",
    "description": "A premium widget."
}
```

**Update a product**

```
PUT /api/v1/products/42
Content-Type: application/json
Authorization: Bearer <token>

{
    "price": 39.99,
    "stock": 150
}
```

**Delete a product**

```
DELETE /api/v1/products/42
Authorization: Bearer <token>
```

---

## Quick Reference

| Task | Code |
|------|------|
| Success response | `JsonResponse::success($data, 'msg')` |
| Created response (201) | `JsonResponse::created($data, 'msg')` |
| No content response (204) | `JsonResponse::noContent()` |
| Error response | `JsonResponse::error('msg', 400, $errors)` |
| Custom JSON response | `new JsonResponse($array, $statusCode)` |
| Read query/body param | `$request->input('key', $default)` |
| Get all input | `$request->all()` |
| Get subset of input | `$request->only(['name', 'email'])` |
| Get bearer token | `$request->bearerToken()` |
| Parse JSON body | `$request->json()` |
| Check Accept header | `$request->expectsJson()` |
| Start a query | `Model::query()` |
| Where clause | `->where('col', '=', $val)` |
| LIKE search | `->where('name', 'LIKE', "%{$q}%")` |
| Sort results | `->orderBy('col', 'DESC')` |
| Paginate | `->paginate($perPage, $page)` |
| Simple paginate | `->simplePaginate($perPage, $page)` |
| Validate input | `Validator::make($data, $rules)` |
