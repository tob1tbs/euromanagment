<?php

namespace App\Modules\Delivery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDistrict extends Model
{
    use HasFactory;

    protected $table = "new_delivery_districts";

    protected $fillable = ['delivery_price', 'active'];
}
