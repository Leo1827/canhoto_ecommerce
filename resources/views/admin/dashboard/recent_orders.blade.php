<!-- Órdenes recientes -->
<div class="bg-white rounded-2xl shadow p-6">
    <h3 class="text-lg font-bold mb-4 text-gray-800">Órdenes recientes</h3>
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="text-gray-500 border-b">
                <th class="pb-2">#</th>
                <th class="pb-2">Cliente</th>
                <th class="pb-2">Total</th>
                <th class="pb-2">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordenesRecientes as $orden)
                <tr class="border-b hover:bg-gray-50">
                    <td>{{ $orden->id }}</td>
                    <td>{{ $orden->user->name ?? 'Sin cliente' }}</td>
                    <td>${{ number_format($orden->total, 0, ',', '.') }}</td>
                    <td>
                        @if($orden->status === 'Pendiente')
                            <span class="text-blue-500 font-semibold">{{ $orden->status }}</span>
                        @elseif($orden->status === 'Pagado')
                            <span class="text-green-500 font-semibold">{{ $orden->status }}</span>
                        @else
                            <span class="text-gray-500 font-semibold">{{ $orden->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400 py-3">No hay órdenes recientes</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
