<x-app-layout>
    <div class="container mx-auto py-10 md:px-32 px-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detalle de Orden</h1>

        <div class="bg-white p-6 rounded shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna 1: Información General -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Información General</h2>
                    <p><strong>Factura:</strong> {{ $order->invoice->invoice_number ?? 'Sin número' }}</p>
                    <p><strong>Total:</strong> €{{ number_format($order->total, 2) }}</p>
                    <p><strong>Método de Pago:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Comentario:</strong> {{ ucfirst($order->user_comment) }}</p>
                </div>

                <!-- Columna 2: Dirección de Facturación -->
                @if($order->address)
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Dirección de Facturación</h2>
                        <address class="not-italic text-gray-700 leading-snug">
                            {{ $order->address->full_name ?? 'Nombre no disponible' }}<br>
                            {{ $order->address->address ?? '' }}<br>
                            {{ $order->address->city ?? '' }}, {{ $order->address->state ?? '' }} - {{ $order->address->postal_code ?? '' }}<br>
                            {{ $order->address->country ?? '' }}<br>
                            Tel: {{ $order->address->phone ?? 'No disponible' }}
                        </address>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-2">Ítems</h2>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="border-b pb-2">Producto</th>
                        <th class="border-b pb-2">Cantidad</th>
                        <th class="border-b pb-2">Precio Unitario</th>
                        <th class="border-b pb-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-2">{{ $item->label_item ?? $item->product->name }}</td>
                            <td class="py-2">{{ $item->quantity }}</td>
                            <td class="py-2">€{{ number_format($item->price_unit, 2) }}</td>
                            <td class="py-2">€{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Historial de Estado</h2>
            <ul class="list-disc pl-5">
                @foreach($order->statusHistories as $history)
                    <li class="text-sm text-gray-700">
                        <strong>{{ ucfirst($history->status) }}</strong> - {{ \Carbon\Carbon::parse($history->changed_at)->format('d/m/Y H:i') }}
                        @if($history->description)
                            <br><span class="text-gray-500">{{ $history->description }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
