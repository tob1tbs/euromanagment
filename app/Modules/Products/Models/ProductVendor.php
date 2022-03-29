<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVendor extends Model
{
    use HasFactory;

    protected $table = "new_product_vendors";

    protected $fillable = ['id', 'name', 'code', 'active', 'deleted_at', 'deleted_at_int'];
}
