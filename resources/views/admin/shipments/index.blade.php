@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📦 Acompanhamento de encomendas</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-2xl overflow-hidden p-2">
        <table id="shipmentsTable" class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left"># Pedido</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">E-mail</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">#{{ $user->id }}</td>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">
                            @php
                                $lastOrder = $user->orders->first();
                            @endphp
                            @if($lastOrder)
                                <span class="px-2 py-1 rounded text-sm" >
                                    {{ $user->email }}
                                    
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex space-x-2">
                            <a href="{{ route('admin.shipments.user_orders', $user->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                Ver Facturas/Pedidos
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                            No hay usuarios con pedidos en seguimiento.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection
