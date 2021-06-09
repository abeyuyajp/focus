@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 0px;">
    <div class="row">

        <div class="col-2" style="background-color: white; height: 100vh;">
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

        <div class="col-10">
            <!--div>
                <a href="{{ url('posts/create') }}" class="btn">
                    投稿する
                </a>
            </div-->
                @foreach($posts as $post)
                    @if(strtotime(date('Y-m-d H:i')) < strtotime($post->end))
                    <div class="card d-inline-block m-2" style="width: 23rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $post->user->name }}</h3>
                            <!--p class="card-text text-muted">ルーム名：{{ $post->work_type }}</p-->
                            <p class="card-text text-muted">
                                <i class="far fa-clock"></i>
                                {{ date('n月d日', strtotime($post->start)) }}&emsp;
                                {{ date('H:i', strtotime($post->start)) }}〜{{ date('H:i', strtotime($post->end)) }}
                            </p>
                            <!-- マッチングのリクエスト -->
                            <form action="{{ route('joins.store') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                @unless(Auth::id() == $post->user_id)
                                    <button class="btn d-block btn-primary" type="submit" style="margin: 0 auto; color: white;">ジョインする</button>
                                @endif
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
        </div>
        
        
    </div>
</div>
@endsection