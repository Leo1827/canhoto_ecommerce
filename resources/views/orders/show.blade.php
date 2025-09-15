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
                        <span class='px-2 py-1 rounded-md text-white font-semibold
                            @if($order->status == 'paid') bg-green-600
                            @elseif($order->status == 'cancelled') bg-red-600
                            @elseif($order->status == 'shipped') bg-blue-600
                            @elseif($order->status == 'delivered') bg-purple-600
                            @else bg-gray-400
                            @endif'>
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p><strong>Comentário:</strong> {{ ucfirst($order->user_comment) }}</p>
                </div>

                <!-- Coluna 2: Endereço de Faturamento -->
                @if($order->address)
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Endereço de Faturamento</h2>
                        <div class=" text-gray-700">
                            <p><strong>Nome:</strong> {{ $order->address->full_name ?? 'Nome indisponível' }}</p>
                            <p><strong>Endereço:</strong> {{ $order->address->address ?? 'Não informado' }}</p>
                            <p><strong>Cidade:</strong> {{ $order->address->city ?? 'Não informado' }}</p>
                            <p><strong>Estado:</strong> {{ $order->address->state ?? 'Não informado' }}</p>
                            <p><strong>Código Postal:</strong> {{ $order->address->postal_code ?? 'Não informado' }}</p>
                            <p><strong>País:</strong> {{ $order->address->country ?? 'Não informado' }}</p>
                            <p><strong>Telefone:</strong> {{ $order->address->phone ?? 'Indisponível' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-2">Itens</h2>
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border-b py-2 px-2">Produto</th>
                        <th class="border-b py-2 px-2 text-center">Qtd</th>
                        <th class="border-b py-2 px-2 text-right">Preço Unitário</th>
                        <th class="border-b py-2 px-2 text-center">IVA</th>
                        <th class="border-b py-2 px-2 text-right">Valor IVA</th>
                        <th class="border-b py-2 px-2 text-right">Total c/ IVA</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTax = 0;
                        $subtotal = 0;
                    @endphp

                    @foreach($order->items as $item)
                        @php
                            $taxRate   = $item->tax_rate ?? 0;
                            $taxValue  = $item->tax_amount ?? 0;
                            $lineSubtotal = $item->price_unit * $item->quantity;
                            $lineTotal    = $lineSubtotal + $taxValue;

                            $subtotal += $lineSubtotal;
                            $totalTax += $taxValue;
                        @endphp
                        <tr>
                            <td class="py-2 px-2">{{ $item->label_item ?? $item->product->name }}</td>
                            <td class="py-2 px-2 text-center">{{ $item->quantity }}</td>
                            <td class="py-2 px-2 text-right">€{{ number_format($item->price_unit, 2) }}</td>
                            <td class="py-2 px-2 text-center">{{ $taxRate ? $taxRate.'%' : 'Isento' }}</td>
                            <td class="py-2 px-2 text-right">€{{ number_format($taxValue, 2) }}</td>
                            <td class="py-2 px-2 text-right">€{{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Resumen de la Orden -->
            @php
                $subtotal = 0;
                $totalTax = 0;

                foreach($order->items as $item) {
                    $lineSubtotal = $item->price_unit * $item->quantity;
                    $taxValue     = $item->tax_amount ?? 0;

                    $subtotal += $lineSubtotal;
                    $totalTax += $taxValue;
                }

                $totalLocal = $subtotal + $totalTax + ($order->shipping_cost ?? 0);

                $totalReal = strtolower($order->payment_method) === 'paypal' && $order->payment_provider_total
                    ? $order->payment_provider_total
                    : $totalLocal;
            @endphp

            <!-- Resumen de la Orden -->
            <div class="mt-6 border-t pt-4 space-y-1 text-sm">

            <!-- Subtotal e IVA -->
                <p class="flex justify-between text-gray-700">
                    <span>Subtotal (s/ IVA):</span>
                    <span>€{{ number_format($subtotal, 2) }}</span>
                </p>
                <p class="flex justify-between text-gray-700">
                    <span>Total IVA:</span>
                    <span>€{{ number_format($totalTax, 2) }}</span>
                </p>

                <!-- Envío -->
                <p class="flex justify-between text-gray-700">
                    <span>Envío:</span>
                    <span>€{{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                </p>

                <!-- Valores PayPal -->
                @if(strtolower($order->payment_method) === 'paypal' && $order->payment_provider_total)
                    <p class="flex justify-between text-gray-700">
                        <span>Comisión PayPal:</span>
                        <span>€ {{ number_format($order->payment_provider_fee ?? 0, 2) }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700">
                        <span>ID Transacción Paypal:</span>
                        <span>{{ $order->payment_provider_id }}</span>
                    </p>
                @endif

                <!-- Total final -->
                <p class="flex justify-between text-lg font-bold text-gray-900 mt-2">
                    <span>Total:</span>
                    <span>€{{ number_format($totalReal, 2) }}</span>
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
