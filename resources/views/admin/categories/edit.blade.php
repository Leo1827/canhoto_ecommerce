@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <x-breadcrumb :module="$category->module" :editing="true" />

    <h2 class="text-xl font-bold mb-4">Editar Categoria</h2>

    {{-- Alertas --}}
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

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-4 rounded-2xl shadow max-w-4xl mx-auto">
        @csrf
        @method('PUT')

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm bg-red-100 border border-red-300 rounded p-2">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <fieldset class="border border-gray-200 p-4 rounded-xl">
            <legend class="text-sm font-bold text-gray-700 px-2">Editar Categoria</legend>

            <div class="grid md:grid-cols-4 gap-4">
                <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Nome da Categoria" required class="border p-2 border-gray-300 rounded" />

                {{-- Campo oculto para módulo --}}
                <input type="hidden" name="module" value="{{ $category->module }}" />

                {{-- Categoria Pai --}}
                <select name="parent" class="border p-2 border-gray-300 rounded">
                    <option value="0">Categoria Principal</option>
                    @foreach($allCategories as $cat)
                        @if ($cat->id != $category->id)
                            <option value="{{ $cat->id }}" {{ old('parent', $category->parent) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mt-4 flex gap-4">
                <button class="btn btn-primary">Atualizar Categoria</button>
                <a href="{{ route('categories.index', ['module' => $category->module]) }}" class="btn btn-outline">Cancelar</a>
            </div>
        </fieldset>
    </form>

</div>
@endsection
