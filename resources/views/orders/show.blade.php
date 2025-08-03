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
                    <p><strong>Estado:</strong> <span class="bg-green-300 px-2 p-1 rounded-md">{{ ucfirst($order->status) }} </span> </p>
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

        <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Seguimiento del Pedido</h2>

            <div class="relative border-l-4 border-gray-200 ml-4 pl-6 space-y-8">
                @foreach($order->statusHistories->sortBy('changed_at') as $step)
                    <div class="relative group">
                        <!-- Puntos del timeline -->
                        <div class="absolute w-4 h-4 bg-[#4B0D0D] transition-colors rounded-full -left-6 top-1.5 border-2 border-white shadow-md"></div>

                        <div class="bg-[#FAF8F6] p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <p class="text-base font-semibold text-gray-800 flex items-center">
                                {{ ucfirst($step->status) }}
                                <span class="ml-2 text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($step->changed_at)->format('d/m/Y H:i') }}
                                </span>
                            </p>
                            @if($step->description)
                                <p class="text-sm text-gray-600 mt-1 italic">{{ $step->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
