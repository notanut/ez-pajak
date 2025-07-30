<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EzPajak')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    {{-- <!-- <link rel="stylesheet" href="{{asset('css/homepage.css')}}"> --> --}}

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
     @vite(['resources/css/app.css', 'resources/css/homepage.css', 'resources/js/app.js'])
</head>
<body data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
    @auth
        @include('layouts.partials.navbarAfterLogin')
    @endauth

    @guest
        @include('layouts.partials.navbarBeforeLogin')
    @endguest


        @yield('content')


    @include('layouts.partials.footer')

    @stack('scripts')
</body>

</html>
