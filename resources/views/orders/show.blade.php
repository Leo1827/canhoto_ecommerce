<x-app-layout>
    <div class="container mx-auto py-10 md:px-32 px-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detalhes do Pedido</h1>

        <div class="bg-white p-6 rounded shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coluna 1: Informações Gerais -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Informações Gerais</h2>
                    <p class="flex items-center justify-between">
                        <span><strong>Fatura:</strong> {{ $order->invoice->invoice_number ?? 'Sem número' }}</span>
                        @if($order->invoice)
                            <a href="{{ route('user.orders.download', $order->id) }}"
                               class="text-white bg-[#4B0D0D] hover:bg-[#3b0a0a] transition px-3 py-1 rounded text-sm">
                                📄 Baixar Fatura
                            </a>
                        @endif
                    </p>
                    <p><strong>Total:</strong> €{{ number_format($order->total, 2) }}</p>
                    <p><strong>Método de Pagamento:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Status:</strong>
                        <span class="px-2 py-1 rounded-md text-white font-semibold
                            @if($order->status == 'paid') bg-green-600
                            @elseif($order->status == 'cancelled') bg-red-600
                            @elseif($order->status == 'shipped') bg-blue-600
                            @elseif($order->status == 'delivered') bg-purple-600
                            @else bg-gray-400
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p><strong>Comentário:</strong> {{ ucfirst($order->user_comment) }}</p>
                </div>

                <!-- Coluna 2: Endereço de Faturamento -->
                @if($order->address)
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Endereço de Faturamento</h2>
                        <address class="not-italic text-gray-700 leading-snug">
                            {{ $order->address->full_name ?? 'Nome indisponível' }}<br>
                            {{ $order->address->address ?? '' }}<br>
                            {{ $order->address->city ?? '' }}, {{ $order->address->state ?? '' }} - {{ $order->address->postal_code ?? '' }}<br>
                            {{ $order->address->country ?? '' }}<br>
                            Tel: {{ $order->address->phone ?? 'Indisponível' }}
                        </address>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-2">Itens</h2>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="border-b pb-2">Produto</th>
                        <th class="border-b pb-2">#</th>
                        <th class="border-b pb-2">Preço Unitário</th>
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

            <!-- Resumo dos valores -->
            <div class="mt-6 border-t pt-4">
                <p class="flex justify-between text-sm text-gray-700">
                    <span>Subtotal:</span>
                    <span>€{{ number_format($order->subtotal ?? 0, 2) }}</span>
                </p>
                <p class="flex justify-between text-sm text-gray-700">
                    <span>Impostos:</span>
                    <span>€{{ number_format($order->tax ?? 0, 2) }}</span>
                </p>
                <p class="flex justify-between text-sm text-gray-700">
                    <span>Envio:</span>
                    <span>€{{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                </p>
                <p class="flex justify-between text-lg font-bold text-gray-900 mt-2">
                    <span>Total:</span>
                    <span>€{{ number_format($order->total, 2) }}</span>
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Rastreamento do Pedido</h2>

            <div class="relative border-l-4 border-gray-200 ml-4 pl-6 space-y-8">
                @foreach($order->statusHistories->sortBy('changed_at') as $step)
                    <div class="relative group">
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
