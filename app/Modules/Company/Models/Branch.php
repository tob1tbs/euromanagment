<?php

namespace App\Modules\Company\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "new_branch";

    protected $fillable = ['id', 'name', 'parent_id', 'is_warehouse', 'active', 'deleted_at', 'deleted_at_int'];

    public function parentBranch() {
        return $this->belongsTo('App\Modules\Company\Models\Branch', 'parent_id', 'id');
    }
}
