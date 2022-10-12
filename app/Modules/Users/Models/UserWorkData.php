<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkData extends Model
{
    use HasFactory;

    protected $table = "new_users_work_data";

    protected $fillable = ['deleted_at', 'deleted_at_int'];

    public function userPosition() {
        return $this->belongsTo('App\Modules\Users\Models\UserWorkPosition', 'position_id', 'id');
    }

    public function userBranch() {
        return $this->belongsTo('App\Modules\Company\Models\Branch', 'branch_id', 'id');
    }

    public function userBranchDepartament() {
        return $this->belongsTo('App\Modules\Company\Models\Branch', 'departament_id', 'id');
    }
}
