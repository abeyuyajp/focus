@extends('layouts.app')

@section('content')
            <div class="card" style="border-radius: 20px;">  
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="/posts/{{ $post->id }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-4">
                            <label for="work_type" class="control-label">作業</label>
                            <input class="form-control" name="work_type" type="text" style="border-radius: 20px;">
                        </div>
                        <button class="btn d-block" type="submit" style="margin: 0 auto;">更新</button>
                        <input type="hidden" name="id" value="{{$post->id}}">
                    </form>
                </div>
            </div>
@endsection