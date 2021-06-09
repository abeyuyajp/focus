<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class VideoChatController extends Controller
{
    public function index()
    {
        $my_api_key = config('services.skyway.key');
        #return view('video_chat.index', ['my_api_key' => $my_api_key]);
        # key: '{{ $my_api_key }}',
        $user = Auth::user();
        $user_peer_id = rtrim(base64_encode($user->email),"=");
        #dd($user_peer_id);
        #return view('video_chat.index', ['user'=>['email'=>rtrim(base64_encode($user->email),"=")]]);
        return view('video_chat.index', ['user_peer_id' => $user_peer_id, 'my_api_key' => $my_api_key]);
    }
}
