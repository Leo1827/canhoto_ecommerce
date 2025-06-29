@extends('admin.layout.home')

@section('title', 'Planes')

@section('content')

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif


    {{-- Formulario de creación --}}
    @include('admin.plans.partials.form')

    {{-- Tabla de planes --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 mt-10">
        <h2 class="text-xl font-semibold mb-5 text-gray-700">Planos cadastrados</h2>
        <div class="overflow-x-auto">
            {{-- Tabla desktop --}}
            @include('admin.plans.partials.table')
            
            {{-- Tabla móvil --}}
            @include('admin.plans.partials.mobile-table')
        </div>
    </div>

@endsection

@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>

@endpush
