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
        </div>
        
        <div class="col"-->
            <div class="card" style="border-radius: 20px;">  
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="/posts">
                        @csrf
                        <div class="form-group mt-4">
                            <label for="work_type" class="control-label">作業</label>
                            <input class="form-control" name="work_type" type="text" style="border-radius: 20px;">
                        </div>
                        <button class="btn d-block" type="submit" style="margin: 0 auto;">GO</button>
                    </form>
                </div>
            </div>
        <!--/div>
    </div>
</div-->
@endsection