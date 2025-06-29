@extends('layouts.front')

@section('meta')
    <meta name="description" content="Loja exclusiva de vinhos finos - Canhoto Premium - Vinhos Exclusivos">
@endsection

@section('title')
    <title>Canhoto Premium - Vinhos Exclusivos</title>
@endsection

@section('style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/css/style-home.css') }}">

@endsection

@section('content')

{{-- Preloader --}}
<div id="preloader">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<section class="relative h-screen w-full overflow-hidden">
@include('home')

{{-- about --}}
<section class="py-20 sm:py-24 bg-white">
    {{-- Título + Párrafo + Imagen --}}
    <div id="vinho" class="max-w-4xl mx-auto text-center px-4">
        <h2 data-aos="fade-up"
            class="text-3xl sm:text-4xl md:text-5xl font-light text-gray-900 mb-6 sm:mb-8">
            Uma visão. Um vinho.
        </h2>
        <p data-aos="fade-up"
        class="italic text-lg sm:text-xl text-gray-700 mb-6 sm:mb-8 leading-relaxed">
            “Para mim, o vinho é paixão. É família e amigos. É calor de coração e generosidade de espírito.”
        </p>

        <div class="flex justify-center">
            <a href="{{ route('register') }}"
            class="uppercase text-sm tracking-widest border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white px-6 py-2 rounded-full transition duration-300">
                Registrar Canhoto Premium
            </a>
        </div>
    </div>

    {{-- Imagen + Texto lateral --}}
    <div class="max-w-6xl mx-auto mt-16 sm:mt-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center px-4 sm:px-6">
        {{-- Imagen --}}
        <div data-aos="fade-right">
            <img src="https://images.pexels.com/photos/7282935/pexels-photo-7282935.jpeg"
                alt="Imagem"
                class="w-full rounded-xl shadow-md">
        </div>
        {{-- Texto --}}
        <div data-aos="fade-left">
            <h3 class="text-2xl sm:text-3xl font-serif text-gray-900 mb-4 sm:mb-6">
                Uma expressão de tempo e lugar
            </h3>
            <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                A essência do tempo é expressa no Opus One pelo carácter de cada colheita.
                O lugar, frequentemente definido como terroir, representa a geografia, o clima
                e o elemento humano essencial que é captado no equilíbrio do vinho entre potência
                e finesse, estrutura e textura.
            </p>

            {{-- Imagen debajo del párrafo --}}
            <div data-aos="" class="my-12 sm:mb-8">
                <img src="https://images.pexels.com/photos/5538318/pexels-photo-5538318.jpeg"
                    alt="Vinho"
                    class="w-full max-w-3xl mx-auto rounded-xl shadow-md">
            </div>
        </div>
                    
    </div>
</section>

{{-- Video inferior --}}
<section class="relative h-[320px] sm:h-[420px] md:h-72 w-full overflow-hidden">
    {{-- Video --}}
    <video autoplay muted loop playsinline
        class="absolute inset-0 w-full h-full object-cover">
        <source src="https://videos.pexels.com/video-files/6356806/6356806-hd_1920_1080_30fps.mp4" type="video/mp4">
    </video>

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    {{-- Contenido --}}
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h2 data-aos="fade-up"
            class="text-3xl sm:text-4xl md:text-5xl font-serif italic text-white mb-6 sm:mb-8">
            Exceptional California terroir
        </h2>
        <a href="#"
        class="border border-white text-white hover:bg-white hover:text-black px-8 py-3 uppercase text-sm tracking-widest transition">
            View
        </a>
    </div>
</section>

<button id="backToTop" class="hidden fixed bottom-6 right-6 bg-gray-900 text-white p-3 rounded-full shadow-lg hover:bg-black transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
    </svg>
</button>

@endsection

@section('script')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Preloader
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('fade-out');
        });

        // Navbar scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // AOS
        AOS.init({
            duration: 1200,
            once: true,
            easing: 'ease-in-out',
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

    </script>
@endsection
