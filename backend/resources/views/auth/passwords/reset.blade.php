@extends('layouts.app')

@section('content')
<div class="container" style="padding: 8vh 12px;">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">

                <div class="card-body" style="padding: 60px;">
                    <h3 class="text-center m-3"><strong>パスワード再設定</strong></h3>
                    <hr>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email" class="col-form-label"><strong>{{ __('E-Mail Address') }}</strong></label>

                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label"><strong>{{ __('Confirm Password') }}</strong></label>

                            <div>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="color: white; width: 100%; height: 5vh; margin: 5vh 0;">
                                <strong>変更を完了する</strong>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
