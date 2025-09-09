@extends('layouts.front')

@section('meta')
    <meta name="description" content="Loja exclusiva de vinhos finos - Canhoto Premium - Vinhos Exclusivos">
@endsection

@section('title')
    <title>Canhoto Premium - Vinhos Exclusivos</title>
@endsection

@section('style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Cambiar fondo del nav al hacer scroll */
        #navbar.navbar-scrolled {
            background-color: rgba(0, 0, 0, 0.8); /* Fondo oscuro semitransparente */
        }
        
        /* Cambiar color de los links cuando el nav está scrolleado */
        #navbar.navbar-scrolled ul li a {
            color: #fff; /* blanco si quieres */
        }
        
        #navbar.navbar-scrolled ul li a:hover {
            color: #f3f3f3; /* opcional: amarillo al hover */
        }
    
    </style> 
@endsection

@section('content')


    @include('home')

    {{-- about --}}
    <section class="py-20 sm:py-24 bg-white">
        {{-- Título + Párrafo + Imagen --}}
        <div id="vinho" class="max-w-4xl mx-auto text-center px-4">
            <h2 data-aos="fade-up"
                class="text-3xl sm:text-4xl md:text-5xl font-light text-gray-900 mb-6 sm:mb-8">
                A ponte entre grandes vinhos e grandes investimentos.
            </h2>
            <p data-aos="fade-up"
            class="italic text-lg sm:text-xl text-gray-700 mb-6 sm:mb-8 leading-relaxed">
                “Canhoto Premium é uma curadoria exclusiva de vinhos de alto valor, voltada para investidores que reconhecem o potencial de valorização de safras raras, formatos especiais e rótulos icônicos. Oferecemos acesso restrito a oportunidades únicas no mercado internacional de vinhos finos  com procedência garantida, assessoria personalizada e visão patrimonial”
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
            {{-- Benefícios em coluna --}}
            <div class="mt-10 max-w-2xl mx-auto">
                <h4 class="text-2xl font-semibold text-red-800 mb-6 text-center">
                    Benefícios Exclusivos
                </h4>

                <ul class="space-y-6">
                    <li class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-800 text-lg font-bold">
                            ✓
                        </div>
                        <span class="text-gray-800 text-lg">Acesso antecipado a rótulos raros e de alta valorização</span>
                    </li>

                    <li class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-800 text-lg font-bold">
                            ✓
                        </div>
                        <span class="text-gray-800 text-lg">Relatórios exclusivos e análises de mercado sobre vinhos finos</span>
                    </li>

                    <li class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-800 text-lg font-bold">
                            ✓
                        </div>
                        <span class="text-gray-800 text-lg">Conteúdos educativos premium: eBooks, videoaulas e guias práticos</span>
                    </li>

                    <li class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-800 text-lg font-bold">
                            ✓
                        </div>
                        <span class="text-gray-800 text-lg">Convites VIP para eventos, degustações e experiências únicas</span>
                    </li>

                    <li class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-800 text-lg font-bold">
                            ✓
                        </div>
                        <span class="text-gray-800 text-lg">Rede qualificada de investidores e apaixonados por vinho</span>
                    </li>
                </ul>
            </div>

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
                Acesso Exclusivo ao Universo dos Vinhos Finos como Investimento
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
    
    @include('components.verify-age-modal')

@endsection

@section('script')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>

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
