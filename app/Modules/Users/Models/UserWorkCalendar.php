<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkCalendar extends Model
{
    use HasFactory;

    protected $table = "new_users_work_calendar";

    protected $fillable = ['id', 'user_id', 'work_date', 'deleted_at','deleted_at_int'];

    public function workUser() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'user_id', 'id');
    }

    public function workCreator() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }
}
