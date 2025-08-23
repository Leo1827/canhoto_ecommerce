<form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow grid gap-6">
    @csrf

    {{-- Cliente --}}
    <div>
        <label class="block text-sm font-medium mb-1">Cliente</label>
        <select name="user_id" required class="w-full border p-2 rounded" id="user-select">
            <option value="">-- Selecione um cliente --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" data-addresses="{{ $user->addresses->toJson() }}">
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
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
            <div class="order-item grid grid-cols-1 sm:grid-cols-5 gap-2">
                <select name="items[0][product_id]" class="border p-2 rounded" required>
                    <option value="">-- Produto --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
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
            <label class="block text-sm font-medium mb-1">Frete</label>
            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="0"
                   class="w-full border p-2 rounded" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Impostos</label>
            <input type="number" step="0.01" name="tax" id="tax" value="0"
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
            <option value="pending">Pendente</option>
            <option value="paid">Paga</option>
            <option value="cancelled">Cancelada</option>
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
        <input type="text" name="payment_method" placeholder="paypal, stripe..." class="w-full border p-2 rounded" />
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
        const userSelect = document.getElementById('user-select');
        const addressSelect = document.getElementById('address-select');
        const addItemBtn = document.getElementById('add-item');
        const orderItems = document.getElementById('order-items');
        let itemIndex = 1;

        // cargar direcciones del cliente
        userSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const addresses = JSON.parse(selectedOption.getAttribute('data-addresses') || '[]');

            addressSelect.innerHTML = '<option value="">-- Selecciona una dirección --</option>';

            addresses.forEach(address => {
                const option = document.createElement('option');
                option.value = address.id;
                option.textContent = `${address.address}, ${address.city}, ${address.state}, ${address.country}`;
                addressSelect.appendChild(option);
            });
        });

        // agregar producto
        addItemBtn.addEventListener('click', function() {
            const itemHtml = `
                <div class="order-item grid grid-cols-1 sm:grid-cols-5 gap-2">
                    <select name="items[${itemIndex}][product_id]" class="border p-2 rounded" required>
                        <option value="">-- Produto --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1"
                        class="border p-2 rounded quantity" required />
                    <input type="number" step="0.01" name="items[${itemIndex}][price_unit]" placeholder="Preço unitário"
                        class="border p-2 rounded price" required />
                    <input type="number" step="0.01" name="items[${itemIndex}][total]" placeholder="Total"
                        class="border p-2 rounded total bg-gray-100" readonly />
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
            document.querySelectorAll('.order-item').forEach(row => {
                subtotal += parseFloat(row.querySelector('.total').value) || 0;
            });
            document.getElementById('subtotal').value = subtotal.toFixed(2);

            const shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            document.getElementById('total').value = (subtotal + shipping + tax).toFixed(2);
        }
    });
</script>
