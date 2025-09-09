@extends('admin.layout.home')

@section('content')
    <div class="p-2">
        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-600 mb-6 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
            <ol class="list-none flex items-center flex-wrap gap-2">
                <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Inicio</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Produto</a></li>
                <li>/</li>
                <li class="text-gray-600">Novo produto</li>
            </ol>
        </nav>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 mx-4">Criar Produto</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" 
            class="bg-white p-6 rounded-2xl shadow-md max-w-6xl mx-auto">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Input --}}
                @php
                    $textInput = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500';
                @endphp

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Preço</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}" required class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Categoria</label>
                    <select name="category_id" required class="{{ $textInput }}">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Vinícola</label>
                    <select name="winery_id" required class="{{ $textInput }}">
                        @foreach($wineries as $winery)
                            <option value="{{ $winery->id }}" {{ old('winery_id') == $winery->id ? 'selected' : '' }}>{{ $winery->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Região</label>
                    <select name="region_id" required class="{{ $textInput }}">
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Vinho</label>
                    <select name="wine_type_id" required class="{{ $textInput }}">
                        @foreach($wineTypes as $type)
                            <option value="{{ $type->id }}" {{ old('wine_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Safra</label>
                    <select name="vintage_id" required class="{{ $textInput }}">
                        @foreach($vintages as $vintage)
                            <option value="{{ $vintage->id }}" {{ old('vintage_id') == $vintage->id ? 'selected' : '' }}>{{ $vintage->year }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Condição</label>
                    <select name="condition_id" required class="{{ $textInput }}">
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ano de Engarrafamento</label>
                    <input type="number" name="bottling_year" value="{{ old('bottling_year') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Temperatura Ideal</label>
                    <input type="text" name="ideal_temperature" value="{{ old('ideal_temperature') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teor Alcoólico</label>
                    <input type="number" step="0.01" name="alcohol_content" value="{{ old('alcohol_content') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Capacidade</label>
                    <input type="text" name="capacity" value="{{ old('capacity') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Variedade da Uva</label>
                    <input type="text" name="grape_variety" value="{{ old('grape_variety') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Certificação</label>
                    <input type="text" name="certification" value="{{ old('certification') }}" class="{{ $textInput }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estoque</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="{{ $textInput }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" rows="4" class="{{ $textInput }}">{{ old('description') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Imagem</label>
                    <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="status" value="1" class="text-blue-600 rounded border-gray-300 focus:ring-blue-500" {{ old('status', true) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Ativo</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Salvar Produto</button>
            </div>
        </form>
    </div>

@endsection
