<table id="inventories-table" class="table table-striped table-bordered nowrap w-full text-sm text-gray-700">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Nome</th>
            <th class="px-4 py-2">Preço</th>
            <th class="px-4 py-2">Quantidade</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Limitado</th>
            <th class="px-4 py-2">Mínimo</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product->inventories as $inventory)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $inventory->name }}</td>
                <td class="px-4 py-2">€{{ number_format($inventory->price, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $inventory->quantity }}</td>
                <td class="px-4 py-2">{{ number_format($inventory->quantity * $inventory->price, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $inventory->limited ? 'Sim' : 'Não' }}</td>
                <td class="px-4 py-2">{{ $inventory->minimum }}</td>
                <td class="px-4 py-2">
                    @if ($inventory->quantity > $inventory->stock)
                        <span class="text-green-600 font-semibold">Disponível</span>
                    @else
                        <span class="text-red-600 font-semibold">Fora de stock</span>
                    @endif
                </td>

                <td class="px-4 py-2">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.inventories.edit', [$product->id, $inventory->id]) }}"
                           class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500">Editar</a>

                        <form action="{{ route('admin.products.inventories.destroy', [$product->id, $inventory->id]) }}" method="POST"
                              onsubmit="return confirm('Deseja excluir este item do inventário?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

