<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissionGroup extends Model
{
    use HasFactory;

    protected $table = "new_permission_groups";
}
