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
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

    </head>
    <body class="font-sans antialiased" x-data x-init="$store.cart.loadCart()">
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

            <!-- Preloader reactivo para acciones del carrito -->
            <div
                x-show="$store.cart.loadingCart || $store.cart.loadingAdd || $store.cart.loadingUpdateId !== null || $store.cart.loadingRemoveId !== null"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-[9999] bg-white/100 flex items-center justify-center"
                style="backdrop-filter: blur(4px);"
            >
                <div class="flex flex-col items-center gap-4">
                    <svg class="animate-spin h-10 w-10 text-[#9B1C1C]" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z" />
                    </svg>
                    <span class="text-[#9B1C1C] font-medium text-lg">Procesando...</span>
                </div>


            </div>

        </div>

        @include('layouts.footer')

        <!-- Script Preloader -->
        <script>
            window.addEventListener('load', () => {
                const preloader = document.getElementById('preloader');
                preloader.classList.add('fade-out');
            });
        </script>
        <script>
            function updateMainImage(src) {
                const mainImage = document.getElementById('main-product-image');
                mainImage.src = src;
            }
        </script>

    </body>

</html>
