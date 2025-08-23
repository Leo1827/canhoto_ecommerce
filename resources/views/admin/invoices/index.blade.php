@extends('admin.layout.home')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Facturas</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla con DataTables responsive -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <table id="invoicesTable" class="table table-striped table-bordered nowrap w-full">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th>#</th>
                    <th>Número da Fatura</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Valor</th>
                    <th>Moeda</th>
                    <th>Status</th>
                    <th>Data de Emissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->client_name }}</td>
                    <td>{{ $invoice->client_email }}</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                    <td>{{ $invoice->currency }}</td>
                    <td>
                        <span class="px-2 py-1 rounded text-white 
                            {{ $invoice->status == 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td>{{ $invoice->issue_date }}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-success btn-sm">Ver</a>
                        @if($invoice->order)
                            <a href="{{ route('admin.user.orders.download', $invoice->order->id) }}" 
                                target="_blank" 
                                class="btn btn-primary btn-sm">
                                Imprimir
                            </a>
                        @endif

                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                              onsubmit="return confirm('Tem a certeza de que pretende eliminar esta fatura?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection