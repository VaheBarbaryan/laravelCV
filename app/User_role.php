<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $table = 'user_role';

    public function Role() {
        $this->belongsToMany('App\Role','id','role_id');
    }

}
