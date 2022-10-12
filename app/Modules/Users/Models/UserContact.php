<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    use HasFactory;

    protected $table = "new_users_contacts";

    protected $fillable = ['value', 'user_id', 'deleted_at', 'deleted_at_int'];
}
