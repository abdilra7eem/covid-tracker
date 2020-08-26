<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}
