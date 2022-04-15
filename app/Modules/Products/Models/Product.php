<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "new_products";

    protected $fillable = ['id', 'parent_id', 'name', 'count', 'unit_id', 'warehouse_id', 'category_id', 'brand_id', 'photo', 'active'];

    public function productCategory() {
        return $this->belongsTo('App\Modules\Products\Models\ProductCategory', 'category_id', 'id');
    }

    public function productBrand() {
        return $this->hasOne('App\Modules\Products\Models\ProductBrand', 'id', 'brand_id');
    }

    public function productPrice() {
        return $this->hasMany('App\Modules\Products\Models\ProductPrice', 'product_id', 'id')->orderBy('id', 'DESC');
    }

    public function productUnit() {
        return $this->belongsTo('App\Modules\Products\Models\ProductUnit', 'unit_id', 'id');
    }

    public function productVendor() {
        return $this->belongsTo('App\Modules\Products\Models\ProductVendor', 'vendor_id', 'id');
    }
}
