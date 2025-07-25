<x-app-layout>
    <div class="container mx-auto py-6 md:px-32 px-16">
        <h1 class="text-2xl font-bold text-[#4B0D0D] mb-2 bg-gray-100 p-2 rounded-lg">Finalizar Compra</h1>

        <div class="grid md:grid-cols-2 gap-8">

            {{-- address user --}}
            @include('checkout.partials.address_user')

            <!-- Métodos de Pagamento -->
            @include('checkout.partials.payment_methods')
  
        </div>
    </div>
</x-app-layout>