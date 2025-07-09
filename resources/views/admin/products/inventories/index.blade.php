@extends('admin.layout.home')

@section('content')
    <div class="p-6">

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
            <ol class="list-none inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Painel</a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Produtos</a>
                </li>
                <li>/</li>
                <li class="text-gray-800 font-semibold">Inventário de: {{ $product->name }}</li>
            </ol>
        </nav>

        <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Inventário de: {{ $product->name }}</h2>
                <a href="{{ route('admin.products.inventories.create', $product->id) }}" class="btn btn-primary">
                    + Adicionar Inventário
                </a>
            </div>

            {{-- Tabela incluída --}}
            @include('admin.products.inventories.partials.table-inventories')
        </div>
    </div>
@endsection
