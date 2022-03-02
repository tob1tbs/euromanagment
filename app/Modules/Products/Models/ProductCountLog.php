<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCountLog extends Model
{
    use HasFactory;

    protected $table = "new_product_count_log";

    protected $fillable = ['user_id', 'method'];

    public function balanceUpdatedBy() {
        return $this->belongsTo('App\Modules\Customers\Models\Users', 'user_id', 'id');
    }
}

