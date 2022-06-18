<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    //
    protected $fillable = ['name', 'etc', 'managerid', 'license_number', 'record_number', 'offices', 'content', 'pdf'];
    public function Manager(){
        return $this->hasOne('App\Models\User', 'id', 'managerid');
    }
    public function Rating(){
        return $this->hasMany('App\Models\Rating', 'facilityid');
    }
    public function Offices(){
        return $this->hasMany('App\Models\Offices', 'facilityid');
    }
    public function UserDetails(){
        return $this->hasMany('App\Models\UserDetails', 'typeid')->where('user_details.type', '1');
    }
}
