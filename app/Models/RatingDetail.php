<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingDetail extends Model
{
    //
    protected $fillable = ['ratingid', 'res_key', 'res_value', 'type'];
    public function Question(){
        return $this->hasOne('App\Models\Questions', 'id', 'type');
    }
}
