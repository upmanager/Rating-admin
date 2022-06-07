<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    //
    protected $fillable = ['name', 'etc', 'managerid', 'license_number', 'record_number', 'qty', 'content'];
    public function Manager(){
        return $this->hasOne('App\Models\User', 'id', 'managerid');
    }
    public function Rating(){
        return $this->hasMany('App\Models\Rating', 'facilityid');
    }

}
