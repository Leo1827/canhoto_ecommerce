@extends('admin.layout.home')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('conditions.update', $condition->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow">
        @csrf @method('PUT')

        <div class="space-y-4">
            <input type="text" name="name" value="{{ old('name', $condition->name) }}" placeholder="Nome da condição" required class="border p-2 w-full rounded" />

            <div class="flex gap-4 mt-4">
                <button class="btn btn-primary">Atualizar</button>
                <a href="{{ route('conditions.index') }}" class="btn btn-outline">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection
