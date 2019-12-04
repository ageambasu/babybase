<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BabyLab</title>

        <link rel="icon" type="image/png" href="{{ asset('media/images/babylab.ico') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('media/css/app.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <header class="text-center">
            <img class="mb-4" src="{{ asset('media/images/babylab.svg') }}" alt="" width="72" height="72">
        </header>

        @yield ('content')
        
        <footer class="border-top mt-5 mb-5 text-center">
            <div class="mt-5 mb-5 text-muted">&copy; {{ now()->year }}</div>
        </footer>
    </body>
</html>