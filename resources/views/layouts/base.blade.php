<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald" style="scroll-behavior: smooth;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    @livewireScripts

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="scroll-behavior: smooth;">
    @yield('body')
</body>
@yield('script')

    <script>
        function scrollToSection(event) {
            // Cegah link beraksi secara default jika sudah di halaman home
            if (window.location.pathname === '/' && event.target.href.includes('#')) {
                event.preventDefault();
                const section = event.target.href.split('#')[1];
                document.getElementById(section).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    </script>


</html>
