<div>
    <div>
        <h2 class="text-xl font-semibold text-[#4B0D0D] my-6">Método de Pagamento</h2>
    </div>
    <form action="" method="POST" class="space-y-6">
        @csrf
        <div x-data="{ metodo: '' }" class="space-y-4">
            <p class="block text-sm text-[#4B0D0D] mb-1">Escolha um método:</p>

            @foreach ($paymentMethods as $method)
                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-red-500 transition"
                    :class="{ 'border-red-500 shadow-md': metodo === '{{ $method->code }}' }">
                    
                    <input type="radio" name="payment_method" value="{{ $method->code }}" x-model="metodo"
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

        <!-- Sección Legal -->
        <div class="col-span-2 mt-6">
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm space-y-4">

                <div>
                    <input type="checkbox" id="accept_terms" name="accept_terms" required class="mr-2">
                    <label for="accept_terms" class="text-sm text-gray-700">
                        He leído y acepto los 
                        <a href="" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Términos y Condiciones</a>, 
                        <a href="" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Política de Privacidad</a> y 
                        <a href="" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Política de Devoluciones</a>.
                    </label>
                </div>

                <p class="text-xs text-gray-500">
                    Tus datos serán tratados conforme a nuestra Política de Privacidad. Esta tienda protege tu información personal y cumple con las regulaciones de comercio electrónico vigentes.
                </p>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-[#9B1C1C] text-white py-3 rounded-lg hover:bg-[#7C1616] transition">
            Confirmar e Pagar
        </button>
    </form>
</div>