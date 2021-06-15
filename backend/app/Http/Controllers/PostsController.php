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
        $posts = Post::orderBy('start', 'asc')
                    ->whereNotIn('id',$joinedPostIds)
                    ->paginate(12);
        
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
        $posts->room_name  =    $request->room_name;
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

    public function search(Request $request)
    {
        //すでにJoinされた投稿を取得
        $joinedPostIds = Join::all()->pluck('post_id')->toArray();
        
        $posts = Post::where('work_type', 'like', "%{$request->work_type}%")
                     ->where('start', 'like', "%{$request->start}%")
                     ->whereNotIn('id',$joinedPostIds)
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        return view('posts.index', [
            'posts'=>$posts,
        ]);
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

    public function getAllEvent()
    {
        //自分がジョインしたpost_idを取得
        $joinId = Join::where('from_user_id', Auth::user()->id)
                            ->pluck('post_id')
                            ->toArray();

        //自分の投稿または、ジョインしたpost_idを取得
        $calendars = Post::where('user_id', Auth::user()->id)
                         ->orWhereIn('id', $joinId)
                         ->get();

        //$calendars = Post::where('user_id', Auth::user()->id)
                            //->get();

        return $calendars;
    }

    public function showCalendar()
    {
        $joinPostIds = Join::orderBy('post_start', 'asc')
                            ->where('from_user_id', Auth::user()->id)
                            ->orWhere('to_user_id', Auth::user()->id)
                            ->paginate(4);

        return view('posts.calendar',['joinPostIds' => $joinPostIds]);
    }

}
