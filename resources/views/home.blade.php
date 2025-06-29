<section class="relative h-screen w-full overflow-hidden">

    {{-- Video en todas las pantallas --}}
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover videohome">
        <source src="https://videos.pexels.com/video-files/3779636/3779636-hd_1920_1080_25fps.mp4" type="video/mp4">
    </video>

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-white bg-opacity-50"></div>

    {{-- Navbar --}}
    <nav id="navbar"
         class="fixed top-0 left-0 right-0 flex justify-center items-center px-6 md:px-10 py-5 z-20">

        <div class="flex items-center space-x-14">

            {{-- Menú izquierdo (solo desktop) --}}
            <ul class="hidden md:flex space-x-10 text-sm uppercase tracking-widest text-gray-700">
                <li><a href="#vinho" class="hover:text-black">Historia</a></li>
                <li><a href="#contato" class="hover:text-black">Contato</a></li>
            </ul>

            {{-- Logo --}}
            <div class="text-2xl font-serif font-semibold text-gray-900">
                <a href="#home">
                    <img src="{{ asset('img/logoblack.png') }}" alt="Canhoto Premium" class="w-[200px]">
                </a>
            </div>

            {{-- Menú derecho (solo desktop) --}}
            <ul class="hidden md:flex space-x-10 text-sm uppercase tracking-widest text-gray-700">
                <li><a href="{{ route('login') }}" class="hover:text-black">Conecte-se</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-black">Registar</a></li>
            </ul>

            {{-- Botón hamburguesa (solo mobile) --}}
            <div class="md:hidden">
                <button id="menu-btn" class="text-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Menu mobile desplegable --}}
    <div id="mobile-menu"
         class="hidden md:hidden fixed top-20 right-6 bg-white shadow-lg rounded-xl px-6 py-4 z-30">
        <a href="#historia"
           class="block py-2 text-sm uppercase tracking-widest text-gray-700 hover:text-black">Historia</a>
        <a href="#contato"
           class="block py-2 text-sm uppercase tracking-widest text-gray-700 hover:text-black">Contato</a>
        <a href="{{ route('login') }}"
           class="block py-2 text-sm uppercase tracking-widest text-gray-700 hover:text-black">Conectse-se</a>
        <a href="#contato"
           class="block py-2 text-sm uppercase tracking-widest text-gray-700 hover:text-black">Registar</a>
    </div>

    {{-- Contenido central --}}
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 data-aos="fade-up"
            class="text-3xl sm:text-4xl md:text-5xl font-serif italic text-gray-800 mb-6 leading-tight">
            Exclusividade. Coleções Limitadas. Excelência.
        </h1>
        <a data-aos="fade-up"
           href="{{ route('login') }}"
           class="border border-gray-800 text-gray-800 rounded-full hover:bg-gray-800 hover:text-white px-8 py-3 uppercase text-sm tracking-widest transition">
            Descobrir
        </a>
    </div>

    {{-- Flecha scroll --}}
    <div class="absolute bottom-6 left-0 right-0 flex justify-center animate-bounce z-10">
        <a href="#vinho">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-800" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</section>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>