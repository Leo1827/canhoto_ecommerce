@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Histórico de Assinaturas</h2>

    {{-- Tabela para desktop --}}
    <div class="overflow-auto bg-white rounded-2xl shadow hidden md:block">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Usuário</th>
                    <th class="px-4 py-2">Plano</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Data</th>
                    <th class="px-4 py-2">Descrição</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($history as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->user->name }}</td>
                        <td class="px-4 py-2">{{ $item->subscription?->plan->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($item->status) }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->subscribed_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $item->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Nenhum histórico ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Cards para dispositivos móveis --}}
    <div class="md:hidden space-y-4">
        @forelse ($history as $item)
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">👤 Usuário:</span>
                    <p class="text-gray-900">{{ $item->user->name }}</p>
                </div>

                <div class="mb-2">
                    <span class="font-semibold text-gray-700">📦 Plano:</span>
                    <p class="text-gray-900">{{ $item->subscription?->plan->name ?? '-' }}</p>
                </div>

                <div class="mb-2">
                    <span class="font-semibold text-gray-700">📍 Status:</span>
                    <p class="text-gray-900">{{ ucfirst($item->status) }}</p>
                </div>

                <div class="mb-2">
                    <span class="font-semibold text-gray-700">🗓️ Data:</span>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($item->subscribed_at)->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">📝 Descrição:</span>
                    <p class="text-gray-900">{{ $item->description ?? '-' }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Nenhum histórico ainda.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $history->links() }}
    </div>
</div>
@endsection
