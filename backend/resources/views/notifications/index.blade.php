@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 3vh;">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2 class="mb-5"><i class="far fa-bell"></i><strong>お知らせ</strong></h2>
            <all-notification-component  :current_user="{{Auth::user()}}"></all-notification-component>
        </div>
    </div>
</div>



@endsection