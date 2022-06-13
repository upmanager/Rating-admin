<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //
    protected $fillable = ['categoryid', 'question', 'deleted'];
    public function Category()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'categoryid');
    }
}
