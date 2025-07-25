<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl md:text-2xl text-[#4B0D0D] leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-10 bg-[#]">
        <div class="max-w-[1300px] mx-auto md:px-32 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            <!-- Galería -->
            <div class="flex flex-col-reverse md:flex-row gap-4 items-start">
                <!-- Miniaturas -->
                <div class="flex md:flex-col gap-3">
                    @foreach($product->galleries as $gallery)
                        <button 
                            class="border-2 border-transparent hover:border-[#9B1C1C] rounded-xl overflow-hidden focus:border-[#9B1C1C]"
                            onclick="updateMainImage('{{ asset('storage/products_gallery/original/' . $gallery->file_name) }}')">
                            <img src="{{ asset('storage/products_gallery/resized/' . $gallery->file_name) }}" 
                                alt="Miniatura {{ $loop->iteration }}" 
                                class="w-20 h-24 md:w-16 md:h-16 object-cover rounded-xl transition-all duration-300 hover:scale-105">
                        </button>
                    @endforeach
                </div>

                <!-- Imagen principal -->
                <div class="flex-1 bg-white  h-[500px] flex items-center justify-center overflow-hidden">
                    <img id="main-product-image"
                        src="{{ asset('storage/products/original/' . $product->image) }}" 
                        alt="{{ $product->name }}"
                        class="max-h-full max-w-full object-contain transition-all duration-300">
                </div>

            </div>

            <!-- Información -->
            <div class="bg-white p-6 md:p-8 rounded-3xl border border-[#E5E7EB] shadow-xl">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#4B0D0D] mb-2">
                    {{ $product->name }}
                </h1>

                <div class="inline-block bg-[#9B1C1C] text-white text-[10px] md:text-xs px-3 py-1 rounded-full shadow mb-4">
                    {{ $product->category->name ?? 'Condición desconocida' }}
                </div>

                @php $stock = $product->totalStock(); @endphp

                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-2xl md:text-3xl font-bold text-[#4B0D0D]">
                        €{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    
                    @if($stock > 0)
                        <span class="text-xs md:text-sm text-green-600">Disponível ({{ $stock }})</span>
                    @else
                        <span class="text-xs md:text-sm text-red-600">Esgotado</span>
                    @endif
                </div>

                <!-- Detalles -->
                <div class="grid grid-cols-2 gap-5 text-xs md:text-sm text-[#4B0D0D] mb-8">
                    <div><strong>Tipo:</strong> {{ $product->wineType->name ?? '-' }}</div>
                    <div><strong>Região:</strong> {{ $product->region->name ?? '-' }}</div>
                    <div><strong>Bodega:</strong> {{ $product->winery->name ?? '-' }}</div>
                    <div><strong>Añada:</strong> {{ $product->vintage->year ?? '-' }}</div>
                    <div><strong>Embotellado:</strong> {{ $product->bottling_year ?? '-' }}</div>
                    <div><strong>Temp. ideal:</strong> {{ $product->ideal_temperature ?? '-' }}</div>
                    <div><strong>Contenido alcohólico:</strong> {{ $product->alcohol_content ?? '-' }}%</div>
                    <div><strong>Capacidad:</strong> {{ $product->capacity ?? '-' }}</div>
                    <div><strong>Casta:</strong> {{ $product->grape_variety ?? '-' }}</div>
                    <div><strong>Certificado:</strong> {{ $product->certification ?? '-' }}</div>
                </div>

                <p class="text-base md:text-lg text-[#6B4F4F] italic mb-4">
                    {{ $product->description }}
                </p>

                <div x-data class="flex flex-col md:flex-row gap-4">
                    @php
                        $inventoryId = $product->inventories->first()?->id;
                        $stock = $product->inventories->first()?->quantity ?? 0;
                    @endphp

                    @if($stock > 0)
                        <button
                            @click="
                                console.log('Agregar al carrito:', {{ $product->id }}, {{ $inventoryId }});
                                $store.cart.addToCart({{ $product->id }}, {{ $inventoryId }}, 1);
                            "
                            class="w-full md:w-auto px-6 py-2 rounded-xl bg-[#9B1C1C] hover:bg-[#7C1616] text-white text-sm font-semibold transition">
                            Añadir al Carrito
                        </button>
                    @else
                        <span
                            class="w-full md:w-auto px-6 py-2 rounded-xl bg-gray-300 text-gray-600 text-sm font-semibold text-center cursor-not-allowed">
                            Produto Esgotado
                        </span>
                    @endif


                    <a href="{{ route('products.user.store') }}"
                    class="w-full md:w-auto px-6 py-2 rounded-xl border border-[#9B1C1C] text-[#9B1C1C] hover:bg-[#F9F4F4] text-sm font-semibold transition text-center">
                        ← Voltar ao Catálogo
                    </a>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
