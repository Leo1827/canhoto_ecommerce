<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#4B0D0D] leading-tight">
            {{ __('Catálogo de Vinos Exclusivos') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openFilters: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">

            @include('products.filters')

            <!-- Catálogo -->
            @include('products.index')

        </div>
    </div>


</x-app-layout>
