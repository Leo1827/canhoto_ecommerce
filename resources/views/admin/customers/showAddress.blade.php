@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Endereços do Cliente</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Migas de pan -->
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
            <li class="text-gray-700 font-semibold">Endereços: {{ $user->id }} - {{ $user->email }}</li>
        </ol>
    </nav>

    @include('admin.customers.partials.form-address')


    <!-- Tabla de direcciones -->
    <div class="bg-white shadow rounded-lg p-4 mt-2">
        <h2 class="text-lg font-semibold mb-3">Lista de Endereços</h2>

        @if($user->addresses->count() > 0)
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2 border">Nome Completo</th>
                        <th class="p-2 border">Endereço</th>
                        <th class="p-2 border">Cidade</th>
                        <th class="p-2 border">Estado</th>
                        <th class="p-2 border">País</th>
                        <th class="p-2 border">CEP</th>
                        <th class="p-2 border">Telefone</th>
                        <th class="p-2 border">Criado em</th>
                        <th class="p-2 border">Ações</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->addresses as $address)
                        <tr>
                            <td class="p-2 border">{{ $address->full_name }}</td>
                            <td class="p-2 border">{{ $address->address }}</td>
                            <td class="p-2 border">{{ $address->city }}</td>
                            <td class="p-2 border">{{ $address->state }}</td>
                            <td class="p-2 border">{{ $address->country }}</td>
                            <td class="p-2 border">{{ $address->postal_code }}</td>
                            <td class="p-2 border">{{ $address->phone ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $address->created_at->format('d/m/Y') }}</td>
                            <td class="p-2 border">
                                <form action="{{ route('customers.addresses.destroy', [$user->id, $address->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este endereço?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Este cliente não possui endereços cadastrados.</p>
        @endif
    </div>
</div>
@endsection
