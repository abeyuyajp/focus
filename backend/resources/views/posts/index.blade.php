@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 0px;">
    <div class="row">

        <div class="col-3" style="background-color: white; height: 100vh;">
            <div class="sidebar-fixed">
                <ul class="nav flex-column">
                    <li class="nav-item m-5" style="margin: 0 auto; width: 50%;">
                        <a href="{{ url('/') }}">
                            <i class="far fa-edit fa-3x"></i>
                            <p>セッション</p>
                        </a>
                    </li>
                    <li class="nav-item m-5">
                        <a href="{{ url('/calendar') }}">
                            <i class="far fa-calendar-alt fa-3x"></i>
                            <p>カレンダー</p>
                        </a>
                    </li>
                    <li class="nav-item m-5">
                        <a href="#">
                            <i class="far fa-user fa-3x"></i>
                            <p>マイページ</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div>
                <a href="{{ url('posts/create') }}" class="btn">
                    投稿する
                </a>
            </div>
        @foreach($posts as $post)
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $post->user->name }}</h3>
                            <p class="card-text text-muted">作業内容：{{ $post->work_type }}</p>
                            <p class="card-text text-muted">時間：{{ $post->start }}〜{{ $post->end }}</p>
                            
                        </div>
                    </div>
        @endforeach
        </div>
        
        
    </div>
</div>
@endsection