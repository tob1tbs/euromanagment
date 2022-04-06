<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardOrderItem extends Model
{
    use HasFactory;

    protected $table = "new_orders_item";
}
