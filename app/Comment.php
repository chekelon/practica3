<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment','user_id','product_id', 
    ];
    //public $timestamps = false;
    
    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
