<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EzPajak')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/paypage.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/homepage.css')}}">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- JS --}}
    <script src="{{ asset('js/paypage.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.partials.navbarAfterLogin')

        @yield('content')


    @include('layouts.partials.footer')

    @stack('scripts')
</body>

</html>
