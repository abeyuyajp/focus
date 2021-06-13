<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Join;
use App\Notifications\PostJoinedWeb;

class UserController extends Controller
{
    public function notice_get(User $user)
    {
        
        $notices = $user->unreadNotifications()->limit(5)->get()->toArray();
        return $notices;
    }

    public function notice_checked(Request $request)
    {
        //ログインしているユーザーを取得
        $user = Auth::user()->id;

        //ログインユーザーに紐づくチェックしていないnotificationを取得
        $notice = $user->unreadNotifications()->where('id', $request->id)->first();

        //statusの値をtrueに変更(既読に変更)
        $newValue = ['status' => true];

        //array_replaceを使用して値（from_user_name, joined_created_at）を変更
        $notice->data = array_replace($notice->data, $newValue);

        //更新
        $notice->save();
    }
}
