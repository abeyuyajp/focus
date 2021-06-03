<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use Validator;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;

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
        $posts = Post::where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        #$posts = Post::orderBy('created_at', 'asc')->get();

        
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
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/')->with('message', '投稿を削除しました');
    }
}
