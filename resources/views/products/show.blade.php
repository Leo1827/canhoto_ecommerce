<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl md:text-2xl text-[#4B0D0D] leading-tight">
            {{ $product['name'] }}
        </h2>
    </x-slot>

    <div class="py-10 bg-[#FAF8F6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            <!-- Galería -->
            <div class="flex flex-col-reverse md:flex-row gap-4">
                <!-- Miniaturas -->
                <div class="flex md:flex-col gap-3">
                    @foreach([1,2,3,4] as $i)
                        <button class="border-2 border-transparent hover:border-[#9B1C1C] rounded-xl overflow-hidden">
                            <img src="{{ asset('img/' . $product['image']) }}" 
                                 alt="Miniatura {{ $i }}" 
                                 class="w-20 h-24 md:w-16 md:h-16 object-cover rounded-xl">
                        </button>
                    @endforeach
                </div>

                <!-- Imagen principal -->
                <div class="flex-1 bg-white p-4 md:p-6 rounded-3xl border border-[#E5E7EB] shadow-xl">
                    <img src="{{ asset('img/' . $product['image']) }}" 
                         alt="{{ $product['name'] }}"
                         class="w-full h-[350px] md:h-[500px] object-cover rounded-2xl shadow-md">
                </div>
            </div>

            <!-- Información -->
            <div class="bg-white p-6 md:p-8 rounded-3xl border border-[#E5E7EB] shadow-xl">
                <!-- Nombre -->
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#4B0D0D] mb-2">
                    {{ $product['name'] }}
                </h1>

                <!-- Descripción -->
                <p class="text-base md:text-lg text-[#6B4F4F] italic mb-4">
                    {{ $product['description'] }}
                </p>

                <!-- Etiqueta -->
                <div class="inline-block bg-[#9B1C1C] text-white text-[10px] md:text-xs px-3 py-1 rounded-full shadow mb-4">
                    {{ $product['label'] }}
                </div>

                <!-- Precio + disponibilidad -->
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-2xl md:text-3xl font-bold text-[#4B0D0D]">
                        ${{ number_format($product['price'], 0, ',', '.') }}
                    </span>
                    @if($product['available'])
                        <span class="text-xs md:text-sm text-green-600">Disponible</span>
                    @else
                        <span class="text-xs md:text-sm text-red-600">Agotado</span>
                    @endif
                </div>

                <!-- Detalles con iconos -->
                <div class="grid grid-cols-2 gap-5 text-xs md:text-sm text-[#4B0D0D] mb-8">
                    @foreach($product['details'] as $key => $value)
                        <div class="flex items-start gap-2">
                            <!-- Ícono -->
                            <div class="w-6 h-6 flex items-center justify-center bg-[#F4EDED] rounded-full">
                                @switch($key)
                                    @case('Embotellado')
                                        <svg class="w-3 h-3 text-[#9B1C1C]" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                        </svg>
                                        @break
                                    @case('Región')
                                        <svg class="w-3 h-3 text-[#9B1C1C]" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 12 17.657 7.343a8 8 0 10-11.314 0L10.586 12 6.343 16.657a8 8 0 1011.314 0z"/>
                                        </svg>
                                        @break
                                    @case('Temperatura ideal')
                                        <svg class="w-3 h-3 text-[#9B1C1C]" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4m0 4h.01m-6.938 4h13.856C18.36 18.16 19 15.21 19 12c0-3.21-.64-6.16-1.072-8H5.072C4.64 5.84 4 8.79 4 12c0 3.21.64 6.16 1.072 8z"/>
                                        </svg>
                                        @break
                                    @case('País')
                                        <svg class="w-3 h-3 text-[#9B1C1C]" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                                        </svg>
                                        @break
                                    @default
                                        <svg class="w-3 h-3 text-[#9B1C1C]" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4v16m8-8H4"/>
                                        </svg>
                                @endswitch
                            </div>
                            <!-- Texto -->
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $key }}</span>
                                <span>{{ $value }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Acciones -->
                <div class="flex flex-col md:flex-row gap-4">
                    <button
                        class="w-full md:w-auto px-6 py-2 rounded-xl bg-[#9B1C1C] hover:bg-[#7C1616] text-white text-sm font-semibold transition">
                        Añadir al Carrito
                    </button>
                    <a href="{{ route('dashboard') }}"
                       class="w-full md:w-auto px-6 py-2 rounded-xl border border-[#9B1C1C] text-[#9B1C1C] hover:bg-[#F9F4F4] text-sm font-semibold transition">
                        Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
