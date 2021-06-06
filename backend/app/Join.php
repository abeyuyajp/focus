<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    protected $fillable = [
        'from_user_id',
        'post_id',
    ];
    
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
