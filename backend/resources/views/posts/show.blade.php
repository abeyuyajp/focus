@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 3vh;">
    <div class="row justify-content-center">

        <!-- カレンダー -->
        <div class="col-md-6" style="background: white; border-radius: 20px;">
            <div id="app" class="mt-5">
                <v-app>
                    <calendar-component></calendar-component>
                </v-app>
            </div>
        </div>


        <!-- 詳細 -->
        <div class="col-md-5">
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
                        <a href="{{ url('/user', $post->user->id) }}" class="card-title text-muted" style="font-size: 28px; color: black; text-decoration: none;">
                            {{ $post->user->name }}
                        </a>
                    </div>
                    <p class="card-text text-muted">作業：{{ $post->work_type }}</p>
                    <p class="card-text text-muted">
                        <i class="far fa-clock"></i>
                        {{ date('n月d日', strtotime($post->start)) }}&emsp;
                        {{ date('H:i', strtotime($post->start)) }}〜{{ date('H:i', strtotime($post->end)) }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection