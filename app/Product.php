<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','caducidad','user_id' 
    ];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
