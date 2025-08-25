<div class="flex items-center space-x-6" x-data="{ openCart: false }">
    <!-- Usuário -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
                class="flex items-center space-x-2 text-[#4B0D0D] hover:text-[rgb(155,28,28)] font-medium focus:outline-none">
            <span class="text-sm">{{ Auth::user()->name }}</span>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.585l3.71-3.355a.75.75 0 111.04 1.08l-4.25 3.85a.75.75 0 01-1.04 0L5.21 8.29a.75.75 0 01.02-1.08z"
                        clip-rule="evenodd"/>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white border border-[#E5E7EB] rounded-xl shadow-lg z-50">
            <a href="{{ route('profile.edit') }}"
                class="block px-4 py-2 text-sm text-[#4B0D0D] hover:bg-[#F9F4F4] rounded-t-xl">
                Configuração
            </a>
            <a href="{{ route('user.orders.index') }}"
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
    <!-- Botón del carrito -->
    @if (!request()->routeIs('profile.edit') && !request()->routeIs(['checkout.index', 'checkout.waiting_room']))
        <button @click="$store.cart.openCart = true" class="relative">
            <!-- Icono -->
            <svg class="w-6 h-6 text-[#4B0D0D] hover:text-[#9B1C1C] transition" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7H19M7 13l1.5-7h8l1.5 7"/>
            </svg>
            <!-- Contador -->
            <span
                x-show="$store.cart.cartItems.length > 0"
                x-text="$store.cart.cartItems.length"
                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center"
            ></span>
        </button>

        @include('components.cart-order-items')
    @endif


</div>