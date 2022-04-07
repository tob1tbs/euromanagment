<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = "new_product_categories";

    protected $fillable = ['name', 'active', 'updated_at', 'deleted_at', 'deleted_at_int',];
}
