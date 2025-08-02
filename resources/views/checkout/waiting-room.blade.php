<x-app-layout>
    <div class="container mx-auto py-6 md:px-32 px-16">
        <h1 class="text-2xl font-bold text-[#4B0D0D] mb-6">Sala de Espera para Pagamento</h1>

        {{-- Cronómetro --}}
        <div class="mb-4 text-right text-sm text-gray-600">
            <span id="timer">Redirecionando em 30 segundos...</span>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md space-y-4 border">

            <p><strong>Método de pagamento selecionado:</strong> {{ ucfirst($paymentMethod) }}</p>

            @if ($address)
                <div>
                    <strong>Endereço de entrega:</strong>
                    <p>{{ $address->full_name }}, {{ $address->address }}, {{ $address->city }}</p>
                </div>
            @endif

            @if ($userComment)
                <div>
                    <strong>Comentários do usuário:</strong>
                    <p>{{ $userComment }}</p>
                </div>
            @endif

            {{-- Detalhes do Pedido --}}
            <div>
                <h2 class="text-xl font-semibold text-[#4B0D0D] mb-4">Seu Pedido</h2>
                <div class="space-y-4">
                    @foreach ($cartItems as $item)
                        <div class="flex justify-between items-center p-4 bg-[#F9F4F4] rounded-lg shadow">
                            <div class="flex items-center gap-4">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/products/resized/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded">
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
                <div class="mt-6 text-right space-y-1">
                    <p class="text-[#4B0D0D] font-semibold text-base">Subtotal: € {{ number_format($total, 2) }}</p>

                    @if($tax > 0)
                        <p class="text-[#4B0D0D] text-base">Taxa de processamento ({{ ucfirst($paymentMethod) }}): € {{ number_format($tax, 2) }}</p>
                    @endif

                    <p class="text-lg font-bold text-[#4B0D0D]">Total a pagar: € {{ number_format($finalTotal, 2) }}</p>
                </div>

            </div>

            {{-- Botón según método --}}
            <div class="mt-6 flex justify-end items-center space-x-4">
                @if ($paymentMethod === 'paypal')
                    <button type="button" id="payNowBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Pagar com PayPal
                    </button>
                @elseif ($paymentMethod === 'stripe')
                    <a href="#" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                        Pagar com Stripe
                    </a>
                @elseif ($paymentMethod === 'mollie')
                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Pagar com Mollie
                    </a>
                @endif

                {{-- Botón Cancelar --}}
                <a href="{{ route('checkout.index') }}"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                    Cancelar
                </a>
            </div>

            <!-- Formulario oculto -->
            <form id="paymentForm" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="address_id" value="{{ $address->id }}">
                <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                <input type="hidden" name="accept_terms" value="1">
                <input type="hidden" name="user_comment" value="{{ $userComment }}">
            </form>

        </div>
    </div>

    {{-- Script de redirección automática en 30 segundos (puedes quitar si no quieres) --}}
    <script>
        let seconds = 10;
        const timerElement = document.getElementById('timer');
        const form = document.getElementById('paymentForm');
        let formShouldSubmit = false;

        // Establecer la acción del formulario según el método de pago
        @if ($paymentMethod === 'paypal')
            form.action = "{{ route('checkout.pay') }}";
            formShouldSubmit = true;
        @elseif ($paymentMethod === 'stripe')
            form.action = "{{ route('checkout.stripe') }}";
            formShouldSubmit = true;
        @elseif ($paymentMethod === 'mollie')
            form.action = "{{ route('checkout.mollie') }}";
            formShouldSubmit = true;
        @endif

        const interval = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(interval);

                // Si hay acción válida, envía el formulario
                if (formShouldSubmit) {
                    form.submit();
                } else {
                    // Redirige a checkout.index si no hay acción definida
                    window.location.href = "{{ route('checkout.index') }}";
                }
            } else {
                timerElement.innerText = `Redirigiendo en ${seconds} segundos...`;
            }
        }, 1000);

        const payNowBtn = document.getElementById('payNowBtn');
        if (payNowBtn) {
            payNowBtn.addEventListener('click', () => {
                form.submit();
            });
        }
    </script>



</x-app-layout>
