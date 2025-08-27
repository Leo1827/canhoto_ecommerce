@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Atualizar Cliente</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 mb-3" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Início</a>
            </li>
            <li><span class="mx-1">/</span></li>
            <li>
                <a href="{{ route('admin.customers.index') }}" class="text-blue-600 hover:underline">Clientes</a>
            </li>
            <li><span class="mx-1">/</span></li>
            <li class="text-gray-700 font-semibold">Editar: {{ $user->id }} - {{ $user->email }}</li>
        </ol>
    </nav>

    <!-- Formulário de edição -->
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('customers.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="usertype" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="usertype" id="usertype"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="user" {{ old('usertype', $user->usertype) == 'user' ? 'selected' : '' }}>Usuário</option>
                        <option value="admin" {{ old('usertype', $user->usertype) == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('usertype')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botões -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.customers.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
