<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '20 Cafés Fórum') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-color: $body-bg">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', '20 Cafés Fórum') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-link">Welcome to the forum!</li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{-- @if (Route::has('register')) --}}
                                <li class="nav-item">
                                    <a class="btn btn-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            {{-- @endif --}}
                        @else
                        @yield('adminbuttons')
                        <?php
                            if ( ( Auth::user()->user_role ) == 1 ) {
                                echo '
                                    <a href="
                                '; ?>
                                    {{ route('adminpanel') }}
                                <?
                                echo '
                                    " class="mr-2 btn btn-warning">Admin Control Panel</a>
                                ';
                            }
                        ?>
                            <li class="nav-item dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->user_realname }}<span class="caret"></span>
                                </button>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <p class="dropdown-header">
                                        
                                        <?php
                                            if ( ( Auth::user()->user_role ) == 0 ) {
                                                    echo '<span class="pb-0 badge badge-success">USER</span>';
                                                }

                                            if ( ( Auth::user()->user_role ) == 1 ) {
                                                echo '<span class="pb-0 badge badge-warning">ADMIN</span>';
                                            }
                                        ?>
                                        
                                        {{ Auth::user()->username }}</p>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('home') }}" class="dropdown-item">My Profile</a>

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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
