<form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow grid gap-6">
    @csrf

    {{-- Cliente --}}
    <div>
        <label class="block text-sm font-medium mb-1">Cliente</label>
        <input type="text" id="user-search" placeholder="Buscar cliente por nombre o correo"
            class="w-full border p-2 rounded mb-2">

        <!-- lista de resultados -->
        <ul id="user-results" class="border rounded bg-white hidden max-h-40 overflow-y-auto shadow-lg"></ul>

        <!-- id oculto para enviar en el form -->
        <input type="hidden" name="user_id" id="user-id">
    </div>

    {{-- Endereço de entrega --}}
    <div>
        <label class="block text-sm font-medium mb-1">Endereço de Entrega</label>
        <select name="user_address_id" required class="w-full border p-2 rounded" id="address-select">
            <option value="">-- Selecione um endereço --</option>
            @foreach($addresses as $address)
                <option value="{{ $address->id }}">{{ $address->full_address }}</option>
            @endforeach
        </select>
    </div>

    {{-- Produtos --}}
    <div>
        <label class="block text-sm font-medium mb-2">Produtos</label>

        <div id="order-items" class="space-y-3">
            <div class="order-item grid grid-cols-1 sm:grid-cols-6 gap-2">
                <select name="items[0][product_id]" class="border p-2 rounded" required>
                    <option value="">-- Produto --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <!-- Dentro de .order-item -->
                <select name="items[0][tax_id]" class="border p-2 rounded tax-select" required>
                    <option value="">-- Impuesto produto --</option>
                    @foreach($taxes as $tax)
                        <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">
                            {{ $tax->name }} ({{ $tax->rate }}%)
                        </option>
                    @endforeach
                </select>

                <input type="number" name="items[0][quantity]" value="1" min="1"
                       class="border p-2 rounded quantity" required />
                <input type="number" step="0.01" name="items[0][price_unit]" placeholder="Preço unitário"
                       class="border p-2 rounded price" required />
                <input type="number" step="0.01" name="items[0][total]" placeholder="Total"
                       class="border p-2 rounded total bg-gray-100" readonly />
                <button type="button" class="remove-item bg-red-500 text-white px-2 py-1 rounded">X</button>
            </div>
        </div>

        <button type="button" id="add-item" class="mt-3 bg-green-600 text-white px-3 py-1 rounded">+ Adicionar produto</button>
    </div>

    {{-- Totais --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Subtotal</label>
            <input type="number" step="0.01" name="subtotal" id="subtotal" readonly
                   class="w-full border p-2 rounded bg-gray-100" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Impostos produto</label>
            <input type="number" step="0.01" name="tax" id="tax" value="0" 
                   class="w-full border p-2 rounded bg-gray-100" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Frete <span>(Opcional)</span></label>
            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="0"
                   class="w-full border p-2 rounded" />
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Total</label>
        <input type="number" step="0.01" name="total" id="total" readonly
               class="w-full border p-2 rounded bg-gray-100" />
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="paid">Paga</option>
        </select>
    </div>

    {{-- Moeda --}}
    <div>
        <label class="block text-sm font-medium mb-1">Moeda</label>
        <select name="currency_id" required class="w-full border p-2 rounded">
            @foreach($currencies as $currency)
                <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Método de pagamento --}}
    <div>
        <label class="block text-sm font-medium mb-1">Método de Pagamento</label>
        <input type="text" name="payment_method" required placeholder="paypal, stripe..." class="w-full border p-2 rounded" />
    </div>

    {{-- Comentário --}}
    <div>
        <label class="block text-sm font-medium mb-1">Comentário</label>
        <textarea name="user_comment" rows="3" class="w-full border p-2 rounded"></textarea>
    </div>

    {{-- Botão --}}
    <div>
        <button type="submit" id="create-order-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Criar Pedido
        </button>
    </div>
</form>

