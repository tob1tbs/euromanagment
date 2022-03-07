<?php

namespace App\Modules\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "new_users";

    protected $fillable = [];

    protected $hidden = ['password', 'remember_token'];

    public function workData() {
        return $this->hasMany('App\Modules\Users\Models\UserWorkData', 'user_id', 'id');
    }
}
