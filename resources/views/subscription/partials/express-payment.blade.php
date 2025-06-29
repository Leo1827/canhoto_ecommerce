@php
    $paypal = $metodos->firstWhere('code', 'paypal');
@endphp

@if ($metodos->where('is_express', true)->count())
    <div class="space-y-6" x-show="plan !== ''" x-transition>
        <h2 class="text-2xl font-bold text-gray-800 text-center">
            Finalize sua compra com
        </h2>

        <div class="flex justify-center gap-5 flex-wrap">
            @foreach ($metodos->where('is_express', true)->sortBy('order') as $express)
                <button 
                    type="button"
                    x-on:click="metodo = '{{ $express->code }}'"
                    :class="metodo === '{{ $express->code }}' 
                        ? 'ring-2 ring-offset-2 ring-red-500 scale-105' 
                        : 'scale-100'"
                    class="bg-white border border-gray-200 shadow-md hover:shadow-lg 
                           hover:border-red-500 px-6 py-3 rounded-2xl 
                           text-sm font-semibold text-gray-700 
                           flex items-center gap-3 transform transition 
                           duration-300 ease-in-out"
                >
                    @if ($express->icon)
                        <img src="{{ asset($express->icon) }}" class="h-6 w-6 object-contain" alt="{{ $express->name }}">
                    @endif
                    <span>{{ $express->name }}</span>
                </button>
            @endforeach
        </div>

        {{-- Zona dinámica de renderizado del botón seleccionado --}}
        @foreach ($metodos->where('is_express', true)->sortBy('order') as $express)
            <div 
                x-show="metodo === '{{ $express->code }}'" 
                id="express-{{ $express->code }}-container" 
                class="mt-6"
                x-transition
            ></div>
        @endforeach

        <div class="text-center text-gray-400 mt-2">
            ou continue com cartão ou conta
        </div>
    </div>
@endif
