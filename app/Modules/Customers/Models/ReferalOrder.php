<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferalOrder extends Model
{
    use HasFactory;

    protected $table = "new_referals_order";

    protected $fillable = ['status', 'pay_by'];

    public function payBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'pay_by', 'id');
    }
}

