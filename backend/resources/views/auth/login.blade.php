@extends('layouts.app')

@section('content')
<div class="container" style="padding: 8vh 12px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body" style="padding: 60px;">
                    <h3 class="text-center m-3"><strong>ログイン</strong></h3>
                    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="col-form-label"><strong>{{ __('E-Mail Address') }}</strong></label>

                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="info@focus">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label"><strong>{{ __('Password') }}</strong></label>

                            <div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="color: white; width: 100%; height: 5vh; margin: 5vh 0;">
                                <strong>{{ __('Login') }}</strong>
                            </button>
                        </div>


                        
                            <div class="form-check text-center">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    ログインしたままにする
                                </label>
                            </div>
                        

                        
                            <div class="mt-5 text-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        パスワードを忘れた方
                                    </a>
                                @endif
                            </div>
    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
