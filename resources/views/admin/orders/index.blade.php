@extends('admin.layout.home')

@section('content')
<div class="p-6">


    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-xl font-bold mb-4">Criar pedidos</h2>

    <div class="grid grid-cols-1 gap-6">
        {{-- form --}}
        @include('admin.orders.partials.form')
        {{-- Tabla --}}
        {{-- <div class="overflow-auto bg-white rounded-2xl shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Cliente</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                            <td class="px-4 py-2">${{ $order->total }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded text-sm hover:bg-green-700">Actualizar</a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar esta orden?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>
</div>
@endsection
