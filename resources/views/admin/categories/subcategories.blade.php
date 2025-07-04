@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <x-breadcrumb :module="$module" :parentCategory="$parentCategory" :subview="true" />

    <h2 class="text-xl font-bold mb-4">Subcategorias de: {{ $parentCategory->name }}</h2>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Formulário --}}
        <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-4 rounded-2xl shadow h-fit">
            @csrf
            <fieldset class="border border-gray-200 p-4 rounded-xl">
                <legend class="text-sm font-bold text-gray-700 px-2">Nova Subcategoria</legend>
                <div class="grid gap-4">
                    <input name="name" placeholder="Nome da Subcategoria" required class="border p-1 border-gray-300" />
                    <input type="hidden" name="module" value="{{ $module }}" />
                    <input type="hidden" name="parent" value="{{ $parentCategory->id }}" />
                    <button class="btn btn-primary mt-4">Adicionar Subcategoria</button>
                </div>
            </fieldset>
        </form>

        {{-- Lista de Subcategorias --}}
        <div class="overflow-auto bg-white rounded-2xl shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">Nome</th>
                        <th class="px-4 py-2">Slug</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">{{ $category->slug }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                                    Atualizar
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta subcategoria?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-2xl">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Nenhuma subcategoria cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
