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
                    <a href="{{ route('wine_types.index') }}" class="text-blue-600 hover:underline">Tipos de vinho</a>
                </li>

                @if (isset($editing) && $editing === true)
                    <li>/</li>
                    <li class="text-gray-800 font-semibold">Editar</li>
                @endif

                @if (isset($creating) && $creating === true)
                    <li>/</li>
                    <li class="text-gray-800 font-semibold">Nova</li>
                @endif
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <form action="{{ route('wine_types.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
                @csrf
                <fieldset>
                    <legend class="text-sm font-bold text-gray-700">Novo Tipo de Vinho</legend>
                    <div class="mt-2 space-y-3">
                        <input name="name" placeholder="Ex: Tinto, Branco..." required class="border p-2 w-full rounded" />
                        <button class="btn btn-primary">Adicionar</button>
                    </div>
                </fieldset>
            </form>

            <div class="overflow-auto bg-white rounded-2xl shadow">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nome</th>
                            <th class="px-4 py-2 text-left">Slug</th>
                            <th class="px-4 py-2 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wineTypes as $type)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $type->name }}</td>
                                <td class="px-4 py-2">{{ $type->slug }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('wine_types.edit', $type->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded text-sm hover:bg-green-700">Atualizar</a>
                                    <form action="{{ route('wine_types.destroy', $type->id) }}" method="POST"
                                          onsubmit="return confirm('Deseja excluir este tipo de vinho?')">
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
