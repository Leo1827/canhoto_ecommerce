<x-app-layout>
    <div class="container mx-auto py-6 md:px-32 px-16">
        
        {{-- 🔔 Notificación de sesión --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow text-center">
            <h1 class="text-2xl font-bold text-[#4B0D0D] mb-4">Obrigado pela sua compra!</h1>
            <p class="text-gray-700 mb-6">Agradecemos por confiar em nós. Seu pedido foi realizado com sucesso.</p>
            
            <div class="flex justify-center gap-4">
                <a href="{{ route('products.user.store') }}" class="bg-[#4B0D0D] hover:bg-[#6b1a1a] text-white font-semibold py-2 px-4 rounded transition">
                    Voltar ao catálogo
                </a>
                <a href="{{ route('user.orders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-[#4B0D0D] font-semibold py-2 px-4 rounded transition">
                    Ver meus ordens
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
