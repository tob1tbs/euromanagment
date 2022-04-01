<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "new_products";

    public function productCategory() {
        return $this->belongsTo('App\Modules\Products\Models\ProductCategory', 'category_id', 'id');
    }

    public function productPrice() {
        return $this->hasMany('App\Modules\Products\Models\ProductBrand', 'brand_id', 'id');
    }

    public function productUnit() {
        return $this->belongsTo('App\Modules\Products\Models\ProductUnit', 'unit_id', 'id');
    }

    public function productVendor() {
        return $this->belongsTo('App\Modules\Products\Models\ProductVendor', 'vendor_id', 'id');
    }
}
