<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    use HasFactory;

    protected $table = "new_customer_companies";

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'contact',
    ];
}
