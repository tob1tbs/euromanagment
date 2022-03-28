<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkVacation extends Model
{
    use HasFactory;

    protected $table = "new_users_work_vacation";

    protected $fillable = ['deleted_at', 'deleted_at_int'];

    public function createdBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }

    public function vacationUser() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'user_id', 'id');
    }

    public function vacationType() {
        return $this->belongsTo('App\Modules\Users\Models\UserWorkVacationType', 'type_id', 'id');
    }

}
