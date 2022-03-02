<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "new_companies";

    protected $fillable = ['id', 'name', 'code', 'address', 'customer_id', 'active', 'deleted_at', 'deleted_at_int'];

    public function companyCustomer() {
        return $this->belongsTo('App\Modules\Customers\Models\Customer', 'customer_id', 'id');
    }
}
