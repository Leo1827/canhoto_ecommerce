@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Clientes</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <nav class="text-sm text-gray-600 mb-3" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Inicio</a>
            </li>
            <li><span class="mx-1">/</span></li>
            <li class="text-gray-700 font-semibold">Clientes</li>
        </ol>
    </nav>

    <a href="{{ route('admin.customers.create') }}" class="btn btn-success relative justify-end my-4">Novo Cliente</a>

    {{-- content --}}
    <table id="customerTable" class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr class="border-b">
                <td class="p-3">{{ $customer->name }}</td>
                <td class="p-3">{{ $customer->email }}</td>
                <td class="p-3">{{ $customer->usertype }}</td>
                <td class="p-3 flex space-x-2">
                    <a href="{{ route('admin.customers.showAddress', $customer) }}" class="text-blue-500">Endereços </a>
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="text-yellow-500">Edit</a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
