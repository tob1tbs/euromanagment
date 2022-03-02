<?php

namespace App\Modules\Delivery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStreet extends Model
{
    use HasFactory;

    protected $table = "new_delivery_streets";

    protected $fillable = ['id', 'name_ge', 'name_en', 'active', 'deleted_at', 'deleted_at_int'];
}
