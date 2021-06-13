@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">マイページ</div>

                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="/user/{{ $user->id }}" class="form-horizontal">
                        @csrf 
                        @method('PUT')
                        <div class="col-sm-6">
                            <label>
                                 画像を選択
                                <input type="file" name="profile_image" value="{{ asset('storage/image/' . $user->profile_image) }}">
                            </label>
                        </div>

                        <div class="form-group mt-4">
                            <label for="title" class="control-label">ユーザー名</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" style="border-radius: 20px;">
                        </div>
                        <button class="btn btn-primary d-block" type="submit" style="margin: 0 auto;">更新</button>
                        <input type="hidden" name="id" value="{{$user->id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection