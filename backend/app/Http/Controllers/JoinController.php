<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Join;
use App\Notifications\PostJoined; 
use App\Notifications\FromUserDeleted;
use App\Notifications\ToUserDeleted;
use App\Notifications\PostJoinedWeb;
use App\Events\Notice;

class JoinController extends Controller
{
    #use Notifiable;

    public function store(Request $request)
    {
        $join = new Join;
        $join->from_user_id  =  Auth::user()->id;
        $join->to_user_id    =  $request->to_user_id;
        $join->post_id       =  $request->post_id;
        $join->post_start       =  $request->post_start;
        $join->post_end       =  $request->post_end;
        $join->post_work_type       =  $request->post_work_type;
        $join->save();

        # ジョインされた人を取得(メールの宛先)
        $joined_user = Auth::user()->find($join->to_user_id);
        \Notification::send($joined_user, new \App\Notifications\PostJoined(\Auth::user()->name));

        # ジョインされた人を取得（通知先）
        $joined_user = Auth::user()->find($join->to_user_id);
        \Notification::send($joined_user, new \App\Notifications\PostJoinedWeb(\Auth::user()->name, $join->created_at));
        event(new Notice());
    
        return redirect(url('/calendar'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
    
        $join = Join::find($id);
        
        $join->delete();

        # from_user_idがキャンセルした場合
        if(Auth::user()->id == $join->to_user_id) {  
            $from_user_deleted = Auth::user()->find($join->from_user_id);
            \Notification::send($from_user_deleted, new \App\Notifications\FromUserDeleted(\Auth::user()->name));
        }elseif(Auth::user()->id == $join->from_user_id) {  
            $to_user_deleted = Auth::user()->find($join->to_user_id);
            \Notification::send($to_user_deleted, new \App\Notifications\ToUserDeleted(\Auth::user()->name));
        }

        #webでの通知
        #if(Auth::user()->id == $join->to_user_id) {
            #$from_user_deleted = Auth::user()->find($join->from_user_id);
            #\Notification::send($from_user_deleted, new \App\Notifications\FromUserDeletedWeb(\Auth::user()->name));
        #}elseif(Auth::user()->id == $join->from_user_id){
            #$to_user_deleted = Auth::user()->find($join->to_user_id);
            #\Notification::send($to_user_deleted, new \App\Notifications\FromUserDeletedWeb(\Auth::user()->name));
        #}

        return redirect('/calendar');
    }
}
