<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#4B0D0D] leading-tight">
            {{ __('Catálogo de Vinos Exclusivos') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Filtros -->
            <aside class="bg-white p-6 rounded-2xl border border-[#E5E7EB]">
                <h3 class="text-xl font-semibold text-[#4B0D0D] mb-6">Filtrar</h3>

                <!-- Tipo de Vino -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Tipo de Vino</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484] focus:ring-[#4B0D0D]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Tinto</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Blanco</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Rosado</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Espumoso</span>
                        </label>
                    </div>
                </div>

                <!-- Región -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Región</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Bordeaux</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Rioja</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-[#C4A484]">
                            <span class="ml-2 text-sm text-[#4B0D0D]">Toscana</span>
                        </label>
                    </div>
                </div>

                <!-- Precio -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-[#4B0D0D] mb-3">Precio</h4>
                    <input type="range" min="0" max="1000" class="w-full accent-[#4B0D0D]">
                    <div class="flex justify-between text-sm text-[#4B0D0D] mt-1">
                        <span>$0</span>
                        <span>$1000+</span>
                    </div>
                </div>

                <button class="mt-6 w-full bg-[#4B0D0D] hover:bg-[#3A0A0A] text-white py-2 rounded-xl">
                    Aplicar Filtros
                </button>
            </aside>

            @include('products.index')

        </div>
    </div>
</x-app-layout>
