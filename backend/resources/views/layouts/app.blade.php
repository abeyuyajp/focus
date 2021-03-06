<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.webrtc.ecl.ntt.com/skyway-4.4.1.js"></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <!-- Bootstrap -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- カスタマイズ -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
</head>
  <body>
      <div id="app">
          <nav class="navbar navbar-expand-lg navbar-light bg-navy text-white">
              <div class="container">
                  <a class="navbar-brand text-white" href="{{ url('/') }}">
                      {{ config('app.name', 'Laravel') }}
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">
                      @if (Auth::check())
                      <ul class="navbar-nav ml-auto">
                              <!-- セッション一覧 -->
                              <li class="nav-item ml-auto">
                                  <a class="nav-link text-white h5" href="{{ url('/') }}">
                                      <i class="fas fa-search"></i>
                                      探す
                                  </a>
                              </li>
                              <!-- end -->

                              <!-- カレンダー -->
                              <li class="nav-item ml-auto">
                                  <a class="nav-link text-white h5" href="{{ url('/calendar') }}">
                                      <i class="fas fa-tv"></i>
                                      セッション
                                  </a>
                              </li>
                              <!-- end -->
                      </ul>
                      @endif
                      <ul class="navbar-nav ml-auto">
                          @guest
                              <li class="nav-item active ml-auto">
                                  <a class="btn btn-outline-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                              </li>
                              @if (Route::has('register'))
                                  <li class="nav-item ml-auto">
                                      <a class="btn ml-2 text-white" href="{{ route('register') }}" style="background-color: #1976d2;">{{ __('Register') }}</a>
                                  </li>
                              @endif
                          @else
                              <!-- 通知 -->
                              <li class="nav-item ml-auto">
                                  <notification-component :current_user="{{Auth::user()}}"></notification-component>
                              </li>
                              <!-- end -->

                              <!-- ユーザー情報 -->
                              <li class="nav-item dropdown ml-auto">
                                  <a class="nav-link text-white h5" href="{{ url('/user/edit') }}">
                                      @if(!empty(Auth::user()->profile_image))
                                          <img src="{{ Auth::user()->profile_image }}"  width="30px" height="30px" style="border-radius: 100%;">
                                      @else
                                          <i class="far fa-user-circle"></i>
                                      @endif
                                      {{ Auth::user()->name }} <span class="caret"></span>
                                  </a>
                              </li>
                              <!-- end -->
                          @endguest
                      </ul>
                  </div>
              </div>
          </nav>
          <main class="py-4">
              @yield('content')
          </main>
      </div>
  </body>
</html>
