<!-- Botón para móviles -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-black text-white p-2 rounded-lg shadow-md">
    ☰
</button>

<aside id="sidebar" class="bg-white text-gray-800 w-72 min-h-screen border-r border-gray-200 px-4 py-6 absolute md:relative z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-lg md:shadow-none">
    <div class="h-full overflow-y-auto pr-2">

        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="{{ asset('img/logoblack.png') }}" class="w-32 mx-auto">
            <p class="text-sm text-gray-500 mt-2 font-semibold">Canhoto Premium</p>
        </div>

        <nav class="space-y-2 text-sm font-medium">

            <!-- Dashboard -->
            <x-admin.sidebar.link route="admin.dashboard" icon="home" label="Início" />
            
            <!-- Menú 1: Assinaturas -->
            <x-admin.sidebar.section title="Gestão de Assinaturas">
                @include('admin.components.main-one-sidebar')
            </x-admin.sidebar.section>

            <!-- Menú 2: Loja -->
            <x-admin.sidebar.section title="Loja exclusiva">
                @include('admin.components.main-two-sidebar')
            </x-admin.sidebar.section>

            <!-- Menú 3: Facturación -->
            <x-admin.sidebar.section title="Facturación">
                @include('admin.components.main-three-sidebar')
            </x-admin.sidebar.section>

            <!-- Menú 4: Configuracion -->
            <x-admin.sidebar.section title="Configuracion">
                @include('admin.components.main-four-sidebar')
            </x-admin.sidebar.section>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button onclick="event.preventDefault(); this.closest('form').submit();" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-100 hover:text-red-800 rounded-md transition">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                    <span>Sair</span>
                </button>
            </form>
        </nav>
    </div>
</aside>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("-translate-x-full");
    });
</script>
