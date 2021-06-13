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
        <nav class="navbar navbar-expand-md navbar-light bg-navy shadow-sm text-white">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    @if (Auth::check() )
                    <ul class="navbar-nav ml-auto">
                        <notification-component :current_user="{{Auth::user()}}"></notification-component>
                    @endif
                        <!--li class="dropdown">
                            <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-user"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                                <li class="dropdown-header">No notifications</li>
                            </ul>
                        </li-->

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid pl-0">
            <div class="row">
                <nav id="sidebarMenu" class="col-1 d-md-block bg-navy sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item mb-5 mt-5 text-center" >
                                <a class="text-white link-none" href="{{ url('/') }}">
                                    <i class="far fa-edit fa-2x"></i>
                                    <p><strong>セッション</strong></p>
                                </a>
                            </li>
                            <li class="nav-item mb-5 mt-5 text-center">
                                <a class="text-white link-none" href="{{ url('/calendar') }}">
                                    <i class="far fa-calendar-alt fa-2x "></i>
                                    <p><strong>カレンダー</strong></p>
                                </a>
                            </li>
                            <li class="nav-item mb-5 mt-5 text-center">
                                <a  class="text-white link-none" href="#">
                                    <i class="far fa-user fa-2x"></i>
                                    <p><strong>マイページ</strong></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9  py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
