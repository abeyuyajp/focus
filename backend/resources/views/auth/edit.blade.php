@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2><i class="fas fa-user-edit"></i>マイページ</h2>
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="/user/{{ $user->id }}" class="form-horizontal">
                        @csrf 
                        @method('PUT')
                        <div class="col-sm-6">
                            <label>
                                @if(!empty($user->profile_image))
                                    <img src="{{ $user->profile_image }}"  width="70vw" height="70px" style="border-radius: 100%;" id="img">
                                @else
                                    <i class="far fa-user-circle fa-3x"></i>
                                @endif
                                <input id="profile_image" type="file" name="profile_image" onchange="previewImage(this);">
                            </label>
                        </div>

                        <div class="form-group mt-4">
                            <label for="title" class="control-label">ユーザー名</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" style="border-radius: 20px;">
                        </div>
                        <div class="form-group mt-4">
                            <label for="title" class="control-label">職業</label>
                            <input class="form-control" name="work" type="text" value="{{ old('work', $user->work) }}" style="border-radius: 20px;">
                        </div>
                        <div class="form-group mt-4">
                            <label for="title" class="control-label">今月の目標は何ですか？</label>
                            <input class="form-control" name="purpose" type="text" value="{{ old('purpose', $user->purpose) }}" style="border-radius: 20px;">
                        </div>
                        <button class="btn btn-primary d-block mt-5" type="submit" style="margin: 0 auto; color: white;"><strong>更新する</strong></button>
                        <input type="hidden" name="id" value="{{$user->id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(obj)
    {
        var fileReader = new FileReader();
        fileReader.onload = (function() {
            document.getElementById('img').src = fileReader.result;
        });
        fileReader.readAsDataURL(obj.files[0]);
    }
</script>
@endsection