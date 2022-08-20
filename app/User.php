<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    protected $table = 'user';

    public function Role()
    {
        return $this->belongsToMany('App\Role','user_role', 'user_id', 'role_id');
    }
}