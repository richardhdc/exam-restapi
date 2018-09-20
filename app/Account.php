<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = ['id'];
    
    public function phones()
    {
        return $this->hasMany('App\Phone');
    }
}
