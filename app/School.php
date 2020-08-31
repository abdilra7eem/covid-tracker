<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $attributes = [
        'rented' => false,
        'second_shift' => false,
        'building_year' => 0
     ];
    public function user(){
        return $this->belongsTo('App\User');
    }

}
