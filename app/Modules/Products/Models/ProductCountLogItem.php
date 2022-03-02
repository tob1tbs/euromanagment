<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCountLogItem extends Model
{
    use HasFactory;

    protected $table = "new_product_count_log_item";

    protected $fillable = ['log_id', 'product_id', 'value_old', 'value_new'];

    public function balanceProduct() {
        return $this->belongsTo('App\Modules\Products\Models\Product', 'product_id', 'id');
    }
}

