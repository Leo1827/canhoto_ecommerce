@extends('admin.layout.home')

@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        {{-- Formulário --}}
        <form action="{{ route('conditions.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
            @csrf
            <fieldset>
                <legend class="text-sm font-bold text-gray-700">Nova Condição</legend>
                <div class="mt-3 space-y-3">
                    <input name="name" placeholder="Ex: Perfeita, Etiqueta danificada..." required class="border p-2 w-full rounded" />
                    <button class="btn btn-primary w-full">Adicionar</button>
                </div>
            </fieldset>
        </form>

        {{-- Tabela --}}
        <div class="overflow-auto bg-white rounded-2xl shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nome</th>
                        <th class="px-4 py-2 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conditions as $condition)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $condition->name }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('conditions.edit', $condition->id) }}" 
                                    class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded text-sm hover:bg-green-700">Atualizar</a>
                                <form action="{{ route('conditions.destroy', $condition->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta condição?')">
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
