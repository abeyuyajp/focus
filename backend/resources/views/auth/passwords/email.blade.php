@extends('layouts.app')

@section('content')
<div class="container" style="padding: 8vh 12px;">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">

                <div class="card-body" style="padding: 60px;">
                    <h3 class="text-center m-3"><strong>再設定メール送信</strong></h3>
                    <p class="text-muted text-center">入力していただいたメールアドレス宛に再設定のご案内メールが届きます。</p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mt-5">
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="メールアドレス" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            
                                <button type="submit" class="btn btn-primary" style="color: white; width: 100%; height: 5vh; margin: 5vh 0;">
                                    <strong>送信する</strong>
                                </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
