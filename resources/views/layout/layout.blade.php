<!DOCTYPE html>
<html lang="ka" class="js">
<head>
    <title>DevLion CMS V 1.0</title>
    <meta charset="utf-8">
    <meta name="author" content="Foxes">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ url('/assets/css/dashlite.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">

    @yield('css')
</head>
<body class="nk-body npc-invest bg-lighter ">
    <div class="nk-app-root">
        <div class="nk-wrap ">
            @include('include.header')
            @yield('content')
            @include('include.footer')
        </div>
    </div>
    <script src="{{ url('/assets/js/bundle.js') }}"></script>
    <script src="{{ url('/assets/js/scripts.js') }}"></script>
    @yield('js')
</body>
</html>