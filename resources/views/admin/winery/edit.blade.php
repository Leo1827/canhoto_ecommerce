@extends('admin.layout.home')

@section('content')
    <div class="p-6">

        <h2 class="text-xl font-bold mb-4">Editar Vinícola</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm bg-red-100 border border-red-300 rounded p-2">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('wineries.update', $winery->id) }}" method="POST" class="bg-white p-4 rounded-2xl shadow max-w-4xl mx-auto">
            @csrf
            @method('PUT')

            <fieldset class="border border-gray-200 p-4 rounded-xl">
                <legend class="text-sm font-bold text-gray-700 px-2">Editar Vinícola</legend>

                <div class="grid md:grid-cols-2 gap-4">
                    <input type="text" name="name" value="{{ old('name', $winery->name) }}" placeholder="Nome da Vinícola" required class="border p-2 border-gray-300 rounded" />
                </div>

                <div class="mt-4 flex gap-4">
                    <button class="btn btn-primary">Atualizar Vinícola</button>
                    <a href="{{ route('wineries.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
