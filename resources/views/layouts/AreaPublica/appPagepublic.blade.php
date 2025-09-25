<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EnglishLink - Aprende Inglés')</title>
    <meta name="description" content="@yield('description', 'Academia de inglés líder en Colombia. Aprende inglés con profesores nativos y metodología innovadora.')">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public-pages.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @include('layouts.AreaPublica.header')

    @yield('content')

    @include('layouts.AreaPublica.footer')

    <script src="{{ asset('js/homepage.js') }}"></script>
    @stack('scripts')
</body>
</html>
