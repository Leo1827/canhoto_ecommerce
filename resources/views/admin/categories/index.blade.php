{{-- resources/views/admin/categories/index.blade.php --}}

@extends('admin.layout.home')

@section('content')
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

    <div class="p-6">
        <x-breadcrumb :module="$module" />

        <h2 class="text-xl font-bold mb-4">Categorias</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Formulário --}}
            <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow h-fit">
                @csrf
                <fieldset class="border border-gray-200 p-4 rounded-xl">
                    <legend class="text-sm font-bold text-gray-700 px-2">Nova Categoria</legend>
                    <div class="grid gap-4">
                        <input name="name" placeholder="Nome da Categoria" required class="border p-1 border-gray-300" />
                        {{-- Campo oculto para module --}}
                        <input type="hidden" name="module" value="{{ $module }}" />
                        <select name="parent" class="border p-1 border-gray-300">
                            <option value="0">Categoria Pai (Principal)</option>
                            @foreach ($categories as $cat)
                                @if ($cat->parent == 0)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button class="btn btn-primary mt-4">Adicionar Categoria</button>
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
                            <th class="px-4 py-2">Categoria Pai</th>
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $category->name }}</td>
                                <td class="px-4 py-2">{{ $category->slug }}</td>
                                <td class="px-4 py-2">
                                    @if ($category->parent == 0)
                                        <span class="text-gray-600 italic">Nenhuma</span>
                                    @else
                                        {{ optional($categories->where('id', $category->parent)->first())->name ?? 'Desconhecida' }}
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('categories.subcategories', $category->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-500 text-white rounded-2xl text-sm font-medium hover:bg-indigo-700 transition duration-150">
                                        Subcategorias
                                    </a>

                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                                        Atualizar
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta categoria?')">
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
