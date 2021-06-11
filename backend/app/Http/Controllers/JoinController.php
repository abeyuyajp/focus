<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Join;
use App\Notifications\PostJoined; 
use App\Notifications\FromUserDeleted;
use App\Notifications\ToUserDeleted;

class JoinController extends Controller
{
    #use Notifiable;

    public function store(Request $request)
    {
        $join = new Join;
        $join->from_user_id  =  Auth::user()->id;
        $join->to_user_id    =  $request->to_user_id;
        $join->post_id       =  $request->post_id;
        $join->save();

        # ジョインされた人を取得(メールの宛先)
        $joined_user = Auth::user()->find($join->to_user_id);
        \Notification::send($joined_user, new \App\Notifications\PostJoined(\Auth::user()->name));
    
        return redirect(url('/calendar'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        
        $join = Join::find($id);

        # from_user_id(削除対象の投稿にジョインした人を取得）
        
        # to_user_id(削除対象を投稿した人を取得)
        
        
        $join->delete();

        # from_user_idがキャンセルした場合
        if(Auth::user()->id == $join->to_user_id) {  
            $from_user_deleted = Auth::user()->find($join->from_user_id);
            \Notification::send($from_user_deleted, new \App\Notifications\FromUserDeleted(\Auth::user()->name));
        }elseif(Auth::user()->id == $join->from_user_id) {  
            $to_user_deleted = Auth::user()->find($join->to_user_id);
            \Notification::send($to_user_deleted, new \App\Notifications\ToUserDeleted(\Auth::user()->name));
        }

        return redirect('/calendar');
    }
}
