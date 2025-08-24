@extends('admin.layout.home')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Pedidos do Cliente: {{ $user->name }}</h1>

        <table id="orderStatusTable" class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3 text-left">ID Pedido</th>
                    <th class="border p-3 text-left">Fatura</th>
                    <th class="border p-3 text-left">Total</th>
                    <th class="border p-3 text-left">Status</th>
                    <th class="border p-3 text-left">Data</th>
                    <th class="border p-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">#{{ $order->id }}</td>
                    
                    {{-- Número da fatura --}}
                    <td class="border p-3">
                        @if($order->invoice)
                            {{ $order->invoice->invoice_number ?? '—' }}
                        @else
                            <span class="text-gray-400">Sem fatura</span>
                        @endif
                    </td>

                    <td class="border p-3">€{{ number_format($order->total, 2, ',', '.') }}</td>
                    <td class="border p-3">
                        <span class="px-2 py-1 rounded text-sm
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status === 'shipped') bg-green-100 text-green-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="border p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="border p-3 text-center">
                        <a href="{{ route('admin.shipments.show', $order) }}" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                        🔍 Detalhe
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('admin.shipments.index') }}" 
               class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">⬅️ Voltar</a>
        </div>
    </div>
</div>
@endsection
