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
            <div id="app" class="mt-5">
                <v-app>
                    <calendar-component></calendar-component>
                <v-app>
            </div>
        </div>

        
        <!-- joinしたorされた投稿を表示 -->
        <div class="col-2">
                <h4>自分がJoinした投稿</h4>
                @foreach($joinPostIds as $joinPostId)
                    <!-- 終了時刻以降の投稿は表示しない -->
                    @if(strtotime(date('Y-m-d H:i')) < strtotime($joinPostId->post->end))
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $joinPostId->post->user->name }}</h3>
                            <p class="card-text text-muted">ルーム名：{{ $joinPostId->post->work_type }}</p>
                            <p class="card-text text-muted">
                                <i class="far fa-clock"></i>
                                {{ date('n月d日', strtotime($joinPostId->post->start)) }}&emsp;
                                {{ date('H:i', strtotime($joinPostId->post->start)) }}〜{{ date('H:i', strtotime($joinPostId->post->end)) }}
                            </p>
                            <a class="btn btn-primary mb-2" href="{{ url('/video_chat') }}" role="button" style="color: white;">セッションを開始</a>
                            <form action="{{ route('joins.destroy') }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <input type="hidden" value="{{ $joinPostId->id }}" name="id">
                                <button class="btn btn-outline-secondary" type="submit" onClick="delete_alert(event);return false;">キャンセル</button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
                
                <h4>Joinされた投稿</h4>
                @foreach($joinedPostIds as $joinedPostId)
                    <!-- 終了時刻以降の投稿は表示しない -->
                    @if(strtotime(date('Y-m-d H:i')) < strtotime($joinedPostId->post->end))
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">
                            <h3 class="card-title">{{ $joinedPostId->post->user->name }}</h3>
                            <p class="card-text text-muted">ルーム名：{{ $joinedPostId->post->work_type }}</p>
                            <p class="card-text text-muted">
                                <i class="far fa-clock"></i>
                                {{ date('n月d日', strtotime($joinedPostId->post->start)) }}&emsp;
                                {{ date('H:i', strtotime($joinedPostId->post->start)) }}〜{{ date('H:i', strtotime($joinedPostId->post->end)) }}
                            </p>
                            <a class="btn btn-primary mb-2" href="{{ url('/video_chat') }}" role="button" style="color: white;">セッションを開始</a>
                            <form action="{{ route('joins.destroy') }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <input type="hidden" value="{{ $joinedPostId->id }}" name="id">
                                <button class="btn btn-outline-secondary" type="submit">キャンセル</button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
        </div>
    </div>
</div>
<script>
    function delete_alert(e){
        if(!window.confirm('本当に削除しますか？')){
        window.alert('キャンセルされました'); 
        return false;
        }
        document.deleteform.submit();
    };
</script>

@endsection