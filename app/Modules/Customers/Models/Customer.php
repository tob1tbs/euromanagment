<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "new_customers";

    protected $fillable = [
        'type',
        'name',
        'lastname',
        'personal_id',
        'phone',
        'email',
        'address',
        'active',
        'consignation_limit',
    ];
}
