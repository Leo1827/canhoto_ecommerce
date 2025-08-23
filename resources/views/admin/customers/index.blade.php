@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Customers</h1>

    <a href="{{ route('customers.create') }}" 
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        + New Customer
    </a>

    <table class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr class="border-b">
                <td class="p-3">{{ $customer->name }}</td>
                <td class="p-3">{{ $customer->email }}</td>
                <td class="p-3">{{ $customer->phone }}</td>
                <td class="p-3 flex space-x-2">
                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-500">View</a>
                    <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-500">Edit</a>
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
