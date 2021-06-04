@extends('layouts.app')

@section('content')


        
        <div class="col">
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
        </div>
    
@endsection