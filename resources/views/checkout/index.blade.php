<x-app-layout>
    <div class="container mx-auto py-6 md:px-32 px-16">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="flex items-center justify-center h-64 bg-white rounded-lg shadow-md">
                <p class="text-lg text-gray-600 font-semibold">No hay productos añadidos a la orden.</p>
            </div>
        @else
            <h1 class="text-2xl font-bold text-[#4B0D0D] mb-2 bg-gray-100 p-2 rounded-lg">Finalizar Compra</h1>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Dirección seleccionada --}}
                @include('checkout.partials.address_user')

                <form action="{{ route('checkout.waiting_room') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Dirección de envío -->
                    <input type="hidden" name="address_id" id="selected_address_id">

                    <!-- Métodos de pago -->
                    @include('checkout.partials.payment_methods')

                    <!-- Comentario del usuario -->
                    <div>
                        <label for="user_comment" class="block text-sm font-medium text-gray-700 mb-1">
                            Comentarios adicionales (opcional)
                        </label>
                        <textarea name="user_comment" id="user_comment" rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#9B1C1C] focus:ring-[#9B1C1C]"
                            placeholder="Instrucciones de entrega, referencias, etc."></textarea>
                    </div>

                    <!-- Sección Legal -->
                    <div class="col-span-2 mt-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm space-y-4">

                            <div>
                                <input type="checkbox" id="accept_terms" name="accept_terms" required class="mr-2">
                                <label for="accept_terms" class="text-sm text-gray-700">
                                    He leído y acepto los 
                                    <a href="#" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Términos y Condiciones</a>, 
                                    <a href="#" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Política de Privacidad</a> y 
                                    <a href="#" target="_blank" class="text-[#9B1C1C] underline hover:text-[#4B0D0D]">Política de Devoluciones</a>.
                                </label>
                            </div>

                            <p class="text-xs text-gray-500">
                                Tus datos serán tratados conforme a nuestra Política de Privacidad.
                            </p>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <button type="submit"
                            id="checkoutSubmit"
                            class="w-full md:w-auto bg-[#9B1C1C] text-white py-3 px-6 rounded-lg hover:bg-[#7C1616] transition text-center opacity-50 cursor-not-allowed"
                            disabled>
                            Confirmar e Pagar
                        </button>

                        <a href="{{ route('products.user.store') }}"
                            class="w-full md:w-auto bg-gray-300 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-400 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        @endif

    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submitButton = document.getElementById('checkoutSubmit');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const termsCheckbox = document.getElementById('accept_terms');

        function updateButtonState() {
            const paymentSelected = Array.from(paymentRadios).some(r => r.checked);
            const termsAccepted = termsCheckbox.checked;

            if (paymentSelected && termsAccepted) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', updateButtonState);
        });

        termsCheckbox.addEventListener('change', updateButtonState);

        // Ejecutar al cargar
        updateButtonState();
    });
</script>

</x-app-layout>

