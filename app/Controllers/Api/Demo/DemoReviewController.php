<?php

namespace App\Controllers\Api\Demo;

use App\Models\Review;
use App\Models\Product;
use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Validation\Validator;

/**
 * Demo Review Controller
 *
 * Demonstrates nested resource routing.
 * Reviews are always scoped to a parent product.
 */
class DemoReviewController
{
    /**
     * List reviews for a product
     */
    public function index(Request $request, int $productId): JsonResponse
    {
        $product = Product::find($productId);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $query = Review::query()->where('product_id', '=', $productId);

        // Filter approved only
        if ($request->input('approved') === '1') {
            $query->where('is_approved', '=', 1);
        }

        // Sort by rating
        if ($request->input('sort') === 'rating') {
            $order = strtoupper($request->input('order', 'DESC'));
            if (!in_array($order, ['ASC', 'DESC'])) {
                $order = 'DESC';
            }
            $query->orderBy('rating', $order);
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $reviews = $query->get();

        return JsonResponse::success([
            'product_id' => $productId,
            'product_name' => $product->name,
            'count' => count($reviews),
            'reviews' => $reviews,
        ], 'Product reviews');
    }

    /**
     * Create a review for a product
     */
    public function store(Request $request, int $productId): JsonResponse
    {
        $product = Product::find($productId);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'rating' => 'required|integer',
            'title' => 'required|min:3|max:255',
            'comment' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        $review = Review::create([
            'product_id' => $productId,
            'user_id' => (int) $request->input('user_id'),
            'rating' => (int) $request->input('rating'),
            'title' => $request->input('title'),
            'comment' => $request->input('comment'),
            'is_approved' => 0,
        ]);

        return JsonResponse::created($review->toArray(), 'Review submitted for approval');
    }

    /**
     * Show a single review for a product
     */
    public function show(Request $request, int $productId, int $id): JsonResponse
    {
        $review = Review::query()
            ->where('id', '=', $id)
            ->where('product_id', '=', $productId)
            ->first();

        if (!$review) {
            return JsonResponse::error('Review not found for this product', 404);
        }

        // Load user info
        $reviewModel = Review::find($id);
        $data = $review;
        $data['user'] = $reviewModel ? $reviewModel->user() : null;

        return JsonResponse::success($data, 'Review details');
    }

    /**
     * Update a review
     */
    public function update(Request $request, int $productId, int $id): JsonResponse
    {
        $review = Review::query()
            ->where('id', '=', $id)
            ->where('product_id', '=', $productId)
            ->first();

        if (!$review) {
            return JsonResponse::error('Review not found for this product', 404);
        }

        $reviewModel = Review::find($id);

        $fields = ['rating', 'title', 'comment', 'is_approved'];
        foreach ($fields as $field) {
            $value = $request->input($field);
            if ($value !== null) {
                $reviewModel->$field = $value;
            }
        }

        $reviewModel->save();

        return JsonResponse::success($reviewModel->toArray(), 'Review updated');
    }

    /**
     * Delete a review
     */
    public function destroy(Request $request, int $productId, int $id): JsonResponse
    {
        $review = Review::query()
            ->where('id', '=', $id)
            ->where('product_id', '=', $productId)
            ->first();

        if (!$review) {
            return JsonResponse::error('Review not found for this product', 404);
        }

        $reviewModel = Review::find($id);
        $reviewModel->delete();

        return JsonResponse::success(['id' => $id], 'Review deleted');
    }
}
