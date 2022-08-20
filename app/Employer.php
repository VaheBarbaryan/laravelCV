<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = 'employer';

    protected $fillable = ['application_date','date_interview','name_surname','birth_date','proffession','expected_salary','comments', 'phone_numbers', 'social_sites'];

    public function education() {

        return $this->hasMany('App\Education', 'employer_id', 'id');
    }
    public function experience() {

        return $this->hasMany('App\Experience', 'employer_id', 'id');
    }
    public function cv() {
        return $this->hasMany('App\Cv', 'employer_id', 'id');
    }
    public function phone() {
        return $this->hasMany('App\Phone','employer_id','id');
    }
    public function social_site() {
        return $this->hasMany('App\Social_site','employer_id','id');
    }
}
