<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardOrderItem extends Model
{
    use HasFactory;

    protected $table = "new_orders_item";

    protected $fillable = [
        'item_id',
        'order_id',
        'price',
        'quantity',
        'deleted_at_int',
        'deleted_at',
    ];
}
