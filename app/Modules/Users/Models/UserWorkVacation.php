<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkVacation extends Model
{
    use HasFactory;

    protected $table = "new_users_work_vacation";

    public function CreatedBy() {
        return $this->belongsTo('App\Modules\Users\Models\User', 'created_by', 'id');
    }

}
