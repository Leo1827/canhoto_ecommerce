<!-- Endereço de Envio -->
<div x-data="addressListComponent()" x-ref="addressListWrapper" class="mt-4" x-init="$el._addressParent = $data">

    <!-- Título con toggle -->
    <div
        class="flex items-center justify-between cursor-pointer my-4"
        @click="showAddressSection = !showAddressSection"
    >
        <h2 class="text-xl font-semibold text-[#4B0D0D]">Endereço de Entrega</h2>
        <svg :class="{ 'rotate-180': showAddressSection }" class="h-6 w-6 text-[#9B1C1C] transition-transform duration-300"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <!-- Sección colapsable -->
    <div x-show="showAddressSection" x-transition class="space-y-4">

        <label class="block text-sm text-[#4B0D0D] mb-2 font-semibold">Selecione um endereço salvo:</label>

        <!-- Cards de direcciones -->
        <div class="grid gap-4" x-ref="addressList">

            @include('checkout.partials.table_address_user')

        </div>

        <!-- Botón para agregar nueva dirección -->
        <div>
            <button type="button"
                    class="w-full flex items-center justify-center gap-2 bg-[#F3E6E6] hover:bg-[#EBDCDC] border border-[#9B1C1C] text-[#9B1C1C] font-medium py-2 px-4 rounded-lg transition"
                    @click="openAddressModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Adicionar novo endereço
            </button>
        </div>
    </div>

    @include('checkout.partials.modal_address')
    
</div>

<script src="{{ asset('static/js/address-user-checkout.js') }}"></script>

