<?php

namespace App\Controllers\Api\Demo;

use App\Models\Product;
use App\Models\Category;
use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Validation\Validator;

/**
 * Demo Product Controller
 *
 * Demonstrates full CRUD operations, filtering, scopes,
 * soft deletes, and relationship loading.
 */
class DemoProductController
{
    /**
     * List products with filtering, sorting, and pagination
     *
     * Query params: status, category_id, search, sort, order, page, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', '=', $status);
        }

        // Filter by category
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', '=', (int) $categoryId);
        }

        // Search by name or SKU
        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Price range
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Exclude soft-deleted by default
        $query->whereNull('deleted_at');

        // Sorting
        $sortBy = $request->input('sort', 'id');
        $sortOrder = strtoupper($request->input('order', 'ASC'));
        if (!in_array($sortOrder, ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        $allowedSorts = ['id', 'name', 'price', 'stock', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $page = max(1, (int) $request->input('page', 1));
        $perPage = min(50, max(1, (int) $request->input('per_page', 10)));

        $results = $query->paginate($perPage, $page);

        return JsonResponse::success($results, 'Products retrieved');
    }

    /**
     * Show a single product with relationships
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $data = $product->toArray();
        $data['id'] = $id;

        // Load category relationship
        $categoryId = $product->category_id;
        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $data['category'] = $category->toArray();
            }
        }

        // Load reviews using direct query (Model::find doesn't populate id)
        $data['reviews'] = \App\Models\Review::where('product_id', '=', $id)->get();

        // Load tags via pivot table
        $data['tags'] = app('db')->table('product_tags')
            ->select('tags.*')
            ->join('tags', 'product_tags.tag_id', '=', 'tags.id')
            ->where('product_tags.product_id', '=', $id)
            ->get();

        return JsonResponse::success($data, 'Product details');
    }

    /**
     * Create a new product
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'name' => 'required|min:2|max:255',
            'slug' => 'required|alpha_dash',
            'sku' => 'required|alpha_num|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        $product = Product::create($request->only([
            'category_id', 'name', 'slug', 'sku', 'price', 'stock', 'status', 'description'
        ]));

        return JsonResponse::created($product->toArray(), 'Product created');
    }

    /**
     * Update an existing product
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'min:2|max:255',
            'price' => 'numeric',
            'stock' => 'integer',
            'status' => 'in:active,inactive,draft',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        $fields = ['category_id', 'name', 'slug', 'sku', 'price', 'stock', 'status', 'description'];
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
     * Soft-delete a product
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $product->delete();

        return JsonResponse::success(['id' => $id], 'Product soft-deleted');
    }

    // =========================================
    // Admin Actions (soft-delete management)
    // =========================================

    /**
     * List all products including soft-deleted (admin)
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $products = Product::withTrashed();

        $data = array_map(fn($p) => array_merge($p->toArray(), [
            'is_trashed' => $p->trashed(),
        ]), $products);

        return JsonResponse::success($data, 'All products (including trashed)');
    }

    /**
     * Force-delete a product permanently (admin)
     */
    public function forceDestroy(Request $request, int $id): JsonResponse
    {
        // Look in trashed records
        $products = Product::withTrashed();
        $product = null;

        foreach ($products as $p) {
            if ($p->id == $id) {
                $product = $p;
                break;
            }
        }

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $product->forceDelete();

        return JsonResponse::success(['id' => $id], 'Product permanently deleted');
    }

    /**
     * Restore a soft-deleted product (admin)
     */
    public function restore(Request $request, int $id): JsonResponse
    {
        $trashed = Product::onlyTrashed();
        $product = null;

        foreach ($trashed as $p) {
            if ($p->id == $id) {
                $product = $p;
                break;
            }
        }

        if (!$product) {
            return JsonResponse::error('Trashed product not found', 404);
        }

        $product->restore();

        return JsonResponse::success($product->toArray(), 'Product restored');
    }

    // =========================================
    // Scoped Query Endpoints
    // =========================================

    /**
     * Get active products using scope
     */
    public function active(Request $request): JsonResponse
    {
        $products = Product::active()->get();

        return JsonResponse::success($products, 'Active products');
    }

    /**
     * Get products by category using scope
     */
    public function byCategory(Request $request, int $categoryId): JsonResponse
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return JsonResponse::error('Category not found', 404);
        }

        $products = Product::byCategory($categoryId)->get();

        return JsonResponse::success([
            'category' => $category->toArray(),
            'products' => $products,
        ], 'Products by category');
    }

    /**
     * Get products within a price range using scope
     */
    public function priceRange(Request $request, float $min, float $max): JsonResponse
    {
        $products = Product::priceBetween($min, $max)->get();

        return JsonResponse::success([
            'price_range' => ['min' => $min, 'max' => $max],
            'products' => $products,
        ], 'Products in price range');
    }

    /**
     * Search products across multiple fields
     */
    public function search(Request $request): JsonResponse
    {
        $q = $request->input('q', '');

        if (empty($q)) {
            return JsonResponse::error('Search query "q" is required', 400);
        }

        $products = Product::query()
            ->where('name', 'LIKE', "%{$q}%")
            ->orWhere('sku', 'LIKE', "%{$q}%")
            ->orWhere('description', 'LIKE', "%{$q}%")
            ->whereNull('deleted_at')
            ->orderBy('name', 'ASC')
            ->get();

        return JsonResponse::success([
            'query' => $q,
            'count' => count($products),
            'products' => $products,
        ], 'Search results');
    }

    /**
     * Get product stats (admin)
     */
    public function stats(Request $request): JsonResponse
    {
        $total = Product::query()->whereNull('deleted_at')->count();
        $active = Product::active()->count();
        $trashed = count(Product::onlyTrashed());

        return JsonResponse::success([
            'total_products' => $total,
            'active_products' => $active,
            'trashed_products' => $trashed,
        ], 'Product statistics');
    }
}
