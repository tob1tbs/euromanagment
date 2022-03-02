<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionItem extends Model
{
    use HasFactory;

    protected $table = 'new_product_option_item';

    protected $fillable = ['id', 'product_id', 'key', 'value'];

    public function optionValueData() {
        return $this->belongsTo('App\Modules\Products\Models\ProductOptionValue', 'value', 'id');
    }
}
