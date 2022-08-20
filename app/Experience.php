<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experience';

    public function experienceSelectId() {

        return $this->hasOne('App\Employer', 'id', 'employer_id');
    }
}
