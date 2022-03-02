<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;

    protected $table = "new_product_brands";

    protected $fillable = ['name', 'category_id', 'child_category_id', 'active', 'deleted_at', 'deleted_at_int'];

    public function getCategoryData() {
        return $this->hasOne('App\Modules\Products\Models\ProductCategory', 'id', 'category_id');
    }

    public function getChildCategoryData() {
        return $this->hasOne('App\Modules\Products\Models\ProductCategory', 'id', 'child_category_id');
    }
}
