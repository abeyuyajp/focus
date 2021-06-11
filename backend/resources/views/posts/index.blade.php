@extends('layouts.app')

@section('content')
<div class="d-flex">
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
                                <input type="hidden" name="to_user_id" value="{{ $post->user_id }}">
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
@endsection