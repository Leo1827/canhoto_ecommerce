<x-app-layout>
    <div class="container mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Historial de Órdenes</h1>

        @if($orders->isEmpty())
            <p class="text-gray-500">No tienes órdenes aún.</p>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($orders as $order)
                    <a href="{{ route('user.orders.show', $order->id) }}"
                       class="border border-gray-200 rounded-xl shadow hover:shadow-md transition p-6 bg-white flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-[#4B0D0D]">
                                Factura: {{ $order->invoice->invoice_number ?? 'Sin factura' }}
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">
                                Estado: <span class="font-medium">{{ ucfirst($order->status) }}</span> |
                                Total: €{{ number_format($order->total, 2) }} |
                                Fecha: {{ $order->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <span class="inline-block px-3 py-1 bg-[#4B0D0D] text-white text-xs rounded-full">Ver Detalles</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
