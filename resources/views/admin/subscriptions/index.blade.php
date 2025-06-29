@extends('admin.layout.home')

@section('content')

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Assinaturas</h2>

    {{-- Tabela para desktop --}}
    <div class="overflow-auto bg-white rounded-2xl shadow hidden md:block">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Usuário</th>
                    <th class="px-4 py-2">Plano</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Quantidade</th>
                    <th class="px-4 py-2">Teste grátis até</th>
                    <th class="px-4 py-2">Fim</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $sub)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $sub->user?->name ?? 'Usuário indisponível' }}</td>
                        <td class="px-4 py-2">{{ $sub->plan->name }}</td>
                        <td class="px-4 py-2">{{ $sub->stripe_status ?? 'manual' }}</td>
                        <td class="px-4 py-2">{{ $sub->quantity }}</td>
                        <td class="px-4 py-2">{{ $sub->trial_ends_at ? \Carbon\Carbon::parse($sub->trial_ends_at)->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2">
                            {{ $sub->ends_at ? \Carbon\Carbon::parse($sub->ends_at)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.subscriptions.edit', $sub) }}" 
                            class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                            Atualizar
                        </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Cartões para dispositivos móveis --}}
    <div class="md:hidden space-y-4">
        @forelse ($subscriptions as $sub)
            <div class="bg-white p-4 rounded shadow">
                <p><strong>Usuário:</strong> {{ $sub->user?->name ?? 'Usuário indisponível' }}</p>
                <p><strong>Plano:</strong> {{ $sub->plan->name }}</p>
                <p><strong>Status:</strong> {{ $sub->stripe_status ?? 'manual' }}</p>
                <p><strong>Quantidade:</strong> {{ $sub->quantity }}</p>
                <p><strong>Teste grátis até:</strong> {{ $sub->trial_ends_at ? \Carbon\Carbon::parse($sub->trial_ends_at)->format('d/m/Y') : '-' }}</p>
                <p><strong>Fim:</strong> {{ $sub->ends_at ? \Carbon\Carbon::parse($sub->ends_at)->format('d/m/Y') : '-' }}</p>

                <div class="flex gap-2 mt-3">
                    <a href="{{ route('admin.subscriptions.edit', $sub) }}" 
                    class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                    ✏️
                </a>
                    
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Nenhuma assinatura registrada.</p>
        @endforelse
    </div>
</div>
@endsection
