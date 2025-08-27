<!-- Formulário de novo endereço -->
    <div class="bg-white shadow rounded-lg p-4 mt-6 max-full mx-auto">
        <h2 class="text-lg font-semibold mb-3">Adicionar Novo Endereço</h2>

        <form action="{{ route('customers.addresses.store', $user->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                
                <div>
                    <label class="block text-xs font-medium text-gray-600">Nome Completo</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                    @error('full_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600">Endereço</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                    @error('address') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-600">País</label>
                    <select name="country" id="country"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                        <option value="">Seleccione un país</option>
                    </select>
                    @error('country') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600">Estado</label>
                    <select name="state" id="state"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                        <option value="">Seleccione un estado</option>
                    </select>
                    @error('state') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600">Ciudad</label>
                    <select name="city" id="city"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                        <option value="">Seleccione una ciudad</option>
                    </select>
                    @error('city') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600">Código Postal (CEP)</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                    @error('postal_code') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                    @error('phone') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit"
                        class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                    Salvar Endereço
                </button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const countrySelect = document.getElementById("country");
        const stateSelect = document.getElementById("state");
        const citySelect = document.getElementById("city");

        // 1. Cargar países
        fetch("https://countriesnow.space/api/v0.1/countries/positions")
            .then(res => res.json())
            .then(data => {
                data.data.forEach(country => {
                    let option = document.createElement("option");
                    option.value = country.name;
                    option.textContent = country.name;
                    countrySelect.appendChild(option);
                });
            })
        .catch(err => console.error("Error cargando países:", err));

        // 2. Cuando selecciona país -> cargar estados
        countrySelect.addEventListener("change", function () {
            stateSelect.innerHTML = '<option value="">Seleccione un estado</option>';
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

            if (this.value) {
                fetch("https://countriesnow.space/api/v0.1/countries/states", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ country: this.value })
                })
                .then(res => res.json())
                .then(data => {
                    data.data.states.forEach(state => {
                        let option = document.createElement("option");
                        option.value = state.name;
                        option.textContent = state.name;
                        stateSelect.appendChild(option);
                    });
                });
            }
        });

        // 3. Cuando selecciona estado -> cargar ciudades
        stateSelect.addEventListener("change", function () {
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

            if (this.value && countrySelect.value) {
                fetch("https://countriesnow.space/api/v0.1/countries/state/cities", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        country: countrySelect.value,
                        state: this.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(city => {
                        let option = document.createElement("option");
                        option.value = city;
                        option.textContent = city;
                        citySelect.appendChild(option);
                    });
                });
            }
        });
    });
    </script>
