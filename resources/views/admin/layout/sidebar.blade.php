<!-- Botón para móviles -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-black text-white p-2 rounded-lg shadow-md">
    ☰
</button>

<aside id="sidebar" class="bg-white text-gray-800 w-72 min-h-screen border-r border-gray-200 px-6 py-6 absolute md:relative z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-lg md:shadow-none">
    <!-- Logo y usuario -->
    <div class="text-center mb-4">
        <img src="{{ asset('img/logoblack.png') }}" alt="SETSP" class="w-[140px] mx-auto rounded-lg ">
        <h2 class="text-sm text-gray-500 mt-2 font-semibold">Canhoto Premium</h2>
    </div>

    <nav>
        <ul class="space-y-1">
            <!-- INÍCIO -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition 
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 001 1h3m-10 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                    </svg>
                    <span>Início</span>
                </a>
            </li>

            <!-- GESTÃO DE ASSINATURAS -->
            <li class="text-xs mx-3 py-2 font-bold uppercase text-gray-800 mt-6 mb-2 tracking-wide">
                <span class="p-4">Gestão de Assinaturas</span>
            </li>

            <li>
                <a href="{{ route('admin.plans.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                          {{ request()->routeIs('admin.plans.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>Planos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.payment_methods.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                          {{ request()->routeIs('admin.payment_methods.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 9V7a4 4 0 00-8 0v2H5v11h14V9h-2zM9 7a2 2 0 114 0v2H9V7z"/>
                    </svg>
                    <span>Métodos de Pagamento</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.currencies.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                          {{ request()->routeIs('admin.currencies.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8c-4.418 0-8 1.79-8 4s3.582 4 8 4 8-1.79 8-4-3.582-4-8-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 12c-4.418 0-8 1.79-8 4"/>
                    </svg>
                    <span>Moedas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.subscriptions.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                          {{ request()->routeIs('admin.subscriptions.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 13V6a2 2 0 00-2-2h-4l-2-2-2 2H6a2 2 0 00-2 2v7"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 21h8M12 17v4"/>
                    </svg>
                    <span>Assinaturas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.subscription_history.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                          {{ request()->routeIs('admin.subscription_history.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Histórico</span>
                </a>
            </li>

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
</aside>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("-translate-x-full");
    });
</script>
