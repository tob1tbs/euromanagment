<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $table = "new_product_option_value";

    protected $fillable = ['name', 'key', 'option_key', 'option_id', 'sortable', 'active', 'deleted_at', 'deleted_at_int'];
}
