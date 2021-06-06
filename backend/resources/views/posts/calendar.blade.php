@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-left: 0px; width: 100%;">
    <div class="row">

        <div class="col-1" style="background-color: white; height: 100vh; margin-right: 20px;">
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

        <div class="col-8 pt-5" style="background: white;">
            <div id="app">
                <v-app>
                    <calendar-component></calendar-component>
                <v-app>
            </div>
        </div>

        <!-- joinしたorされた投稿を表示 -->
        <div class="col-2">
                <h4>自分がJoinした投稿</h4>
                @foreach($joinPostIds as $joinPostId)
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $joinPostId->post->user->name }}</h3>
                            <p class="card-text text-muted">作業内容：{{ $joinPostId->post->work_type }}</p>
                            <p class="card-text text-muted">時間：{{ $joinPostId->post->start }}〜{{ $joinPostId->post->end }}</p>
                        </div>
                    </div>
                @endforeach
                
                <h4>Joinされた投稿</h4>
                @foreach($joinedPostIds as $joinedPostId)
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $joinedPostId->post->user->name }}</h3>
                            <p class="card-text text-muted">作業内容：{{ $joinedPostId->post->work_type }}</p>
                            <p class="card-text text-muted">時間：{{ $joinedPostId->post->start }}〜{{ $joinedPostId->post->end }}</p>
                        </div>
                    </div>
                @endforeach
        </div>


    </div>
</div>


@endsection