{{-- JS para direcciones y productos dinámicos --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('user-search');
        const resultsList = document.getElementById('user-results');
        const hiddenUserId = document.getElementById('user-id');
        const addressSelect = document.getElementById('address-select');
        const addItemBtn = document.getElementById('add-item');
        const orderItems = document.getElementById('order-items');
        let itemIndex = 1;

        let timeout = null;

        // Buscar clientes mientras escribe
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            const query = this.value.trim();

            if (query.length < 2) {
                resultsList.innerHTML = '';
                resultsList.classList.add('hidden');
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/admin/users/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(users => {
                        resultsList.innerHTML = '';
                        if (users.length > 0) {
                            users.forEach(user => {
                                const li = document.createElement('li');
                                li.textContent = `${user.name} (${user.email})`;
                                li.classList.add('p-2', 'hover:bg-gray-200', 'cursor-pointer');

                                // cuando selecciona cliente
                                li.addEventListener('click', () => {
                                    searchInput.value = `${user.name} (${user.email})`;
                                    hiddenUserId.value = user.id;

                                    // cargar direcciones
                                    addressSelect.innerHTML = '<option value="">-- Seleccione una dirección --</option>';
                                    if (user.addresses && user.addresses.length > 0) {
                                        user.addresses.forEach(addr => {
                                            const opt = document.createElement('option');
                                            opt.value = addr.id;
                                            opt.textContent = `${addr.address}, ${addr.city}, ${addr.state}, ${addr.country}`;
                                            addressSelect.appendChild(opt);
                                        });
                                    } else {
                                        const opt = document.createElement('option');
                                        opt.value = "";
                                        opt.textContent = "Este cliente no tiene direcciones registradas";
                                        addressSelect.appendChild(opt);
                                    }

                                    // limpiar lista
                                    resultsList.innerHTML = '';
                                    resultsList.classList.add('hidden');
                                });

                                resultsList.appendChild(li);
                            });
                            resultsList.classList.remove('hidden');
                        } else {
                            resultsList.innerHTML = '<li class="p-2 text-gray-500">No se encontraron clientes</li>';
                            resultsList.classList.remove('hidden');
                        }
                    });
            }, 300);
        });

        // agregar producto
        addItemBtn.addEventListener('click', function() {
            const itemHtml = `
                <div class="order-item grid grid-cols-1 sm:grid-cols-6 gap-2">
                    <select name="items[${itemIndex}][product_id]" class="border p-2 rounded" required>
                        <option value="">-- Produto --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="items[${itemIndex}][tax_id]" class="border p-2 rounded tax-select" required>
                        <option value="">-- Impuesto produto --</option>
                        @foreach($taxes as $tax)
                            <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">
                                {{ $tax->name }} ({{ $tax->rate }}%)
                            </option>
                        @endforeach
                    </select>

                    <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1"
                        class="border p-2 rounded quantity" required />
                    <input type="number" step="0.01" name="items[${itemIndex}][price_unit]"
                        placeholder="Preço unitário" class="border p-2 rounded price" required />
                    <input type="number" step="0.01" name="items[${itemIndex}][total]"
                        placeholder="Total" class="border p-2 rounded total bg-gray-100" readonly />
                    <button type="button" class="remove-item bg-red-500 text-white px-2 py-1 rounded">X</button>
                </div>
            `;


            orderItems.insertAdjacentHTML('beforeend', itemHtml);
            itemIndex++;
        });

        // eliminar producto
        orderItems.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.order-item').remove();
                calculateTotals();
            }
        });

        // calcular totales en cambios
        orderItems.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
                const row = e.target.closest('.order-item');
                const qty = parseFloat(row.querySelector('.quantity').value) || 0;
                const price = parseFloat(row.querySelector('.price').value) || 0;
                row.querySelector('.total').value = (qty * price).toFixed(2);
                calculateTotals();
            }
        });

        document.getElementById('shipping_cost').addEventListener('input', calculateTotals);
        document.getElementById('tax').addEventListener('input', calculateTotals);

        function calculateTotals() {
            let subtotal = 0;
            let totalTax = 0;

            document.querySelectorAll('.order-item').forEach(row => {
                const qty = parseFloat(row.querySelector('.quantity')?.value) || 0;
                const price = parseFloat(row.querySelector('.price')?.value) || 0;
                const lineSubtotal = qty * price;

                // impuesto de la línea
                const taxSelect = row.querySelector('.tax-select');
                let taxRate = 0;
                if (taxSelect && taxSelect.selectedOptions.length > 0) {
                    taxRate = parseFloat(taxSelect.selectedOptions[0].dataset.rate) || 0;
                }
                const lineTax = lineSubtotal * taxRate / 100;

                // guardar valores en inputs
                if (row.querySelector('.total')) {
                    row.querySelector('.total').value = (lineSubtotal + lineTax).toFixed(2);
                }

                subtotal += lineSubtotal;
                totalTax += lineTax;
            });

            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('tax').value = totalTax.toFixed(2);

            const shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
            document.getElementById('total').value = (subtotal + totalTax + shipping).toFixed(2);
        }

        // recalcular al cambiar impuestos también
        orderItems.addEventListener('change', function(e) {
            if (e.target.classList.contains('tax-select')) {
                calculateTotals();
            }
        });

    });
</script>
