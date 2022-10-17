<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardOrder extends Model
{
    use HasFactory;

    protected $table = "new_orders";

    protected $fillable = [
        'customer_type',
        'customer_id',
        'total_price',
        'created_by',
        'rs_send',
        'status',
        'deleted_at',
        'deleted_at_int',
        'created_by',
        'deleted_by',
    ];

    public function customerType() {
        return $this->belongsTo('App\Modules\Customers\Models\Customer', 'customer_id', 'id');
    }

    public function customerCompany() {
        return $this->belongsTo('App\Modules\Customers\Models\CustomerCompany', 'customer_id', 'id');
    }

    public function orderItems() {
        return $this->hasMany('App\Modules\Dashboard\Models\DashboardOrderItem', 'order_id', 'id');
    }

    public function orderTransactions() {
        return $this->hasMany('App\Modules\Dashboard\Models\DashboardOrderTransactions', 'order_id', 'id');
    }
}
