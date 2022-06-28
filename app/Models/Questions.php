<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //
    protected $fillable = ['categoryid', 'question', 'score', 'deleted'];
    public function Category()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'categoryid');
    }
    public function UserDetails(){
        return $this->hasMany('App\Models\UserDetails', 'typeid')->where('user_details.type', '2');
    }
    public function RatingDetails(){
        return $this->hasMany('App\Models\RatingDetail', 'type')->where('rating_details.res_key', '!=', 'location');
    }
}
