<?php

namespace App\Models;

use Core\Model\Model;

class Tag extends Model
{
    protected static string $table = 'tags';

    protected array $fillable = ['name', 'slug'];

    public function products(): array
    {
        $id = $this->getAttribute('id');
        $db = app('db');
        $rows = $db->table('product_tags')
            ->select('products.*')
            ->join('products', 'product_tags.product_id', '=', 'products.id')
            ->where('product_tags.tag_id', '=', $id)
            ->get();
        return $rows;
    }
}
