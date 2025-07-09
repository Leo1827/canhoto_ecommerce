<table id="products-table" class="table table-striped table-bordered nowrap w-100 text-sm text-gray-700">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Imagem</th>
            <th class="px-4 py-2">Nome</th>
            <th class="px-4 py-2">Vinícola</th>
            <th class="px-4 py-2">Preço</th>
            <th class="px-4 py-2">Estoque</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">
                    @if($product->image)
                        <img src="{{ asset('storage/products/resized/' . $product->image) }}" class="h-20 w-20 object-cover rounded" />
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">{{ $product->winery->name ?? '—' }}</td>
                <td class="px-4 py-2">{{ number_format($product->price, 2, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $product->stock }}</td>
                {{-- Switch de activación/desactivación --}}
                <td class="py-2 text-center">
                    <div 
                        x-data="{ active: {{ $product->status ? 'true' : 'false' }} }"
                        @click="
                            active = !active;
                            fetch('{{ route('admin.product.toggleActive', $product) }}', {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status !== undefined) {
                                    active = data.status;
                                }
                            })
                        "
                        class="relative inline-block w-14 h-7 align-middle select-none transition duration-200 ease-in cursor-pointer"
                        :title="active ? 'Activo' : 'Inactivo'"
                    >
                        {{-- Fondo --}}
                        <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>

                        {{-- Botón deslizable --}}
                        <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                    </div>
                </td>

                <td class="px-4 py-2">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.inventories.index', $product->id) }}"
                            class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">
                            Inventario
                        </a>

                        <a href="{{ route('products.edit', $product->id) }}" class="bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700 transition">Atualizar</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Deseja excluir este produto?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Nenhum produto encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>