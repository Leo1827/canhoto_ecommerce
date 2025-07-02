<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" >
        
        <link rel="icon" href="https://garrafeiracanhoto.com/cdn/shop/files/WhatsApp_Image_2021-11-21_at_13.03.06_a15641b8-7c29-48f0-b038-ea89f98c0e4b.jpg?crop=center&height=32&v=1691946283&width=32" type="image/png">
        {{-- Meta for seo --}}
        @yield('meta')

        {{-- Title --}}
        @yield('title')

        {{-- Style --}}
        @yield('style')
        @stack('styles')

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://fonts.bunny.net/css\family=figtree:400,500,600&display=s">

        {{-- Script  --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- preloader-link --}}
        <link rel="stylesheet" href="{{ asset('static/css/style-home.css') }}">
    </head>
    {{-- Color de fondo add --}}
    <body class="font-sans  text-white antialiased">
        
        <!-- Preloader -->
        <div id="preloader">
            <div class="loader">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- Script Preloader -->
        <script>
            window.addEventListener('load', () => {
                const preloader = document.getElementById('preloader');
                preloader.classList.add('fade-out');
            });
        </script>
        {{-- content --}}
        @yield('content')

        {{-- script --}}
        @yield('script')

        @include('layouts.footer')

        @stack('scripts')
        
    </body>
</html>