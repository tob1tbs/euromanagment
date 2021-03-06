<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $table = "new_product_price";

    protected $fillable = ['id', 'product_id', 'vendor_price', 'retail_price', 'wholesale_price', 'deleted_at', 'deleted_at_int'];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];
}
