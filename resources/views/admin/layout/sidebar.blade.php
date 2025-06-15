<!-- btn movil -->
<button id="menu-toggle" class="md:hidden text-[#fff] p-2 rounded absolute top-4 left-4 z-20">
    ☰
</button>

<aside id="sidebar" class="bg-[#F5F7F9] text-white w-72 min-h-screen p-4 absolute md:relative z-10 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="text-center mb-6 mt-4">
        {{-- Logo --}}
        <img src="{{ asset('img/logoblack.png') }}" alt="SETSP" class="w-[150px] mx-auto rounded-xl shadow-md">
        <h2 class="text-sm text-[#333] font-semibold mt-2 my-4">Canhoto Premium - {{ Auth::user()->name }}</h2>
    </div>
    <nav>
        <ul class="space-y-1 px-4">
            {{-- INÍCIO --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                    {{ request()->routeIs('admin.dashboard') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 001 1h3m-10 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                    </svg>
                    <span>Início</span>
                </a>
            </li>

            {{-- ========================= --}}
            {{-- GESTÃO DE ASSINATURAS --}}
            {{-- ========================= --}}
            <li class="text-xs py-4 text-gray-500 uppercase px-6 mt-6">Gestão de Assinaturas</li>

                {{-- Planos --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.plans.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <span>Planos</span>
                    </a>
                </li>

                {{-- Métodos de Pagamento --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.payment_methods.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a4 4 0 00-8 0v2H5v11h14V9h-2zM9 7a2 2 0 114 0v2H9V7z"/>
                        </svg>
                        <span>Métodos de Pagamento</span>
                    </a>
                </li>

                {{-- Assinaturas --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.subscriptions.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2h-4l-2-2-2 2H6a2 2 0 00-2 2v7"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 21h8M12 17v4"/>
                        </svg>
                        <span>Assinaturas</span>
                    </a>
                </li>

                {{-- Moedas --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.currencies.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-4.418 0-8 1.79-8 4s3.582 4 8 4 8-1.79 8-4-3.582-4-8-4z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12c-4.418 0-8 1.79-8 4"/>
                        </svg>
                        <span>Moedas</span>
                    </a>
                </li>

                {{-- Histórico --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.subscription_history.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Histórico</span>
                    </a>
                </li>

            {{-- ====================== --}}
            {{-- GESTÃO DA LOJA --}}
            {{-- ====================== --}}
            <li class="text-xs py-4 text-gray-500 uppercase px-6 mt-6">Gestão da Loja</li>

                {{-- Categorias --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.categories.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        <span>Categorias</span>
                    </a>
                </li>

                {{-- Produtos --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.products.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 12H4"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 6H4m16 12H4"/>
                        </svg>
                        <span>Produtos</span>
                    </a>
                </li>

                {{-- Pedidos --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.orders.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h18v4H3V3zm0 6h18v12H3V9zm5 3h2v2H8v-2z"/>
                        </svg>
                        <span>Pedidos</span>
                    </a>
                </li>

                {{-- Pagamentos de Usuários --}}
                <li>
                    <a href=""
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm 
                        {{ request()->routeIs('admin.user_payments.*') ? 'bg-[#000] text-white shadow' : 'text-[#333] hover:bg-[#000] hover:text-white' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2m0 0c1.1 0 2-.9 2-2s-.9-2-2-2zm0 4v4"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                        <span>Pagamentos</span>
                    </a>
                </li>

                {{-- SAIR --}}
                <li class="mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button onclick="event.preventDefault(); this.closest('form').submit();"
                                class="w-full text-left flex items-center gap-2 px-6 py-5 rounded-xl text-sm text-red-600 hover:bg-red-100 hover:text-red-800">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
    document.getElementById("menu-toggle").addEventListener("click", function() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("-translate-x-full");
    });
</script>
