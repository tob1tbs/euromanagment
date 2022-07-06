<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class DashboardOrderOverhead extends Model
{
    use HasFactory;

    protected $table = "new_orders_overhead";

    public function createdBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }

    public function deletedBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'deleted_by', 'id');
    }
}
