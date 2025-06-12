<!-- btn movil -->
<button id="menu-toggle" class="md:hidden text-[#fff] p-2 rounded absolute top-4 left-4 z-20">
    ☰
</button>

<aside id="sidebar" class="bg-[#F5F7F9] text-white w-72 min-h-screen p-4 absolute md:relative z-10 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="text-center mb-6">
        {{-- Logo --}}
        <img src="{{ asset('img/logo.png') }}" alt="SETSP" class="w-[60px] mx-auto rounded-xl shadow-md">
        <h2 class="text-lg text-[#333] font-semibold mt-2">SETSP</h2>
    </div>
    <nav>
        <ul class="space-y-1 px-4">
            {{-- INICIO --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 px-6 py-5 rounded-xl text-sm 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 001 1h3m-10 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                    </svg>
                    <span>Inicio</span>
                </a>

            </li>

            {{-- PRUEBAS --}}
            <li>
                <a href="{{ route('admin.test') }}"
                class="flex items-center gap-2 px-6 py-5 rounded-xl text-sm 
                        {{ request()->routeIs('admin.test') 
                        || request()->routeIs('admin.test.create') 
                        || request()->routeIs('admin.test.edit') 
                        || request()->routeIs('admin.test.questions.index')
                        ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m-6-8h6M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6"/>
                    </svg>
                    <span>Pruebas</span>
                </a>

            </li>

            {{-- RESULTADOS --}}
            <li>
                <a href="{{ route('admin.result') }}"
                class="flex items-center gap-2 px-6 py-5 rounded-xl text-sm
                        {{ request()->routeIs('admin.result')
                        || request()->routeIs('admin.result.show') 
                        ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 13l3 3 7-7" />
                    </svg>
                    <span>Resultados</span>
                </a>
            </li>


            {{-- CERRAR SESIÓN --}}
            <li>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </li>
        </ul>

    </nav>
</aside>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("-translate-x-full");
    });
</script>
