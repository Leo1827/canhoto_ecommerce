@extends('layouts.front')

@section('meta')
    <meta name="description" content="Suscríbete a Garrafeira Canhoto">
@endsection

@section('title')
    <title>Suscripción Premium | Garrafeira Canhoto</title>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-16 text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-6">¡Gracias por tu suscripción!</h1>
        <p class="text-gray-700 text-lg">
            Tu pago fue procesado correctamente. Ahora tienes acceso completo al contenido premium.
        </p>
        <a href="{{ route('products.user.store') }}" class="inline-block mt-6 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
            Ir al Panel de Usuario
        </a>
    </div>
@endsection
