@extends('admin.layout.home')

@section('title', 'Editar Plan')

@section('content')
<div class="bg-white shadow-lg rounded-2xl p-6 mb-8">
    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    
    <nav class="text-sm text-gray-600 mb-5" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Inicio</a>
            </li>
            <li>
                <span class="mx-1">/</span>
            </li>
            <li>
                <a href="{{ route('admin.plans.index') }}" class="text-blue-600 hover:underline">Planes</a>
            </li>
            <li>
                <span class="mx-1">/</span>
            </li>
            <li class="text-gray-700 font-semibold">Editar Plan</li>
        </ol>
    </nav>

    <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Preço</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $plan->price) }}" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Intervalo</label>
                <select name="interval" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2" required>
                    <option value="monthly" {{ $plan->interval === 'monthly' ? 'selected' : '' }}>Mensal</option>
                    <option value="yearly" {{ $plan->interval === 'yearly' ? 'selected' : '' }}>Anual</option>
                    <option value="weekly" {{ $plan->interval === 'weekly' ? 'selected' : '' }}>Semanal</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Stripe</label>
                <input type="text" name="stripe_id" value="{{ old('stripe_id', $plan->stripe_id) }}" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Características <span class="text-gray-400 text-xs">(separadas por vírgula)</span></label>
                <textarea name="features" rows="3" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2">{{ old('features', $plan->features) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordem</label>
                <input type="number" name="order" min="0" value="{{ old('order', $plan->order) }}" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Moneda</label>
                <select name="currency_id" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2" required>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" {{ $plan->currency_id == $currency->id ? 'selected' : '' }}>
                            {{ $currency->code }} - {{ $currency->symbol }} ({{ $currency->name }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-blue-600" {{ $plan->is_active ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Ativo</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
