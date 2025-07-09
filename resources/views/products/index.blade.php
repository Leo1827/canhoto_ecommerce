<!-- Catálogo -->
<section class="md:col-span-3 px-4 py-8">
    <div class="mb-8">
        <h2 class="text-4xl font-bold text-[#4B0D0D]">Coleção Privada</h2>
        <p class="text-[#6B4F4F] mt-2 text-lg italic">Vinhos de prestígio, elegância e caráter.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="relative rounded-3xl overflow-hidden group h-[430px] shadow-lg">
            <img 
                src="{{ asset('storage/products/resized/' . $product->image) }}" 
                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-[.65]"
                alt="{{ $product->name }}">

            <!-- Etiquetas -->
            <div class="absolute top-4 left-4 bg-[#9B1C1C] text-white text-xs px-4 py-1 rounded-full shadow">
                {{ $product->condition->name ?? 'Vinho' }}
            </div>

            <div class="absolute top-4 right-4 bg-[#4B0D0D] text-white text-xs px-4 py-1 rounded-full">
                {{ $product->totalStock() > 0 ? 'Disponível' : 'Esgotado' }}
            </div>

            <!-- Conteúdo -->
            <div class="relative z-10 flex flex-col justify-end h-full p-5 bg-gradient-to-t from-black/70 via-black/30 to-transparent">

                <h3 class="text-2xl font-serif font-bold text-white">{{ $product->name }}</h3>
                <p class="text-xs text-gray-200 mb-2">
                    <span class="font-semibold"></span> {{ $product->region->name ?? '-' }} - 
                        {{ $product->bottling_year ?? '-' }}</span> - {{ $product->winery->name ?? '' }}
                </p>

                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-[#FCD9D9]">R${{ number_format($product->price, 0, ',', '.') }}</span>
                    <a href="{{ route('products.show', $product->slug) }}"
                    class="inline-flex items-center px-4 py-1.5 bg-[#9B1C1C] hover:bg-[#7C1616] rounded-xl text-sm text-white font-semibold transition">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
        @empty
            <p class="text-center col-span-3 text-gray-500">Nenhum produto disponível no momento.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $products->links() }}
    </div>
</section>
