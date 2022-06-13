<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $fillable = ['title', 'order'];

    public function Questions()
    {
        return $this->hasMany('App\Models\Questions', 'categoryid')->where('questions.deleted', '0');
    }
}
