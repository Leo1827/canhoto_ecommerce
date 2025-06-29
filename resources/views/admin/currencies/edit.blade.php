@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Editar Moeda</h2>

    <form action="{{ route('admin.currencies.update', $currency->id) }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-4 gap-4">
            <input type="text" name="code" value="{{ old('code', $currency->code) }}" placeholder="Código" required class="border p-1 border-gray-300" />
            <input type="text" name="name" value="{{ old('name', $currency->name) }}" placeholder="Nome" required class="border p-1 border-gray-300" />
            <input type="text" name="symbol" value="{{ old('symbol', $currency->symbol) }}" placeholder="Símbolo" required class="border p-1 border-gray-300" />
            <input type="number" step="0.000001" name="rate" value="{{ old('rate', $currency->rate) }}" placeholder="Taxa de câmbio" required class="border p-1 border-gray-300" />
        </div>

        <button class="mt-3 btn btn-primary">Atualizar Moeda</button>
        <a href="{{ route('admin.currencies.index') }}" class="mt-3 ml-3 btn btn-outline">Cancelar</a>
    </form>
</div>
@endsection
