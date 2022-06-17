<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //
    protected $table = 'user_details';
    protected $fillable = ['userid', 'typeid', 'type', 'value'];
    public function User(){
        return $this->hasMany('App\Models\User', 'id', 'userid');
    }
    public function Offices(){
        return $this->hasMany('App\Models\Offices', 'id', 'typeid')->where('user_details.type', '0');
    }
    public function Facilities(){
        return $this->hasMany('App\Models\Offices', 'id', 'typeid')->where('user_details.type', '1');
    }
    public function Questions(){
        return $this->hasMany('App\Models\Offices', 'id', 'typeid')->where('user_details.type', '2');
    }
}
