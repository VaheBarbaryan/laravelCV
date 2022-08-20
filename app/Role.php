<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    public function User() {
        return $this->hasMany('App\User');
    }
    public function User_role() {
        return $this->hasMany('App\User_role','role_id','id');
    }
}
