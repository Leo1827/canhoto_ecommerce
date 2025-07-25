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

            @foreach(auth()->user()->addresses as $address)
                <div
                    x-data="addressComponent({{ $address->id }}, document.querySelector('[x-ref=addressListWrapper]')._addressParent)"
                    id="address-card-{{ $address->id }}"
                    class="relative"
                >

                    <!-- Spinner -->
                    <div x-show="loading" class="absolute inset-0 bg-white/70 flex items-center justify-center rounded-xl z-10">
                        <svg class="animate-spin h-6 w-6 text-[#9B1C1C]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                        <!-- Visual -->
                        <template x-if="!editing">
                            <div>
                                <input
                                    type="radio"
                                    name="address_id"
                                    id="address_{{ $address->id }}"
                                    value="{{ $address->id }}"
                                    class="peer hidden"
                                    required
                                >

                                <label
                                    :class="selected ? 'border-[#9B1C1C] bg-[#FFF3F3] shadow-lg' : ''"
                                    for="address_{{ $address->id }}"
                                    class="flex flex-col gap-3 rounded-xl border-2 border-gray-200 p-5 cursor-pointer transition-all duration-200 bg-white peer-checked:border-[#9B1C1C] peer-checked:bg-[#FFF3F3] peer-checked:shadow-lg relative"
                                    @click="select"
                                >
                                    <!-- Check icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-[#9B1C1C] absolute top-3 right-3 hidden peer-checked:block"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>

                                    <div class="text-sm text-[#4B0D0D] space-y-1">
                                        <p class="font-bold">{{ $address->full_name }} - {{ $address->country }}</p>
                                        <p>{{ $address->address }} - Telefone: {{ $address->phone }}</p>
                                        <p>{{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}</p>
                                    </div>

                                    <div class="flex justify-end gap-2 ">
                                        <button type="button" @click.stop="editing = true"
                                                class="text-sm text-[#9B1C1C] hover:underline">Editar</button>

                                        <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                            @submit.prevent="deleteAddress($event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </label>
                            </div>
                        </template>

                        <!-- Edición -->
                        <template x-if="editing">
                            <form method="POST" action="{{ route('addresses.update', $address) }}"
                                @submit.prevent="updateAddress($event)"
                                class="border-2 border-[#9B1C1C] p-5 rounded-xl bg-[#FFF9F9] space-y-3 mt-4">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                <div class="grid md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Nome Completo:</label>
                                        <input type="text" name="full_name" value="{{ $address->full_name }}" required
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Telefone:</label>
                                        <input type="text" name="phone" value="{{ $address->phone }}"
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Endereço:</label>
                                        <input type="text" name="address" value="{{ $address->address }}" required
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Cidade:</label>
                                        <input type="text" name="city" value="{{ $address->city }}" required
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Estado:</label>
                                        <input type="text" name="state" value="{{ $address->state }}"
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">País:</label>
                                        <input type="text" name="country" value="{{ $address->country }}" required
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-[#4B0D0D] font-medium">Código Postal:</label>
                                        <input type="text" name="postal_code" value="{{ $address->postal_code }}" required
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3 pt-2">
                                    <button type="submit"
                                            class="bg-[#9B1C1C] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#7F1616]">
                                        Atualizar
                                    </button>
                                    <button type="button" @click="editing = false"
                                            class="text-sm text-gray-600 hover:underline">Cancelar</button>
                                </div>
                            </form>
                        </template>
                </div>
            @endforeach

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

<script>
    function addressListComponent() {
        return {
            showAddressSection: true,
            openAddressModal: false,
            selectedId: null,

            setSelected(id) {
                this.selectedId = id;
            },

            isSelected(id) {
                return this.selectedId === id;
            },

            refreshAddresses() {
                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newList = doc.querySelector('[x-ref="addressList"]');
                    if (newList) {
                        this.$refs.addressList.innerHTML = newList.innerHTML;
                        // Reinicia Alpine en los nuevos elementos
                        Alpine.discoverUninitializedComponents(el => {
                            Alpine.initializeComponent(el);
                        });
                    }
                });
            }
        };
    }

    function addressComponent(id, parent) {
        return {
            editing: false,
            loading: false, // ✅ importante

            select() {
                parent.setSelected(id); // ✅ asegúrate que parent fue pasado correctamente
                document.getElementById(`address_${id}`).checked = true;
            },

            get selected() {
                return parent.isSelected(id); // ✅ parent accedido correctamente
            },

            updateAddress(e) {
                const form = e.target;
                const formData = new FormData(form);
                const action = form.getAttribute('action');

                this.loading = true;

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao atualizar endereço');
                    return res.text();
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(err => alert(err.message))
                .finally(() => {
                    this.loading = false;
                });
            },

            deleteAddress(e) {
                e.preventDefault();
                this.loading = true;

                const form = e.target;
                const action = form.getAttribute('action');

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: new URLSearchParams({ _method: 'DELETE' })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao excluir');
                    document.getElementById(`address-card-${id}`).remove();
                })
                .catch(err => alert(err.message))
                .finally(() => {
                    this.loading = false;
                });
            }
        };
    }



</script>

