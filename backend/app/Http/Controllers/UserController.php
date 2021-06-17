<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Post;
use App\Join;
use App\Notifications\PostJoinedWeb;
use \InterventionImage;
use Intervention\Image\Facades\Image; 
use Storage;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('auth.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {

        $user = User::find($request->id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'mimes: jpeg,png,jpg,bmp', 'max: 2048'],
        ]);

        //送られてきた画像を取得
        $file = $request->file('profile_image');

        //画像が含まれていたら、
        if(!empty($file)) {
             //画像の拡張子を取得
             $extension = $request->file('profile_image')->getClientOriginalExtension();
             //画像の名前を取得
             $filename = $request->file('profile_image')->getClientOriginalName();
             //画像をリサイズ
             $resize_img = InterventionImage::make($file)->resize(100, 100)->encode($extension);
             //s3に保存
             $path = Storage::disk('s3')->put('/'.$filename , (string)$resize_img, 'public');
             //画像のURLを参照
             $user->profile_image = Storage::disk('s3')->url($filename);
             //DBに保存
             $user->save();
        }
        $user->name = $request->name;
        $user->save();
        return redirect('/');
    }

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
