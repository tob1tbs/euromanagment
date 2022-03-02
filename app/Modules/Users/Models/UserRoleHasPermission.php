<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleHasPermission extends Model
{
    use HasFactory;

    protected $table = "new_role_has_permissions";
}
