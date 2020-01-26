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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div id="left" class="column">
        <div class="top-left"></div>
        <div class="bottom"> TEST TEST</div>
    </div>
    <div id="right" class="column">
        <div class="top-right"></div>
        <div class="bottom">

            <main class="py-4">
                <div class="container">
                    this is a test?
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <div class="column" style="background-color: red">test 1/div>
    <div class="column" style="background-color: grey"> test 2</div>


</div>
</body>
</html>
