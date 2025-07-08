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
                <li><a href="#vinho" class="hover:text-black">História</a></li>
                <li><a href="#contato" class="hover:text-black">Contato</a></li>
            </ul>

            {{-- Logo --}}
            <div class="text-2xl font-serif font-semibold text-gray-900">
                <a href="/">
                    <img src="{{ asset('img/logoblack.png') }}" alt="Canhoto Premium" class="w-[200px]">
                </a>
            </div>

            {{-- Menú derecho (solo desktop) --}}
            <ul class="hidden md:flex space-x-10 text-sm uppercase tracking-widest text-gray-700">
                @auth
                    @if(Auth::user()->usertype == 'user')
                        <li><a href="{{ route('products.user.store') }}" class="hover:text-black">Loja</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-black">Perfil</a></li>
                    @elseif(Auth::user()->usertype == 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-black">Administração</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-black">Perfil</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="hover:text-black"
                            onclick="event.preventDefault();this.closest('form').submit();">
                                Sair
                            </a>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-black">Conecte-se</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-black">Registar</a></li>
                @endauth
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
    <!-- Menú Mobile Desplegable -->
    <div id="mobile-menu"
        class="hidden fixed top-20 left-6 right-6 bg-white bg-opacity-90 backdrop-blur-md shadow-2xl rounded-3xl px-8 py-6 z-50">

        <ul class="space-y-4 text-center">
            <li><a href="#vinho"
                class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                História</a></li>
            <li><a href="#contato"
                class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                Contato</a></li>

            @auth
                @if(Auth::user()->usertype == 'user')
                    <li><a href="{{ route('products.user.store') }}"
                        class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                        Loja</a></li>
                    <li><a href="{{ route('profile.edit') }}"
                        class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                        Perfil</a></li>
                @elseif(Auth::user()->usertype == 'admin')
                    <li><a href="{{ route('admin.dashboard') }}"
                        class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                        Administração</a></li>
                    <li><a href="{{ route('profile.edit') }}"
                        class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                        Perfil</a></li>
                @endif

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                        class="block text-sm uppercase tracking-widest text-[#9B1C1C] hover:text-[#7C1616] font-semibold"
                        onclick="event.preventDefault();this.closest('form').submit();">
                            Sair
                        </a>
                    </form>
                </li>

            @else
                <li><a href="{{ route('login') }}"
                    class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                    Conecte-se</a></li>
                <li><a href="{{ route('register') }}"
                    class="block text-sm uppercase tracking-widest text-gray-800 hover:text-[#4B0D0D] font-medium">
                    Registar</a></li>
            @endauth
        </ul>
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