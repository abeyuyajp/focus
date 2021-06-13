@extends('layouts.app')

@section('content')
<!--@include('layouts.side_menu')-->

<!--div class="container-fluid" >
    <div class="row"-->

        <!--div class="col-1 bg-navy" style= "height: 100%; margin-right: 20px; padding-bottom: 100%;">
            <div class="sidebar-fixed center-block" style="margin: 0 auto;">
                <ul class="nav flex-column">
                    <li class="nav-item mb-5 mt-5 text-center" >
                        <a class="text-white link-none" href="{{ url('/') }}">
                            <i class="far fa-edit fa-2x"></i>
                            <p><strong>セッション</strong></p>
                        </a>
                    </li>
                    <li class="nav-item mb-5 mt-5 text-center">
                        <a class="text-white link-none" href="{{ url('/calendar') }}">
                            <i class="far fa-calendar-alt fa-2x "></i>
                            <p><strong>カレンダー</strong></p>
                        </a>
                    </li>
                    <li class="nav-item mb-5 mt-5 text-center">
                        <a  class="text-white link-none" href="#">
                            <i class="far fa-user fa-2x"></i>
                            <p><strong>マイページ</strong></p>
                        </a>
                    </li>
                </ul>
            </div>
        </div-->
        <div class="d-flex">
            <div class="col-10" style="background: white;">
                <div id="app" class="mt-5">
                    <v-app>
                        <calendar-component></calendar-component>
                    </v-app>
                </div>
            </div>

            
            <!-- joinしたorされた投稿を表示 -->
            <div class="col-2">
                    <h4>ジョインした投稿</h4>
                    @foreach($joinPostIds as $joinPostId)
                        <!-- 終了時刻以降の投稿は表示しない -->
                        @if(strtotime(date('Y-m-d H:i')) < strtotime($joinPostId->post->end))
                        <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                            <div class="card-body">
                                <!-- 投稿したユーザーの画像と名前を表示 -->
                                <div class="post_user_info d-flex">
                                    <div class="post_user_image pr-2">
                                        @if(!empty($joinPostId->post->user->profile_image))
                                            <img src="{{ asset('storage/image/' . $joinPostId->post->user->profile_image) }}"  width="45vw" height="45px" style="border-radius: 100%;">
                                        @else
                                            <i class="far fa-user-circle fa-3x"></i>
                                        @endif
                                    </div>
                                    <h3 class="card-title">{{ $joinPostId->post->user->name }}</h3>
                                </div>
                                <p class="card-text text-muted">ルーム名：{{ $joinPostId->post->room_name }}</p>
                                <p class="card-text text-muted">作業：{{ $joinPostId->post->work_type }}</p>
                                    <i class="far fa-clock"></i>
                                    {{ date('n月d日', strtotime($joinPostId->post->start)) }}&emsp;
                                    {{ date('H:i', strtotime($joinPostId->post->start)) }}〜{{ date('H:i', strtotime($joinPostId->post->end)) }}
                                </p>
                                <a class="btn btn-primary mb-2" href="{{ url('/video_chat') }}" role="button" style="color: white;">セッションを開始</a>
                                <form action="{{ route('joins.destroy') }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <input type="hidden" value="{{ $joinPostId->id }}" name="id">
                                    <!-- 誰へキャンセルしたのか -->
                                    <button class="btn btn-outline-secondary" type="submit" onClick="delete_alert(event);return false;">キャンセル</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    
                    <h4>ジョインされた投稿</h4>
                    @foreach($joinedPostIds as $joinedPostId)
                        <!-- 終了時刻以降の投稿は表示しない -->
                        @if(strtotime(date('Y-m-d H:i')) < strtotime($joinedPostId->post->end))
                        <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                            <div class="card-body">
                                <h3 class="card-title">{{ $joinedPostId->post->user->name }}</h3>
                                <p class="card-text text-muted">ルーム名：{{ $joinedPostId->post->room_name }}</p>
                                <p class="card-text text-muted">ルーム名：{{ $joinedPostId->post->work_type }}</p>
                                    <i class="far fa-clock"></i>
                                    {{ date('n月d日', strtotime($joinedPostId->post->start)) }}&emsp;
                                    {{ date('H:i', strtotime($joinedPostId->post->start)) }}〜{{ date('H:i', strtotime($joinedPostId->post->end)) }}
                                </p>
                                <a class="btn btn-primary mb-2" href="{{ url('/video_chat') }}" role="button" style="color: white;">セッションを開始</a>
                                <form action="{{ route('joins.destroy') }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <input type="hidden" value="{{ $joinedPostId->id }}" name="id">
                                    <button class="btn btn-outline-secondary" onClick="delete_alert(event);return false;" type="submit">キャンセル</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach
            </div>
        </div>
    <!--/div>
</div-->
<script>
    function delete_alert(e){
        if(!window.confirm('本当にキャンセルしますか？')){
        window.alert('キャンセルされました'); 
        return false;
        }
        document.deleteform.submit();
    };
</script>

@endsection