<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "new_permissions";

    protected $fillable = ['id', 'name', 'title', 'group_id', 'guard_name', 'deleted_at', 'deleted_at_int'];
}
