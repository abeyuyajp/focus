@extends('layouts.app')

@section('content')
<!--div class="container" style="margin-left: 0px;">
    <div class="row">

        <div class="col-3" style="background-color: white; height: 100vh;">
            <div class="sidebar-fixed">
                <ul class="nav flex-column">
                    <li class="nav-item m-5" style="margin: 0 auto; width: 50%;">
                        <a href="{{ url('posts/index') }}">
                            <i class="far fa-edit fa-3x"></i>
                            <p>セッション</p>
                        </a>
                    </li>
                    <li class="nav-item m-5">
                        <a href="#">
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
        </div-->

        <div id="app">
            <v-app>
                <calendar-component></calendar-component>
            <v-app>
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
                            <h2 class="card-title" style="color:black;">{{ $post->work_type }}</h2>
                            <p class="card-text"><small class="text-muted">{{ $post->created_at->diffForHumans() }}</small></p>
                            @if(Auth::id() === $post->user_id)
                              <a class="dropdown-item" href="{{ url('posts/' . $post->id . '/edit') }}">編集する</a>
                              <form method="POST" action="/posts/{{ $post->id }}">
                                  @csrf 
                                  @method('DELETE')
                                  <button class="dropdown-item" type="submit">削除する</button>
                              </form>
                            @endif
                        </div>
                    </div>
        @endforeach
        </div>
        
        
    <!--/div>
</div-->
@endsection