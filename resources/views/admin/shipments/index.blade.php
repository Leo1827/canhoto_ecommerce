@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-xl font-bold mb-4">New Shipment</h1>

    <form action="{{ route('shipments.store') }}" method="POST" class="bg-white p-6 shadow rounded">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">Invoice</label>
            <select name="invoice_id" class="w-full border rounded p-2" required>
                @foreach($invoices as $invoice)
                    <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Tracking Number</label>
            <input type="text" name="tracking_number" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
