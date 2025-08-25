<!-- Botón de filtros solo en móvil -->
<div class="md:hidden mb-2">
    <button 
        @click="openFilters = !openFilters" 
        class="w-full flex items-center justify-between bg-[#4B0D0D] text-white px-4 py-2 rounded-xl"
    >
        <span>Filtros</span>
        <svg x-show="!openFilters" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
        <svg x-show="openFilters" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>

<!-- Filtros -->
<aside 
    class="bg-white p-6 rounded-2xl border border-[#E5E7EB] md:block"
    x-show="openFilters || window.innerWidth >= 768"
    x-transition
    >
    <form id="filterForm" method="GET" action="{{ route('products.user.store') }}">
        <h3 class="text-xl font-semibold text-[#4B0D0D] mb-6">Filtro</h3>

        <!-- Tipo de Vino -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Tipo de vinho</h4>
            <div class="space-y-3">
                @foreach(\App\Models\WineType::all() as $wineType)
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="wine_types[]" 
                            value="{{ $wineType->id }}" 
                            {{ in_array($wineType->id, request()->input('wine_types', [])) ? 'checked' : '' }}
                            class="rounded border-[#C4A484] focus:ring-[#4B0D0D]"
                        >
                        <span class="ml-2 text-sm text-[#4B0D0D]">{{ $wineType->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Región -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Região</h4>
            <div class="space-y-3">
                @foreach(\App\Models\Region::all() as $region)
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="regions[]" 
                            value="{{ $region->id }}" 
                            {{ in_array($region->id, request()->input('regions', [])) ? 'checked' : '' }}
                            class="rounded border-[#C4A484]"
                        >
                        <span class="ml-2 text-sm text-[#4B0D0D]">{{ $region->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <!-- Precio con Range Slider -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Preço</h4>

            <div class="relative w-full max-w-md mx-auto">
                <!-- Valores seleccionados -->
                <div class="flex justify-between text-xs text-gray-600 mb-2">
                    <span id="min-value">${{ request('min_price', 0) }}</span>
                    <span id="max-value">${{ request('max_price', 1000) }}</span>
                </div>

                <!-- Slider contenedor -->
                <div class="relative h-6">
                    <!-- Barra de fondo -->
                    <div class="absolute top-1/2 transform -translate-y-1/2 h-1 w-full bg-gray-300 rounded"></div>
                    <!-- Barra activa -->
                    <div id="range-bar" class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-[#4B0D0D] rounded"></div>

                    <!-- Input mínimo -->
                    <input 
                        type="range" 
                        id="min-range" 
                        name="min_price" 
                        min="0" 
                        max="100000" 
                        value="{{ request('min_price', 0) }}"
                        class="absolute w-full appearance-none bg-transparent 
                            [&::-webkit-slider-thumb]:appearance-none 
                            [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 
                            [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-[#4B0D0D] 
                            [&::-webkit-slider-thumb]:cursor-pointer
                            [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 
                            [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-[#4B0D0D] 
                            [&::-moz-range-thumb]:cursor-pointer
                    " />

                    <!-- Input máximo -->
                    <input 
                        type="range" 
                        id="max-range" 
                        name="max_price" 
                        min="0" 
                        max="100000" 
                        value="{{ request('max_price', 10000) }}"
                        class="absolute w-full appearance-none bg-transparent 
                            [&::-webkit-slider-thumb]:appearance-none 
                            [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 
                            [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-[#4B0D0D] 
                            [&::-webkit-slider-thumb]:cursor-pointer
                            [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 
                            [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-[#4B0D0D] 
                            [&::-moz-range-thumb]:cursor-pointer
                    " />
                </div>
            </div>
        </div>
        <button type="submit" class="mt-6 w-full bg-[#4B0D0D] hover:bg-[#3A0A0A] text-white py-2 rounded-xl">
            Aplicar Filtros
        </button>
    </form>
</aside>

<script>

    const filterForm = document.getElementById('filterForm');

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault(); // detener envío momentáneamente
        try {
            fbq('track', 'Search', {
                content_ids: [], 
                content_type: 'product',
                value: null,
                currency: 'EUR'
            });
        } catch (err) {
            console.warn('Facebook Pixel no cargado:', err);
        }

        // esperar 200ms antes de enviar el form
        setTimeout(() => {
            filterForm.submit();
        }, 200);
    });
    const minRange = document.getElementById("min-range");
    const maxRange = document.getElementById("max-range");
    const minValue = document.getElementById("min-value");
    const maxValue = document.getElementById("max-value");
    const rangeBar = document.getElementById("range-bar");

    function updateRange() {
        let min = parseInt(minRange.value);
        let max = parseInt(maxRange.value);

        if (min > max - 50) { // margen mínimo entre ambos
            minRange.value = max - 50;
            min = max - 50;
        }
        if (max < min + 50) {
            maxRange.value = min + 50;
            max = min + 50;
        }

        minValue.textContent = `$${min}`;
        maxValue.textContent = `$${max}`;

        const percentMin = (min / minRange.max) * 100;
        const percentMax = (max / maxRange.max) * 100;

        rangeBar.style.left = percentMin + "%";
        rangeBar.style.width = (percentMax - percentMin) + "%";
    }

    minRange.addEventListener("input", updateRange);
    maxRange.addEventListener("input", updateRange);

    // Inicializar
    updateRange();

</script>