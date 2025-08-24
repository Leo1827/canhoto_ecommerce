@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('admin.invoices.index') }}" 
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition">
            ← Voltar
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detalhe da Fatura</h1>

    <!-- Informações da fatura -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Fatura #{{ $invoice->invoice_number }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Cliente:</strong> {{ $invoice->client_name }}</p>
                <p><strong>Email:</strong> {{ $invoice->client_email }}</p>
                <p><strong>Endereço de Cobrança:</strong> {{ $invoice->billing_address ?? 'N/A' }}</p>
            </div>
            <div>
                <p><strong>Valor:</strong> R${{ number_format($invoice->amount, 2) }} {{ $invoice->currency }}</p>
                <p><strong>Método de Pagamento:</strong> {{ ucfirst($invoice->payment_method) }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 rounded text-white 
                        {{ $invoice->status == 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </p>
                <p><strong>Data de Emissão:</strong> {{ $invoice->issue_date }}</p>
                <p><strong>Data de Vencimento:</strong> {{ $invoice->due_date ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Informações de envio -->
    @if($invoice->order->userAddress)
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Endereço de Entrega</h2>
        <p><strong>Nome:</strong> {{ $invoice->order->userAddress->full_name }}</p>
        <p><strong>Endereço:</strong> {{ $invoice->order->userAddress->address }}, {{ $invoice->order->userAddress->city }}</p>
        <p><strong>Estado:</strong> {{ $invoice->order->userAddress->state }}</p>
        <p><strong>País:</strong> {{ $invoice->order->userAddress->country }}</p>
        <p><strong>CEP:</strong> {{ $invoice->order->userAddress->postal_code }}</p>
        <p><strong>Telefone:</strong> {{ $invoice->order->userAddress->phone }}</p>
    </div>
    @endif

    <!-- Produtos do pedido -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Produtos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Produto</th>
                        <th class="px-4 py-2 text-center">Quantidade</th>
                        <th class="px-4 py-2 text-right">Preço Unitário</th>
                        <th class="px-4 py-2 text-right"></th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->order->items as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->label_item ?? $item->product->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-right">R${{ number_format($item->price_unit, 2) }}</td>
                        <td class="px-4 py-2 text-right">
                            @if($item->discount_status)
                                -{{ $item->discount }}%
                            @else
                                
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">R${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-right font-semibold">Subtotal:</td>
                        <td class="px-4 py-2 text-right">€{{ number_format($invoice->order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-right font-semibold">Frete:</td>
                        <td class="px-4 py-2 text-right">€{{ number_format($invoice->order->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-right font-semibold">Impostos:</td>
                        <td class="px-4 py-2 text-right">€{{ number_format($invoice->order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-right font-bold">Total:</td>
                        <td class="px-4 py-2 text-right font-bold">€{{ number_format($invoice->order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Histórico de status -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Histórico de Status</h2>
        <ul class="space-y-3">
            @foreach($invoice->order->statusHistories as $history)
            <li class="border-b pb-2">
                <p><strong>Status:</strong> {{ ucfirst($history->status) }}</p>
                <p><strong>Descrição:</strong> {{ $history->description ?? '-' }}</p>
                <p class="text-gray-500 text-sm">Alterado em: {{ $history->changed_at }}</p>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
