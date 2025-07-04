@extends('admin.layout.home')

@section('content')
    <div class="p-6">
        {{-- breadcrumb --}}
        <nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                </li>

                <li>/</li>

                <li>
                    <a href="{{ route('wineries.index') }}" class="text-blue-600 hover:underline">Vinícolas</a>
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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-4">Vinícolas</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Formulário --}}
            <form action="{{ route('wineries.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow h-fit">
                @csrf
                <fieldset class="border border-gray-200 p-4 rounded-xl">
                    <legend class="text-sm font-bold text-gray-700 px-2">Nova Vinícola</legend>
                    <div class="grid gap-4">
                        <input name="name" placeholder="Nome da Vinícola" required class="border p-1 border-gray-300 rounded" value="{{ old('name') }}" />
                        <button class="btn btn-primary mt-4">Adicionar Vinícola</button>
                    </div>
                </fieldset>
            </form>

            {{-- Tabela --}}
            <div class="overflow-auto bg-white rounded-2xl shadow">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2">Nome</th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wineries as $winery)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $winery->name }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('wineries.edit', $winery->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                                        Atualizar
                                    </a>
                                    <form action="{{ route('wineries.destroy', $winery->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta vinícola?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-2xl">Excluir</button>
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
