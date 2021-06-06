<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'work_type',
        'start',
        'end'
    ];

    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function join()
    {
        return $this->hasOne('App\Join');
    }

}
