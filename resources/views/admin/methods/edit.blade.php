@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Editar Método de Pagamento</h2>

    {{-- Formulário de edição --}}
    <form x-data="{ driver: '{{ old('driver', $method->driver) }}' }" action="{{ route('admin.payment_methods.update', $method->id) }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-3 gap-4 mb-4">
        <input type="text" name="name" value="{{ old('name', $method->name) }}" placeholder="Nome" required class="border p-2 border-gray-300 rounded" />
        <input type="text" name="code" value="{{ old('code', $method->code) }}" placeholder="Código" required class="border p-2 border-gray-300 rounded" />

        {{-- Selección del driver --}}
        <select name="driver" x-model="driver" class="border p-2 border-gray-300 rounded">
            <option value="">-- Seleccione el driver --</option>
            <option value="paypal">PayPal</option>
            <option value="stripe">Stripe</option>
            <option value="mollie">Mollie</option>
            <option value="eupago">EuPago</option>
        </select>

    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-4">
        <input type="text" name="icon" value="{{ old('icon', $method->icon) }}" placeholder="URL del ícono (opcional)" class="border p-2 border-gray-300 rounded" />
        <input type="number" name="order" value="{{ old('order', $method->order) }}" placeholder="Orden (opcional)" class="border p-2 border-gray-300 rounded" min="0" />
        <div class="flex items-center gap-2">
            <input type="hidden" name="is_express" value="0">
            <input type="checkbox" name="is_express" id="is_express" class="accent-red-500"
                value="1" {{ old('is_express', $method->is_express) ? 'checked' : '' }}>
            <label for="is_express" class="text-sm">Método rápido (express)</label>
        </div>
    </div>

    {{-- Configuración dinámica por driver --}}

    {{-- PayPal --}}
    <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'paypal'">
        <h4 class="font-semibold mb-3 text-gray-700">Configuração para PayPal</h4>
        <div class="grid md:grid-cols-3 gap-4">
            <input type="text" name="config[client_id]" placeholder="Client ID"
                value="{{ old('config.client_id', $method->config['client_id'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
            <input type="text" name="config[secret]" placeholder="Secret"
                value="{{ old('config.secret', $method->config['secret'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
            <select name="config[mode]" class="border p-2 border-gray-300 rounded-xl">
                <option value="sandbox" {{ old('config.mode', $method->config['mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                <option value="live" {{ old('config.mode', $method->config['mode'] ?? '') == 'live' ? 'selected' : '' }}>Live</option>
            </select>
        </div>
    </div>

    {{-- Stripe --}}
    <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'stripe'">
        <h4 class="font-semibold mb-3 text-gray-700">Configuração para Stripe</h4>
        <div class="grid md:grid-cols-3 gap-4">
            <input type="text" name="config[public_key]" placeholder="Public Key"
                value="{{ old('config.public_key', $method->config['public_key'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
            <input type="text" name="config[secret_key]" placeholder="Secret Key"
                value="{{ old('config.secret_key', $method->config['secret_key'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
        </div>
    </div>

    {{-- Mollie --}}
    <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'mollie'">
        <h4 class="font-semibold mb-3 text-gray-700">Configuração para Mollie</h4>
        <div class="grid md:grid-cols-3 gap-4">
            <input type="text" name="config[api_key]" placeholder="Chave API"
                value="{{ old('config.api_key', $method->config['api_key'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
            <input type="text" name="config[profile_id]" placeholder="Profile ID"
                value="{{ old('config.profile_id', $method->config['profile_id'] ?? '') }}"
                class="border p-2 border-gray-300 rounded-xl" />
        </div>
    </div>


        <div class="flex gap-4 mt-4">
            <button class="btn btn-primary">Atualizar Método</button>
            <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>

</div>
@endsection

