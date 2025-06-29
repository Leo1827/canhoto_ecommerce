@foreach ($metodos->where('is_express', false)->sortBy('order') as $metodo)
    <label class="flex items-center gap-3 p-2 border rounded-xl cursor-pointer hover:border-red-500 transition"
        :class="{ 'border-red-500 shadow-md': metodo === '{{ $metodo->code }}' }">
        <input type="radio" name="payment_method" value="{{ $metodo->code }}" x-model="metodo"
            class="accent-red-600" :disabled="plan === ''">
        @if ($metodo->icon)
            <img src="{{ asset($metodo->icon) }}" class="h-5" alt="{{ $metodo->name }}">
        @endif
        <span class="font-medium text-gray-700">{{ $metodo->name }}</span>
    </label>
@endforeach
