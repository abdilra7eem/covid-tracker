<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function schoolClosure(){
        return $this->hasMany('App\SchoolClosure');
    }
}
