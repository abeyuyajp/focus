<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use Validator;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Join;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //すでにJoinされた投稿を取得
        $joinedPostIds = Join::all()->pluck('post_id')->toArray();

        //Joinされている投稿IDは全て排除して取得
        $posts = Post::orderBy('created_at', 'desc')->whereNotIn('id',$joinedPostIds)->get();
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posts = new Post;
        $posts->user_id    =    Auth::user()->id;
        $posts->work_type  =    $request->work_type;
        $posts->start      =    $request->start;
        $posts->end        =    $request->end;
        $posts->save(); 
        return redirect('/')->with('message', '投稿が完了しました');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = Post::where('user_id', Auth::user()->id)->find($post_id);
        return view('posts.edit', ['post' => $post]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $posts = Post::where('user_id', Auth::user()->id)->find($request->id);

        $posts->work_type  =    $request->work_type;
        $posts->save(); 
        return redirect('/')->with('message', '投稿を編集しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent(Request $request)
    {
        $calendar = Post::where('id','=',$request->id)
            ->first();
        if($calendar){
            $calendar->delete();
        }
    }

    public function getAllEvent(){
        $calendars = Post::where('user_id', Auth::user()->id)
            ->get();
        return $calendars;
    }

    public function showCalendar()
    {
        //自分がJoinした投稿を取得
        $joinPostIds = Join::where('from_user_id', Auth::user()->id)->get();

        //自分の全ての投稿IDを取得
        $posts = Post::where('user_id', Auth::user()->id)->pluck('id')->ToArray();
        
        //Joinされた自分の全ての投稿IDを取得
        $joinedPostIds = Join::whereIn('post_id', $posts)->get();

        //string型の時間を変更

        return view('posts.calendar',['joinPostIds' => $joinPostIds, 'joinedPostIds' => $joinedPostIds]);
    }

}
