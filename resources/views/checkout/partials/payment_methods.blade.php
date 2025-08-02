<div>
    <div>
        <h2 class="text-xl font-semibold text-[#4B0D0D] my-6">Método de Pagamento</h2>
    </div>
    <div class="space-y-6">

        <div x-data="{ metodo: '' }" class="space-y-4">
            <p class="block text-sm text-[#4B0D0D] mb-1">Escolha um método:</p>

            @foreach ($paymentMethods as $method)
                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-red-500 transition"
                    :class="{ 'border-red-500 shadow-md': metodo === '{{ $method->code }}' }">
                    
                    <input type="radio" name="payment_method" value="{{ $method->code }}" 
                        x-model="metodo"
                        class="accent-red-600" required>
                    
                    @if ($method->icon)
                        <img src="{{ $method->icon }}" class="h-5" alt="{{ $method->name }}">
                    @endif

                    <span class="font-medium text-gray-700">{{ $method->name }}</span>
                </label>
            @endforeach

        </div>
        {{-- details payment --}}
        <div>
            <h2 class="text-xl font-semibold text-[#4B0D0D] mb-4">Seu Pedido</h2>
            <div class="space-y-4">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between items-center p-4 bg-[#F9F4F4] rounded-lg shadow">
                        <div class="flex items-center gap-4">
                            @if ($item->product->image)
                                <img src="{{ asset('storage/products/resized/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                            @endif
                            <div>
                                <p class="font-medium text-[#4B0D0D]">{{ $item->product->name }}</p>
                                <p class="text-sm text-[#6B4F4F]">Quantidade: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="text-[#4B0D0D] font-semibold">€ {{ number_format($item->subtotal, 2) }}</p>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 text-right">
                <p class="text-lg font-bold text-[#4B0D0D]">Total: € {{ number_format($total, 2) }}</p>
            </div>
        </div>


    </div>
</div>