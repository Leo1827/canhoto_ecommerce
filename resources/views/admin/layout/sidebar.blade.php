<!-- Botón para móviles -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-black text-white p-2 rounded-lg shadow-md">
    ☰
</button>

<aside id="sidebar" class="bg-white text-gray-800 w-72 min-h-screen border-r border-gray-200 px-6 py-6 absolute md:relative z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-lg md:shadow-none">
    
    <!-- Contenedor con scroll -->
    <div class="h-full overflow-y-auto pr-2 custom-scroll">

        <!-- Logo y usuario -->
        <div class="text-center mb-4">
            <img src="{{ asset('img/logoblack.png') }}" alt="SETSP" class="w-[140px] mx-auto rounded-lg">
            <h2 class="text-sm text-gray-500 mt-2 font-semibold">Canhoto Premium</h2>
        </div>

        <nav>
            <ul class="space-y-1">
                @include('admin.components.main-one-sidebar')

                <!-- GESTÃO DE ASSINATURAS -->
                <li class="text-xs mx-3 py-2 font-bold uppercase text-gray-800 mt-6 mb-2 tracking-wide">
                    <span class="p-4">Loja exclusiva</span>
                </li>

                @include('admin.components.main-two-sidebar')

                <!-- SAIR -->
                <li class="mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button onclick="event.preventDefault(); this.closest('form').submit();"
                                class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-md text-sm text-red-600 hover:bg-red-100 hover:text-red-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                            </svg>
                            <span>Sair</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("-translate-x-full");
    });
</script>
