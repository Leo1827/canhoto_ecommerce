@extends('admin.layout.home')

@section('content')
<div class="">

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-xl shadow mb-4 bg-white rounded-2xl p-2">Criar pedidos</h2>

    <div class="grid grid-cols-1 gap-6">
        {{-- form --}}
        @include('admin.orders.partials.form')

    </div>
</div>
@endsection
