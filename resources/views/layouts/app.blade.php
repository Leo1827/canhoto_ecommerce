<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="https://garrafeiracanhoto.com/cdn/shop/files/WhatsApp_Image_2021-11-21_at_13.03.06_a15641b8-7c29-48f0-b038-ea89f98c0e4b.jpg?crop=center&height=32&v=1691946283&width=32" type="image/png">
        <title>Canhoto premium</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- preloader-link --}}
        <link rel="stylesheet" href="{{ asset('static/css/style-home.css') }}">

    </head>
    <body class="font-sans antialiased">
        <!-- Preloader -->
        <div id="preloader">
            <div class="loader">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @include('layouts.footer')

        <!-- Script Preloader -->
        <script>
            window.addEventListener('load', () => {
                const preloader = document.getElementById('preloader');
                preloader.classList.add('fade-out');
            });
        </script>
    </body>
</html>
