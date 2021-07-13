@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid d-flex align-items-end" style="background:url({{ Storage::disk('s3')->url('focus-header.png') }}); background-size: auto; background-position: center 60%; height: 40vh;" >
    </div>

    <div class="container marketing">
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">Contents1</h2>
                <p class="lead">
                    Donec ullamcorper nulla non metus auctor fringilla. 
                    Vestibulum id ligula porta felis euismod semper. 
                    Praesent commodo cursus magna, vel scelerisque nisl consectetur. 
                    Fusce dapibus, tellus ac cursus commodo.
                </p>
            </div>

            <div class="col-md-5">
            </div>
        </div>

        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">Contents2</h2>
                <p class="lead">
                    Donec ullamcorper nulla non metus auctor fringilla. 
                    Vestibulum id ligula porta felis euismod semper. 
                    Praesent commodo cursus magna, vel scelerisque nisl consectetur. 
                    Fusce dapibus, tellus ac cursus commodo.
                </p>
            </div>

            <div class="col-md-5 order-md-1">
            </div>
        </div>

        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">Contents3</h2>
                <p class="lead">
                    Donec ullamcorper nulla non metus auctor fringilla. 
                    Vestibulum id ligula porta felis euismod semper. 
                    Praesent commodo cursus magna, vel scelerisque nisl consectetur. 
                    Fusce dapibus, tellus ac cursus commodo.
                </p>
            </div>

            <div class="col-md-5">
            </div>
        </div>

    </div>
@endsection
