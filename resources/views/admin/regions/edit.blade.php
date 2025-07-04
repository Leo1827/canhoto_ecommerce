@extends('admin.layout.home')

@section('content')
<div class="p-6">
    @include('admin.regions.partials.breadcrumb', ['editing' => true])

    <h2 class="text-xl font-bold mb-4">Editar Região</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('regions.update', $region->id) }}" method="POST" class="bg-white p-4 rounded-2xl shadow max-w-xl mx-auto">
        @csrf
        @method('PUT')

        <fieldset class="border border-gray-200 p-4 rounded-xl">
            <legend class="text-sm font-bold text-gray-700 px-2">Editar Região</legend>
            <div class="grid gap-4">
                <input type="text" name="name" value="{{ old('name', $region->name) }}" placeholder="Nome da Região"
                       class="border p-2 border-gray-300 rounded" required />

                <input name="country" placeholder="País da Região" required 
                        class="border p-1 border-gray-300" value="{{ old('country', $region->country ?? '') }}">
                
                        <div class="flex gap-4 mt-2">
                    <button class="btn btn-primary">Atualizar</button>
                    <a href="{{ route('regions.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection
