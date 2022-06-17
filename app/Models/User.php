<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phonenumber', 'fcm_token', 'status'
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
    public function Facilities(){
        return $this->hasMany('App\Models\Facilities', 'managerid');
    }
    public function userDetail()
    {
        return $this->hasMany('App\Models\UserDetails', 'userid');
    }
    public function userOffice()
    {
        return $this->hasMany('App\Models\UserDetails', 'userid')->where('user_details.type', '0');
    }
    public function userFacility()
    {
        return $this->hasMany('App\Models\UserDetails', 'userid')->where('user_details.type', '1');
    }
    public function userQuestion()
    {
        return $this->hasMany('App\Models\UserDetails', 'userid')->where('user_details.type', '2');
    }
}
