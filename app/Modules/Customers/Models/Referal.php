<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    use HasFactory;

    protected $table = "new_referals";

    protected $fillable = [
        'type_id',
        'referal_id',
        'customer_id',
    ];
}
