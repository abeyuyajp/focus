@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 3vh;">
    <h1><i class="far fa-bell"></i>通知</h1>
    <div class="row justify-content-center">
        <div class="col-9">
            <all-notification-component  :current_user="{{Auth::user()}}"></all-notification-component>
        </div>
    </div>
</div>



@endsection