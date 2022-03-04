<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkSalary extends Model
{
    use HasFactory;

    protected $table = "new_users_work_salary";

    protected $fillable = ['user_id', 'salary', 'bonus', 'fine', 'date', 'position_id', 'created_by', 'deleted_by', 'deleted_at', 'deleted_at_int'];

    public function salaryCreator() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }

    public function salaryUser() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'user_id', 'id');
    }

}
