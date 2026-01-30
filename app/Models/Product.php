<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\SoftDeletes;
use Core\ActivityLog\LogsActivity;

class Product extends Model
{
    use SoftDeletes, LogsActivity;

    protected static string $table = 'products';

    protected array $fillable = [
        'category_id', 'name', 'slug', 'sku', 'price', 'stock',
        'status', 'description'
    ];

    protected static bool $logsActivity = true;
    protected static array $logAttributes = ['name', 'price', 'stock', 'status'];
    protected static bool $logOnlyDirty = true;
    protected static string $logName = 'product';

    public function category(): ?array
    {
        $categoryId = $this->getAttribute('category_id');
        if (!$categoryId) return null;
        $category = Category::find($categoryId);
        return $category ? $category->toArray() : null;
    }

    public function reviews(): array
    {
        return Review::where('product_id', '=', $this->getAttribute('id'))->get();
    }

    public function tags(): array
    {
        $id = $this->getAttribute('id');
        $db = app('db');
        $rows = $db->table('product_tags')
            ->select('tags.*')
            ->join('tags', 'product_tags.tag_id', '=', 'tags.id')
            ->where('product_tags.product_id', '=', $id)
            ->get();
        return $rows;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', '=', $categoryId);
    }

    public function scopePriceBetween($query, float $min, float $max)
    {
        return $query->where('price', '>=', $min)->where('price', '<=', $max);
    }
}
