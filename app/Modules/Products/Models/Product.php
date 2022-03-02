<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "new_products";

    protected $fillable = ['id', 'name_ge', 'category_id', 'child_category_id', 'brand_id', 'parent_id', 'discount_price', 'discount_percent', 'photo', 'count', 'stock', 'preorder', 'active', 'deleted_at', 'deleted_at_int'];
}
