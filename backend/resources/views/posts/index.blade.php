@extends('layouts.app')

@section('content')
<div class="d-flex">
        <div class="col-12">
            <!-- search -->
            <form class="d-flex" action="{{route('posts.search')}}" method="get">
                @csrf
                <input type="text"  class="form-control mr-2" placeholder="作業：(例)プログラミング" name="work_type" style="border-radius: 10px;">
                <input type="date"  class="form-control" name="start" style="border-radius: 10px;">
                <button class="btn mb-3" type="submit" >
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <!-- end -->
                @foreach($posts as $post)
                    @if(strtotime(date('Y-m-d H:i')) < strtotime($post->end))
                    <div class="card d-inline-block m-2" style="width: 23rem; border-radius: 20px;">
                        <div class="card-body">
                            <div class="post_user_info d-flex">
                                <div class="post_user_image pr-2">
                                    @if(!empty($post->user->profile_image))
                                        <img src="{{ $post->user->profile_image }}"  width="45vw" height="45px" style="border-radius: 100%;">
                                    @else
                                        <i class="far fa-user-circle fa-3x"></i>
                                    @endif
                                </div>
                                <h3 class="post_user_name card-title">{{ $post->user->name }}</h3>
                            </div>
                            <p class="card-text text-muted">作業：{{ $post->work_type }}</p>
                            <p class="card-text text-muted">
                                <i class="far fa-clock"></i>
                                {{ date('n月d日', strtotime($post->start)) }}&emsp;
                                {{ date('H:i', strtotime($post->start)) }}〜{{ date('H:i', strtotime($post->end)) }}
                            </p>
                            <!-- join button-->
                            <form action="{{ route('joins.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="to_user_id" value="{{ $post->user_id }}">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="post_start" value="{{ $post->start }}">
                                <input type="hidden" name="post_end" value="{{ $post->end }}">
                                <input type="hidden" name="post_work_type" value="{{ $post->work_type }}">
                                @unless(Auth::id() == $post->user_id)
                                    <button class="btn d-block btn-primary" type="submit" style="margin: 0 auto; color: white;">ジョインする</button>
                                @endif
                            </form>
                            <!-- end -->
                        </div>
                    </div>
                    @endif
                @endforeach
                <!--ページネーション-->
                <div class="mx-auto mt-4" style="width: 150px; margin-bottom: 20vh">
                    <div class="col-md-4">
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                </div>
                
        </div>
</div>
@endsection