{{-- resources/views/admin/products/index.blade.php --}}

@extends('admin.layout.home')

@section('content')
    <div class="p-2">

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        {{-- breadcrumb --}}
        <nav class="text-sm text-gray-600 mb-2 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
            <ol class="list-none inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Inicio</a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Produto</a>
                </li>
                @if (!empty($editing))
                    <li>/</li>
                    <li class="text-gray-800 font-semibold">Editar</li>
                @endif
            </ol>
        </nav>

        <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
            <!-- Contenedor para botones de DataTables -->
            <div class="mb-4 flex flex-wrap justify-between items-center gap-2">
                <div id="buttons-container" class="flex gap-2 flex-wrap"></div>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-success relative justify-end">Novo Produto</a>

            @include('admin.products.partials.table-products')
        </div>

        <div class="mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    
@endsection
    