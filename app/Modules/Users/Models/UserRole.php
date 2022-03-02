<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = "new_roles";

    protected $fillable = ['id', 'name', 'title', 'guard_name', 'active', 'deleted_at','deleted_at_int'];
}
