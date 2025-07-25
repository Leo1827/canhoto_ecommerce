<!-- Modal para agregar nueva dirección -->
    <div x-show="openAddressModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         x-transition>
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                    @click="openAddressModal = false">✖</button>

            <h3 class="text-lg font-semibold text-[#4B0D0D] mb-4">Novo Endereço</h3>

            <form method="POST" action="{{ route('addresses.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Nome Completo:</label>
                        <input type="text" name="full_name" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Telefone:</label>
                        <input type="text" name="phone"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Endereço:</label>
                        <input type="text" name="address" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]"
                               placeholder="Rua das Flores, 123 - Bairro Centro">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Cidade:</label>
                        <input type="text" name="city" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Estado:</label>
                        <input type="text" name="state"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">País:</label>
                        <input type="text" name="country" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4B0D0D]">Código Postal:</label>
                        <input type="text" name="postal_code" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#9B1C1C]">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-[#9B1C1C] hover:bg-[#7F1616] text-white font-semibold py-2 px-4 rounded-lg transition">
                            Salvar endereço
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>