<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" 
    class="bg-white p-6 rounded-2xl shadow-md max-w-6xl mx-auto">
    @csrf
    @method('PUT')
    <h3 class="text-xl font-semibold mb-4">Atualizar Produto</h3>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @php
            $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500';
        @endphp

        <div>
            <label class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Preço</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Categoria</label>
            <select name="category_id" required class="{{ $inputClass }}">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Vinícola</label>
            <select name="winery_id" required class="{{ $inputClass }}">
                @foreach($wineries as $winery)
                    <option value="{{ $winery->id }}" {{ old('winery_id', $product->winery_id) == $winery->id ? 'selected' : '' }}>{{ $winery->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Região</label>
            <select name="region_id" required class="{{ $inputClass }}">
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id', $product->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Vinho</label>
            <select name="wine_type_id" required class="{{ $inputClass }}">
                @foreach($wineTypes as $type)
                    <option value="{{ $type->id }}" {{ old('wine_type_id', $product->wine_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Safra</label>
            <select name="vintage_id" required class="{{ $inputClass }}">
                @foreach($vintages as $vintage)
                    <option value="{{ $vintage->id }}" {{ old('vintage_id', $product->vintage_id) == $vintage->id ? 'selected' : '' }}>{{ $vintage->year }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Condição</label>
            <select name="condition_id" required class="{{ $inputClass }}">
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id', $product->condition_id) == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Ano de Engarrafamento</label>
            <input type="number" name="bottling_year" value="{{ old('bottling_year', $product->bottling_year) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Temperatura Ideal</label>
            <input type="text" name="ideal_temperature" value="{{ old('ideal_temperature', $product->ideal_temperature) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Teor Alcoólico</label>
            <input type="number" step="0.01" name="alcohol_content" value="{{ old('alcohol_content', $product->alcohol_content) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Capacidade</label>
            <input type="text" name="capacity" value="{{ old('capacity', $product->capacity) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Variedade da Uva</label>
            <input type="text" name="grape_variety" value="{{ old('grape_variety', $product->grape_variety) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Certificação</label>
            <input type="text" name="certification" value="{{ old('certification', $product->certification) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Estoque</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="{{ $inputClass }}">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="description" rows="4" class="{{ $inputClass }}">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagem Atual</label>
            @if ($product->image)
                <img src="{{ asset('storage/products/resized/' . $product->image) }}" class="h-32 w-32 object-cover rounded mb-3" />
            @else
                <p class="text-sm text-gray-500 mb-2">Nenhuma imagem carregada</p>
            @endif
            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:border-blue-500">
        </div>

    </div>

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">Cancelar</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Atualizar Produto</button>
    </div>
</form>

@include('admin.products.partials.form-edit-gallery')


