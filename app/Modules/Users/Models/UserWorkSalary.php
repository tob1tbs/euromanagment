<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkSalary extends Model
{
    use HasFactory;

    protected $table = "new_users_work_salary";

    protected $fillable = ['user_id', 'salary', 'bonus', 'fine', 'date', 'position_id', 'deleted_at', 'deleted_at_int'];

}
