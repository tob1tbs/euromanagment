<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $table = 'new_product_options';

    protected $fillable = ['id', 'name', 'key', 'category_id', 'child_category_id', 'type', 'active', 'deleted_at', 'deleted_at_int'];
    
    public function getCategoryData() {
        return $this->hasOne('App\Modules\Products\Models\ProductCategory', 'id', 'category_id');
    }

    public function getChildCategoryData() {
        return $this->hasOne('App\Modules\Products\Models\ProductCategory', 'id', 'child_category_id');
    }

    public function optionTypeList() {
        $OptionListArray = [
            'input' => 'Input',
            'select' => 'Select',
        ];

        return $OptionListArray;
    }
}
