@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 0px;">
    <div class="row">

        <div class="col-3" style="background-color: white; height: 100vh; margin-right: 20px;">
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

        <div class="col pt-5" style="background: white;">
            <div id="app">
                <v-app>
                    <calendar-component></calendar-component>
                <v-app>
            </div>
        </div>


    </div>
</div>


@endsection