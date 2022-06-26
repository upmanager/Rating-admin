<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $fillable = ['title', 'order', 'all_check'];

    public function Questions()
    {
        return $this->hasMany('App\Models\Questions', 'categoryid')->where('questions.deleted', '0');
    }
    public function UserDetails(){
        return $this->hasMany('App\Models\UserDetails', 'typeid')->where('user_details.type', '2');
    }
}
