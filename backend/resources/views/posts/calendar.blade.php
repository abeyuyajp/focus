@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 3vh;">
    <div class="row justify-content-center">

        <!-- カレンダー -->
        <div class="col-md-8" style="background: white; border-radius: 20px;">
            <div id="app" class="mt-5">
                <v-app>
                    <calendar-component></calendar-component>
                </v-app>
            </div>
        </div>
        <!-- end -->

        <!-- マッチングした投稿一覧 -->
        <div class="col-md-3">
            <h4>予定</h4>
            <p class="text-muted">※ルーム名を入力して入室してください。</p>
            @foreach($joinPostIds as $joinPostId)
                <!-- 終了時刻以降の投稿は表示しない -->
                @if(strtotime(date('Y-m-d H:i')) < strtotime($joinPostId->post_end))
                    <div class="card d-inline-block m-2" style="width: 18rem; border-radius: 20px;">
                        <div class="card-body">

                            <!-- 投稿したユーザーの画像と名前を表示 -->
                            <div class="post_user_info d-flex">
                                <div class="post_user_image pr-2">
                                    @if(!empty($joinPostId->post->user->profile_image))
                                        <img src="{{ $joinPostId->post->user->profile_image }}"  width="45vw" height="45px" style="border-radius: 100%;">
                                    @else
                                        <i class="far fa-user-circle fa-3x"></i>
                                    @endif
                                </div>
                                <a href="{{ url('/user', $joinPostId->post->user->id) }}" class="card-title text-muted" style="font-size: 28px; color: black; text-decoration: none;">
                                    {{ $joinPostId->post->user->name }}
                                </a>
                            </div>

                            <!-- ルーム名 -->
                            <p class="card-text"><strong>ルーム名：{{ $joinPostId->post->room_name }}</strong></p>

                            <!-- 作業名 -->
                            <p class="card-text text-muted">作業：{{ $joinPostId->post_work_type }}</p>
                                <i class="far fa-clock"></i>
                                {{ date('n月d日', strtotime($joinPostId->post_start)) }}&emsp;
                                {{ date('H:i', strtotime($joinPostId->post_start)) }}〜{{ date('H:i', strtotime($joinPostId->post_end)) }}
                            </p>

                            <!-- ビデオチャットボタン -->
                            <a class="btn btn-primary mb-2" href="{{ url('/video_chat') }}" role="button" style="color: white;">セッションを開始</a>
                            
                            <!-- delete form -->
                            <form action="{{ route('joins.destroy') }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <input type="hidden" value="{{ $joinPostId->id }}" name="id">
                                <!-- 誰へキャンセルしたのか -->
                                <button class="btn btn-outline-secondary" type="submit" onClick="delete_alert(event);return false;">キャンセル</button>
                            </form>
                            <!-- end -->

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <!-- end -->

        <!--ページネーション-->
        <div class="mx-auto mt-4" style="width: 150px;">
            <div class="col-md-4">
                {{ $joinPostIds->appends(request()->input())->links() }}
            </div>
        </div>
        <!-- end -->

    </div>
</div>



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