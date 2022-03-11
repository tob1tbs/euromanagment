<?php

namespace App\Modules\Company\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "new_branch";

    protected $fillable = ['id', 'name', 'parent_id', 'active', 'deleted_at', 'deleted_at_int'];
}
