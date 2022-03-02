<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "new_customers";

    protected $fillable = ['id', 'name', 'lastname', 'personal_number', 'bdate', 'phone', 'email', 'password', 'type', 'active', 'deleted_at', 'deleted_at_int'];
}
