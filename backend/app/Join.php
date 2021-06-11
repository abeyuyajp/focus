<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
#use Illuminate\Notifications\Notifiable;

class Join extends Model
{

    protected $fillable = [
        'from_user_id',
        'to_user_id',
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

    #public function postJoined ($from_user_name) {
        // ここでNotificationクラスを呼び出す
        #dd($from_user_name);
        #$this->notify(new \App\Notifications\PostJoined($from_user_name));
   # }
}
