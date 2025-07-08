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
    {{-- breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            </li>

            <li>/</li>

            <li>
                <a href="{{ route('vintages.index') }}" class="text-blue-600 hover:underline">Añadas</a>
            </li>

        </ol>
    </nav>

    <form action="{{ route('vintages.update', $vintage->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow">
        @csrf @method('PUT')

        <div class="space-y-4">
            <input type="number" name="year" value="{{ old('year', $vintage->year) }}" placeholder="Ano da safra" required class="border p-2 w-full rounded" />

            <div class="flex gap-4 mt-4">
                <button class="btn btn-primary">Atualizar</button>
                <a href="{{ route('vintages.index') }}" class="btn btn-outline">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection
