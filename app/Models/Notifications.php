<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    //
    protected $fillable = ['userid', 'content', 'type', 'attach'];
    public function User(){
        return $this->hasOne('App\Models\User', 'id', 'userid');
    }
}
