<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post\Repositories\PostRepository;
use App\Join\Repositories\JoinRepository;
use App\EloquentModel\Post;
use Illuminate\Support\Collection;
use Validator;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Join;


class PostsController extends Controller
{
    private PostRepository $postRepository;
    private JoinRepository $joinRepository;

    public function __construct(
        PostRepository $postRepository,
        JoinRepository $joinRepository
    ) {
        $this->postRepository = $postRepository;
        $this->joinRepository = $joinRepository;
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
        $joinedPostIds = $this->joinRepository->getAllJoinedPost();

        //Joinされている投稿IDは全て排除して取得
        $posts = $this->postRepository->getPostIdsExclusionJoinedPost($joinedPostIds);

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
     * 現在使用していないメソッド
     */
    public function show(Request $request, $id)
    {
        $post = $this->postRepository->getPostId($id);
        return view ('posts.show', compact('post'));
    }

    /**
     * 現在使用していないメソッド
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = $this->postRepository->getPostIdByUser($post_id);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * 現在使用していないメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $posts = $this->postRepository->getPostIdByUser($request->id);

        $posts->work_type  =    $request->work_type;
        $posts->save();
        return redirect('/')->with('message', '投稿を編集しました');
    }

    public function search(Request $request)
    {
        //すでにJoinされた投稿を取得
        $joinedPostIds = $this->joinRepository->getAllJoinedPost();

        $posts = $this->postRepository->searchPost($request->work_type, $request->start, $joinedPostIds);

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
        $calendar = $this->postRepository->getRequestPostId($request->id);
        if($calendar){
            $calendar->delete();
        }
    }

    public function getAllEvent()
    {
        $calendars = $this->postRepository->getPostByUser();
        return $calendars;
    }


    public function showCalendar()
    {
        $joinPostIds = $this->joinRepository->getAllSessionByUser();

        $bg_image = Storage::disk('s3')->url('card.png');


        return view('posts.calendar',['joinPostIds' => $joinPostIds, 'bg_image' => $bg_image]);
    }

}
