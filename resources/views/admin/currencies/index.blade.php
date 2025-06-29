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
    <h2 class="text-xl font-bold mb-4">Moedas</h2>

    {{-- Formulário de criação --}}
    <form action="{{ route('admin.currencies.store') }}" method="POST" class="mb-6 bg-white p-4 rounded-2xl shadow">
        @csrf
        <div class="grid md:grid-cols-4 gap-4">
            <input name="code" placeholder="Código (ex: USD)" required class="border p-1 border-gray-300" />
            <input name="name" placeholder="Nome (ex: Dólar)" required class="border p-1 border-gray-300" />
            <input name="symbol" placeholder="Símbolo (ex: $)" required class="border p-1 border-gray-300" />
            <input name="rate" type="number" step="0.000001" placeholder="Taxa de câmbio" required class="border p-1 border-gray-300" />
        </div>
        <button class="mt-3 btn btn-primary">Adicionar Moeda</button>
    </form>

    {{-- Tabela para desktop --}}
    <div class="overflow-auto bg-white rounded-2xl shadow hidden md:block">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Símbolo</th>
                    <th class="px-4 py-2">Taxa</th>
                    <th class="px-4 py-2">Ativa</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currencies as $currency)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $currency->code }}</td>
                        <td class="px-4 py-2">{{ $currency->name }}</td>
                        <td class="px-4 py-2">{{ $currency->symbol }}</td>
                        <td class="px-4 py-2">{{ $currency->rate }}</td>
                        <td class="px-4 py-2 text-center">
                            {{-- Switch --}}
                            <div 
                                x-data="{ active: {{ $currency->is_active ? 'true' : 'false' }} }"
                                @click="
                                    fetch('{{ route('admin.currencies.toggleActive', $currency->id) }}', {
                                        method: 'PATCH',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    }).then(res => res.json()).then(data => active = data.active)
                                "
                                class="relative inline-block w-14 h-7 cursor-pointer"
                                :title="active ? 'Ativa' : 'Inativa'"
                            >
                                <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>
                                <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                            </div>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.currencies.edit', $currency->id) }}" 
                                class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                                Atualizar
                            </a>
                            <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta moeda?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-2xl">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Cards para mobile --}}
    <div class="md:hidden space-y-4">
        @forelse ($currencies as $currency)
            <div class="bg-white p-4 rounded-2xl shadow">
                <h3 class="text-lg font-semibold">{{ $currency->name }} ({{ $currency->code }})</h3>
                <p class="text-sm text-gray-600"><strong>Símbolo:</strong> {{ $currency->symbol }}</p>
                <p class="text-sm text-gray-600"><strong>Taxa:</strong> {{ $currency->rate }}</p>

                <div class="flex items-center justify-between mt-4">
                    <div x-data="{ active: {{ $currency->is_active ? 'true' : 'false' }} }"
                        @click="
                            fetch('{{ route('admin.currencies.toggleActive', $currency->id) }}', {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).then(res => res.json()).then(data => active = data.active)
                        "
                        class="relative inline-block w-14 h-7 cursor-pointer"
                        :title="active ? 'Ativa' : 'Inativa'"
                    >
                        <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>
                        <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.currencies.edit', $currency->id) }}" 
                            class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                            Atualizar
                        </a>
                        <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta moeda?')">
                            @csrf @method('DELETE')
                            <button class="text-sm px-3 py-1 bg-red-600 text-white rounded-2xl">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Nenhuma moeda cadastrada.</p>
        @endforelse
    </div>
</div>

@endsection
