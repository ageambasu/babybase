<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BabyLab') }}</title>

        <script src="{{ asset('js/app.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/babylab.ico') }}"/>

        <script type="text/javascript">
            $(document).ready(function () {
                var url = window.location;
                $('ul.navbar-nav a[href="'+ url +'"]').parent().addClass('active');
                $('ul.navbar-nav a').filter(function() {
                    return this.href == url;
                }).parent().addClass('active');
            });
        </script>

        @yield ('head')
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="col-3"></div>
            <div class="col-6 text-center">
                @guest
                    <img class="mb-4" src="{{ asset('images/babylab.svg') }}" alt="" width="72" height="72">
                @else
                    <a href="{{ route('babies.index') }}">
                        <img class="mb-4" src="{{ asset('images/babylab.svg') }}" alt="" width="72" height="72">
                    </a>
                @endguest
            </div>
            <div class="col-3"></div>
        </nav>

        @auth
            <nav class="navbar navbar-expand-md navbar-light bg-light mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <div class="dropdown">
                                    <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('babies.index')}}">Babies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('studies.index')}}">Studies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('appointments.index')}}">Appointments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('signups.index')}}">Signups</a>
                                    </li>
                                    @if (Auth::user()->isAdmin())
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('users.index')}}">Users</a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->isAdmin())
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('languages.index')}}">Languages</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        @endauth

        @yield ('content')

        <footer class="border-top mt-5 mb-5 text-center">
            <div class="mt-5 mb-5 text-muted">&copy; {{ now()->year }}</div>

            @guest
                <div class="mb-5 text-muted">
                    <p><small>Developed by <a style="color:#9b9595" href="https://www.albertonieto.info/" target="_blank">albertonieto.info.</a></small></p>
                </div>
            @endguest
        </footer>
    </body>
</html>
