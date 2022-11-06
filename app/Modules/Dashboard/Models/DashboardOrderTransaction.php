<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardOrderTransaction extends Model
{
    use HasFactory;

    protected $table = "new_orders_transactions";

    public function createdBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }
}
