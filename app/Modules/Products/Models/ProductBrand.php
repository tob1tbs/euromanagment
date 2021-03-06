<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;

    protected $table = "new_product_brands";

    protected $fillable = ['name', 'active', 'updated_at', 'deleted_at', 'deleted_at_int',];
}
