@extends('admin.layout.home')

@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   {{-- breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            </li>

            <li>/</li>

            <li>
                <a href="{{ route('vintages.index') }}" class="text-blue-600 hover:underline">Añadas</a>
            </li>

        </ol>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        {{-- Formulário --}}
        <form action="{{ route('vintages.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
            @csrf
            <fieldset>
                <legend class="text-sm font-bold text-gray-700">Nova Safra</legend>
                <div class="mt-3 space-y-3">
                    <input name="year" type="number" placeholder="Ano da safra (ex: 2020)" required class="border p-2 w-full rounded" />
                    <button class="btn btn-primary w-full">Adicionar</button>
                </div>
            </fieldset>
        </form>

        {{-- Tabela --}}
        <div class="overflow-auto bg-white rounded-2xl shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Ano</th>
                        <th class="px-4 py-2 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vintages as $vintage)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $vintage->year }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('vintages.edit', $vintage->id) }}" 
                                    class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded text-sm hover:bg-green-700">Atualizar</a>
                                <form action="{{ route('vintages.destroy', $vintage->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta safra?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
