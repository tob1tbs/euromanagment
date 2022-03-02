<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    use HasFactory;

    protected $table = "new_product_meta";

    protected $fillable = ['id', 'product_id', 'keywords_ge', 'keywords_en', 'description_ge', 'description_ge'];
}
