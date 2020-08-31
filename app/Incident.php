<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $attributes = [
        'deleted' => false,
     ];
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
