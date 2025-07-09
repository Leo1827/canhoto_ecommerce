@extends('admin.layout.home')

@section('content')
<div class="p-6">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
        <ol class="list-none inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            </li>
            <li>/</li>
            <li>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Produtos</a>
            </li>
            <li>/</li>
            <li>
                <a href="{{ route('admin.products.inventories.index', $product->id) }}" class="text-blue-600 hover:underline">
                    Inventário de: {{ $product->name }}
                </a>
            </li>
            <li>/</li>
            <li class="text-gray-800 font-semibold">Criar Inventário</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">Adicionar Item ao Inventário</h2>

        <form action="{{ route('admin.products.inventories.store', $product->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nome</label>
                <input type="text" name="name" class="border w-full" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Preço</label>
                <input type="number" step="0.01" name="price" class="border w-full" value="{{ old('price') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Quantidade</label>
                <input type="number" name="quantity" class="border w-full" value="{{ old('quantity') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Estoque Mínimo</label>
                <input type="number" name="minimum" class="border w-full" value="{{ old('minimum') }}">
            </div>

            <div class="mb-4 flex items-center gap-2">
                <input type="hidden" name="limited" value="0">
                <input type="checkbox" name="limited" id="limited" value="1" {{ old('limited', $inventory->limited ?? false) ? 'checked' : '' }}>

                <label for="limited" class="font-semibold">Quantidade Limitada</label>
            </div>

            <div class="mt-6">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.products.inventories.index', $product->id) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
