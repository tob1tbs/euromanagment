<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkPosition extends Model
{
    use HasFactory;

    protected $table = "new_users_work_positions";

    protected $fillable = ['name', 'active', 'deleted_at', 'deleted_at_int', 'updated_at'];

}
