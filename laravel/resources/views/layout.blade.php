<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BabyLab') }}</title>

        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
