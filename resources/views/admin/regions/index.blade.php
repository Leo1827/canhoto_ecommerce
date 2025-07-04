@extends('admin.layout.home')

@section('content')
<div class="p-6">
    @include('admin.regions.partials.breadcrumb')

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-xl font-bold mb-4">Regiões</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Formulário --}}
        <form action="{{ route('regions.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow h-fit">
            @csrf
            <fieldset class="border border-gray-200 p-4 rounded-xl">
                <legend class="text-sm font-bold text-gray-700 px-2">Nova Região</legend>
                <div class="grid gap-4">
                    <input name="name" placeholder="Nome da Região" required class="border p-2 border-gray-300 rounded" />
                    <input name="country" placeholder="País da Região" required class="border p-1 border-gray-300" value="{{ old('country', $region->country ?? '') }}">
                    <button class="btn btn-primary mt-2">Adicionar</button>
                </div>
            </fieldset>
        </form>

        {{-- Tabela --}}
        <div class="overflow-auto bg-white rounded-2xl shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">Nome</th>
                        <th class="px-4 py-2">Slug</th>
                        <th class="px-4 py-2">País</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regions as $region)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $region->name }}</td>
                            <td class="px-4 py-2">{{ $region->slug }}</td>
                            <td class="px-4 py-2">{{ $region->country }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('regions.edit', $region->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded text-sm hover:bg-green-700">Atualizar</a>
                                <form action="{{ route('regions.destroy', $region->id) }}" method="POST"
                                      onsubmit="return confirm('Deseja excluir esta região?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded">Excluir</button>
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
