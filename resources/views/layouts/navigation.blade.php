<nav class="bg-[#FDFDFC] border-b border-[#E5E7EB] shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-20 items-center">

            <!-- Logo + Links -->
            <div class="flex items-center space-x-10">
                <a href="#">
                    <img src="{{ asset('img/logoblack.png') }}" alt="Canhoto Premium" class="w-[120px]">
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                       class="font-semibold text-sm uppercase tracking-widest transition">
                        Início
                    </a>
                    <a href="#"
                       class="font-semibold text-sm uppercase tracking-widest transition">
                        Catálogo
                    </a>
                    <a href="#"
                       class="font-semibold text-sm uppercase tracking-widest transition">
                        Meus Pedidos
                    </a>
                    <a href="#"
                       class="font-semibold text-sm uppercase tracking-widest transition">
                        Meu Perfil
                    </a>
                </div>
            </div>
            
            <!-- nav + Carrinho + Usuário -->
            @include('components.menu-order-items')
        </div>
    </div>
</nav>
