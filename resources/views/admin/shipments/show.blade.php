@extends('admin.layout.home')

@section('content')
<div class="container mx-auto py-8 md:px-10 px-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-[#4B0D0D] mb-6">Pedido #{{ $order->id }}</h1>

        <div class="space-y-2 text-gray-700">
            <p><strong>Cliente:</strong> {{ $order->user->name }}</p>
            <p><strong>Total:</strong> €{{ number_format($order->total, 2, ',', '.') }}</p>
            <p><strong>Status atual:</strong> 
                <span class="px-2 py-1 rounded text-white
                    @if($order->status == 'pending') bg-yellow-500 
                    @elseif($order->status == 'shipped') bg-green-600 
                    @elseif($order->status == 'delivered') bg-blue-600
                    @elseif($order->status == 'cancelled') bg-red-600 
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        {{-- Histórico --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-[#4B0D0D]">Histórico de Envio</h2>
        <div class="space-y-4">
            @foreach($order->statusHistories as $history)
                <div class="border border-gray-200 bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ ucfirst($history->status) }} - {{ \Carbon\Carbon::parse($history->changed_at)->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $history->description }}</p>
                    </div>
                    <form action="{{ route('admin.shipments.destroy', $history) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este histórico?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                            🗑️ Excluir
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Formulário para adicionar novo status --}}
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-[#4B0D0D] mb-3">Adicionar novo status</h3>
            <form action="{{ route('admin.shipments.storeStatus', $order) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block mb-1 text-gray-700">Selecione o status:</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="shipped">Enviado</option>
                        <option value="delivered">Entregue</option>
                        <option value="cancelled">Cancelado</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700">Descrição (opcional):</label>
                    <textarea name="description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    ➕ Adicionar Status
                </button>
            </form>
        </div>

        {{-- Botões --}}
        <div class="mt-8">
            <a href="{{ route('admin.shipments.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-[#4B0D0D] font-semibold px-4 py-2 rounded-lg shadow transition">
                ⬅️ Voltar
            </a>
        </div>
    </div>
</div>
@endsection
