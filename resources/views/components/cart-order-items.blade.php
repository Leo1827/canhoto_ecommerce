<!-- Sidebar do Carrinho -->
<div class="fixed inset-0 z-50" x-show="$store.cart.openCart && !$store.cart.loadingCart" x-cloak>
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm" @click="$store.cart.openCart = false"></div>

    <!-- Contenido del carrito -->
    <div class="absolute right-0 top-0 h-full w-96 bg-[#FDFDFC] shadow-2xl flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#E5E7EB]">
            <h2 class="text-lg font-semibold text-[#4B0D0D]">Meu Carrinho</h2>
            <button @click="$store.cart.openCart = false">
                <svg class="w-6 h-6 text-[#4B0D0D] hover:text-[#9B1C1C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Itens do Carrinho -->
        <div class="flex-1 overflow-y-auto" x-show="$store.cart.cartItems.length > 0">
            <template x-for="item in $store.cart.cartItems" :key="item.id">
                <div class="flex px-6 py-4 border-b border-[#E5E7EB] relative">
                    <!-- Imagen -->
                    <img :src="item.image" alt="" class="w-16 h-20 object-cover rounded-xl">

                    <!-- Info -->
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-[#4B0D0D]" x-text="item.name"></h3>
                        <!-- Controles -->
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center space-x-2">
                                <button @click="$store.cart.updateQty(item.id, item.quantity - 1)"
                                    class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">-</button>
                                <span class="text-sm text-[#4B0D0D]" x-text="item.quantity"></span>
                                <button @click="$store.cart.updateQty(item.id, item.quantity + 1)"
                                    class="w-6 h-6 rounded-full bg-[#F4EDED] text-[#4B0D0D] hover:bg-[#e6dede]">+</button>
                            </div>
                            <span class="text-sm text-[#4B0D0D]" x-text="'€ ' + (parseFloat(item.price_unit || 0)).toFixed(2)"></span>
                        </div>

                        <!-- Subtotal -->
                        <div x-text="'Subtotal: R$ ' + (parseFloat(item.subtotal || 0)).toFixed(2)"></div>
                    </div>

                    <!-- Botón eliminar -->
                    <button @click="$store.cart.removeItem(item.id)" class="absolute top-2 right-4 text-[#9B1C1C] hover:text-[#7C1616]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Carrito vacío -->
        <div class="flex-1 flex items-center justify-center text-[#6B4F4F]" x-show="$store.cart.cartItems.length == 0">
            Seu carrinho está vazio 🛒
        </div>

        <!-- Total -->
        <div class="px-6 py-4 border-t border-[#E5E7EB]">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-[#4B0D0D] font-medium">Total</span>
                <span class="text-lg font-semibold text-[#4B0D0D]" x-text="'€ ' + $store.cart.cartTotal.toFixed(2)"></span>
            </div>
            <a href="{{ route('checkout.index') }}"
                class="block w-full px-4 py-2 text-center bg-[#9B1C1C] text-white rounded-lg hover:bg-[#7C1616] transition">
                Finalizar Compra
            </a>
            <button @click="$store.cart.openCart = false"
                class="w-full mt-3 px-4 py-2 border border-[#9B1C1C] text-[#9B1C1C] rounded-lg hover:bg-[#F9F4F4] transition">
                Continuar Comprando
            </button>
        </div>
    </div>
</div>
