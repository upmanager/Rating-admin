<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $table = 'office';
    protected $fillable = ['facilityid', 'name'];
    public function UserDetails(){
        return $this->hasMany('App\Models\UserDetails', 'typeid')->where('user_details.type', '0');
    }
}
