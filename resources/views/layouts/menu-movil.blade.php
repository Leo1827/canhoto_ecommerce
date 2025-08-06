<!-- Menú inferior móvil -->
<nav class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow z-40 md:hidden">
    <div class="flex justify-around items-center h-16">
        <!-- Início -->
        <a href="/" class="flex flex-col items-center text-gray-700 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <span class="text-xs font-medium">Início</span>
        </a>

        <!-- Catálogo -->
        <a href="{{ route('products.user.store') }}" class="flex flex-col items-center text-gray-700 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7M16 21H8a2 2 0 01-2-2v-5h12v5a2 2 0 01-2 2z" />
            </svg>
            <span class="text-xs font-medium">Catálogo</span>
        </a>

        <!-- Minhas Ordens -->
        <a href="{{ route('user.orders.index') }}" class="flex flex-col items-center text-gray-700 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2M12 7v4m8 4a9 9 0 11-16 0 9 9 0 0116 0z" />
            </svg>
            <span class="text-xs font-medium">Ordens</span>
        </a>

        <!-- Assinaturas -->
        <a href="{{ route('subscriptions.user.index') }}" class="flex flex-col items-center text-gray-700 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 13h14v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7z" />
            </svg>
            <span class="text-xs font-medium">Assinaturas</span>
        </a>
    </div>
</nav>
