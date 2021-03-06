<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'account_type' => 3,
        'active' => true,
     ];

    public function directorate(){
        return $this->belongsTo('App\Directorate', 'directorate_id');
    }

    public function school(){
        return $this->hasOne('App\School');
    }

    public function schoolClosure(){
        return $this->hasMany('App\SchoolClosure');
    }

    public function incident(){
        return $this->hasMany('App\Incident');
    }
}
