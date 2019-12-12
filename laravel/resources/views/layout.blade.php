<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BabyLab') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/babylab.ico') }}"/>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        @yield ('head')
    </head>
    <body>
        <header class="text-center">
            <div class="container">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        @guest
                            <img class="mb-4" src="{{ asset('images/babylab.svg') }}" alt="" width="72" height="72">
                        @else
                            <a href="{{ route('babies.index') }}">
                                <img class="mb-4" src="{{ asset('images/babylab.svg') }}" alt="" width="72" height="72">
                            </a>
                        @endguest
                    </div>
                    <div class="col-4">
                        @auth
                            <div class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        @yield ('content')
        
        <footer class="border-top mt-5 mb-5 text-center">
            <div class="mt-5 mb-5 text-muted">&copy; {{ now()->year }}</div>
        </footer>
    </body>
</html>