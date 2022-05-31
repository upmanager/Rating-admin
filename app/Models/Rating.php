<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $fillable = ['workerid', 'facilityid', 'rating', 'status'];
    public function Worker(){
        return $this->hasOne('App\Models\User', 'id', 'workerid');
    }
    public function Facility(){
        return $this->hasOne('App\Models\Facilities', 'id', 'facilityid');
    }
    public function Details(){
        return $this->hasOne('App\Models\RatingDetail', 'ratingid');
    }
}
