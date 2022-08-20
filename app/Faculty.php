<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculty';
    protected $fillable = ['faculty_name'];
    public function institute() {
        return $this->hasOne('App\Institute', 'id', 'institute_id');
    }
    public function education() {
        return $this->hasMany('App\Education', 'faculty_id','id');
    }
}
