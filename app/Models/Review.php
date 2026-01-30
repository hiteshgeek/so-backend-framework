<?php

namespace App\Models;

use Core\Model\Model;

class Review extends Model
{
    protected static string $table = 'reviews';

    protected array $fillable = [
        'product_id', 'user_id', 'rating', 'title', 'comment', 'is_approved'
    ];

    public function product(): ?array
    {
        $productId = $this->getAttribute('product_id');
        if (!$productId) return null;
        $product = Product::find($productId);
        return $product ? $product->toArray() : null;
    }

    public function user(): ?array
    {
        $userId = $this->getAttribute('user_id');
        if (!$userId) return null;
        $user = User::find($userId);
        return $user ? $user->toArray() : null;
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', '=', 1);
    }
}
