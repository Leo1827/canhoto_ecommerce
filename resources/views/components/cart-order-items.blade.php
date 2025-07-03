<div class="flex items-center space-x-6" x-data="{ openCart: false }">
    <!-- Usuário -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
                class="flex items-center space-x-2 text-[#4B0D0D] hover:text-[#9B1C1C] font-medium focus:outline-none">
            <span class="text-sm">{{ Auth::user()->name }}</span>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.585l3.71-3.355a.75.75 0 111.04 1.08l-4.25 3.85a.75.75 0 01-1.04 0L5.21 8.29a.75.75 0 01.02-1.08z"
                        clip-rule="evenodd"/>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white border border-[#E5E7EB] rounded-xl shadow-lg z-50">
            <a href="#"
                class="block px-4 py-2 text-sm text-[#4B0D0D] hover:bg-[#F9F4F4] rounded-t-xl">
                Perfil
            </a>
            <a href="#"
                class="block px-4 py-2 text-sm text-[#4B0D0D] hover:bg-[#F9F4F4]">
                Meus Pedidos
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-[#9B1C1C] hover:bg-[#F9F4F4] rounded-b-xl">
                    Sair
                </button>
            </form>
        </div>
    </div>
    <button @click="openCart = true" class="relative">
        <svg class="w-6 h-6 text-[#4B0D0D] hover:text-[#9B1C1C] transition" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7H19M7 13l1.5-7h8l1.5 7"/>
        </svg>
        <span class="absolute -top-2 -right-2 bg-[#9B1C1C] text-white rounded-full text-[10px] px-1">
            3
        </span>
    </button>

    <!-- Sidebar do Carrinho -->
    <div class="fixed inset-0 z-50" x-show="openCart" style="display: none;">
        <!-- Fundo escuro COMPLETO -->
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm" @click="openCart = false"></div>

        <!-- Conteúdo -->
        <div class="absolute right-0 top-0 h-full w-96 bg-[#FDFDFC] shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#E5E7EB]">
                <h2 class="text-lg font-semibold text-[#4B0D0D]">Meu Carrinho</h2>
                <button @click="openCart = false">
                    <svg class="w-6 h-6 text-[#4B0D0D] hover:text-[#9B1C1C]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Itens do Carrinho -->
            <div class="flex-1 overflow-y-auto">
                <!-- Produto 1 -->
                <div class="flex px-6 py-4 border-b border-[#E5E7EB] relative">
                    <!-- Imagen -->
                    <img src="{{ asset('img/product1.jpeg') }}"
                        alt="Vinho 1" class="w-16 h-20 object-cover rounded-xl">

                    <!-- Info -->
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-[#4B0D0D]">Chateau Lafite Rothschild</h3>
                        <p class="text-xs text-[#6B4F4F]">Safra 1998</p>

                        <!-- Controles -->
                        <div class="flex items-center justify-between mt-2">
                            <!-- Cantidad -->
                            <div class="flex items-center space-x-2">
                                <button class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">
                                    -
                                </button>
                                <span class="text-sm text-[#4B0D0D]">1</span>
                                <button class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">
                                    +
                                </button>
                            </div>
                            <!-- Precio unitario -->
                            <span class="text-sm text-[#4B0D0D]">R$ 1.200</span>
                        </div>

                        <!-- Subtotal -->
                        <div class="text-right text-xs text-[#6B4F4F]">Subtotal: R$ 1.200</div>
                    </div>

                    <!-- Botón eliminar -->
                    <button class="absolute top-2 right-4 text-[#9B1C1C] hover:text-[#7C1616]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Produto 2 -->
                <div class="flex px-6 py-4 border-b border-[#E5E7EB] relative">
                    <!-- Imagen -->
                    <img src="{{ asset('img/product2.jpeg') }}"
                        alt="Vinho 2" class="w-16 h-20 object-cover rounded-xl">

                    <!-- Info -->
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-[#4B0D0D]">Sassicaia Bolgheri</h3>
                        <p class="text-xs text-[#6B4F4F]">Safra 2015</p>

                        <!-- Controles -->
                        <div class="flex items-center justify-between mt-2">
                            <!-- Cantidad -->
                            <div class="flex items-center space-x-2">
                                <button class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">
                                    -
                                </button>
                                <span class="text-sm text-[#4B0D0D]">2</span>
                                <button class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">
                                    +
                                </button>
                            </div>
                            <!-- Precio unitario -->
                            <span class="text-sm text-[#4B0D0D]">R$ 950</span>
                        </div>

                        <!-- Subtotal -->
                        <div class="text-right text-xs text-[#6B4F4F]">Subtotal: R$ 1.900</div>
                    </div>

                    <!-- Botón eliminar -->
                    <button class="absolute top-2 right-4 text-[#9B1C1C] hover:text-[#7C1616]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Total -->
            <div class="px-6 py-4 border-t border-[#E5E7EB]">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-[#4B0D0D] font-medium">Total</span>
                    <span class="text-lg font-semibold text-[#4B0D0D]">R$ 4.900</span>
                </div>
                <a href="#"
                    class="block w-full px-4 py-2 text-center bg-[#9B1C1C] text-white rounded-lg hover:bg-[#7C1616] transition">
                    Finalizar Compra
                </a>
                <button @click="openCart = false"
                    class="w-full mt-3 px-4 py-2 border border-[#9B1C1C] text-[#9B1C1C] rounded-lg hover:bg-[#F9F4F4] transition">
                    Continuar Comprando
                </button>
            </div>
        </div>
    </div>
</div>