<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';

    public function educationSelectId() {

        return $this->hasOne('App\Employer', 'id', 'employer_id');
    }
    public function faculty() {
        return $this->hasOne('App\Faculty','id','faculty_id');
    }
}
