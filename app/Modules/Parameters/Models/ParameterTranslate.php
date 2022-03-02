<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterTranslate extends Model
{
    use HasFactory;

    protected $table = "new_translate_parameters";

    protected $fillable = ['value', 'active', 'id'];
}
