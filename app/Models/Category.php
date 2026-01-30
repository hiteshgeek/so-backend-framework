<?php

namespace App\Models;

use Core\Model\Model;

class Category extends Model
{
    protected static string $table = 'categories';

    protected array $fillable = ['name', 'slug', 'description', 'parent_id', 'is_active'];

    public function products(): array
    {
        return Product::where('category_id', '=', $this->getAttribute('id'))->get();
    }

    public function children(): array
    {
        return self::where('parent_id', '=', $this->getAttribute('id'))->get();
    }

    public function parent(): ?array
    {
        $parentId = $this->getAttribute('parent_id');
        if (!$parentId) return null;
        $parent = self::find($parentId);
        return $parent ? $parent->toArray() : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function scopeParents($query)
    {
        return $query->where('parent_id', 'IS', null);
    }
}
