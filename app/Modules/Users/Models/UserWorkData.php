<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkData extends Model
{
    use HasFactory;

    protected $table = "new_users_work_data";

    public function userPosition() {
        return $this->belongsTo('App\Modules\Users\Models\UserWorkPosition', 'position_id', 'id');
    }
}
