@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2><i class="far fa-user"></i>ユーザー情報</h2>
            <div class="card text-center">
                <div class="card-body">
                    <div class="post_user_image pr-2">
                        @if(!empty($user->profile_image))
                            <img src="{{ $user->profile_image }}"  width="70vw" height="70px" style="border-radius: 100%;">
                        @else
                            <i class="far fa-user-circle fa-3x"></i>
                        @endif
                    </div>
                    <h3 class="card-text text-muted">{{ $user->name }}</h3>
                    <p class="card-text">{{ $user->work }}</p>
                    <i class="fas fa-angle-double-down fa-2x"></i>
                    <p class="card-text text-muted">{{ $user->purpose }}</p>
                    @if(Auth::user()->id == $user->id)
                        <a class="btn btn-primary mb-2" href="{{ url('/user/edit') }}" role="button" style="color: white;">編集する</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
