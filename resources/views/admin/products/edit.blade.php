@extends('admin.layout.home')

@section('content')
<div class="p-2">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-6 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
        <ol class="list-none flex items-center flex-wrap gap-2">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li>/</li>
            <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Produto</a></li>
            <li>/</li>
            <li class="text-gray-600">Editar Produto: {{ $product->name }}</li>
        </ol>
    </nav>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-2">
        @include('admin.products.partials.form-edit')
    </div>
</div>
@endsection

