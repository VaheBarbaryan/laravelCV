<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $table = 'institute';
    protected $fillable = ['institute_name'];

    public function faculty() {
        return $this->hasMany('App\Faculty', 'institute_id', 'id');
    }
}
