<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BabyLab</title>

        <link rel="icon" type="image/png" href="{{ asset('images/babylab.ico') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        @yield ('head')
    </head>
    <body>
        <header class="text-center">
            <a href="{{ route('babies.index') }}">
                <img class="mb-4" src="{{ asset('images/babylab.svg') }}" alt="" width="72" height="72">
            </a>
        </header>

        @yield ('content')
        
        <footer class="border-top mt-5 mb-5 text-center">
            <div class="mt-5 mb-5 text-muted">&copy; {{ now()->year }}</div>
        </footer>
    </body>
</html>