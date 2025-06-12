@extends('layouts.front')
{{-- include nav--}}
@include('layouts.nav')

@section('meta')
    <meta name="description" content="Ecommerce de vinos exclusivos - Garrafeira Canhoto - Canhoto Black">
@endsection

@section('title')
    <title>Garrafeira Canhoto - Vinos Exclusivos</title>
@endsection

@section('style')
    <style>
        /* Puedes añadir estilos personalizados aquí si deseas */
    </style>
@endsection

@section('content')
    {{-- Hero principal --}}
    <section class="relative bg-cover bg-center h-screen text-white" style="background-image: url('/images/hero-vino.jpg')">
        <div class="bg-black bg-opacity-60 h-full w-full flex items-center justify-center">
            <div class="text-center px-6 max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Vinos Exclusivos para Paladares Únicos</h1>
                <p class="text-lg md:text-xl mb-8">Únete a la comunidad privada de amantes del vino. Explora una tienda exclusiva donde cada botella cuenta una historia.</p>
                <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition">
                    Únete Ahora
                </a>
            </div>
        </div>
    </section>

    {{-- Beneficios de la plataforma --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">¿Por qué Garrafeira Canhoto?</h2>
            <p class="text-gray-600 mt-4">Disfruta de una experiencia de compra como nunca antes.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <h3 class="text-xl font-semibold text-red-600 mb-3">Selección Privada</h3>
                <p class="text-gray-600">Accede a vinos premium no disponibles en tiendas públicas, seleccionados por expertos sommeliers.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <h3 class="text-xl font-semibold text-yellow-700 mb-3">Contenido Exclusivo</h3>
                <p class="text-gray-600">Imágenes, videos, historia y maridajes recomendados para cada vino en tu catálogo personalizado.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <h3 class="text-xl font-semibold text-purple-700 mb-3">Experiencia Segura</h3>
                <p class="text-gray-600">Inicio de sesión con Google, cifrado de datos, métodos de pago confiables y gestión de usuarios con roles.</p>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="text-center py-16 bg-gradient-to-br from-red-100 via-white to-yellow-50 rounded-xl mx-4 md:mx-32">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">¿Estás listo para descorchar esta experiencia?</h3>
        <p class="text-gray-600 mb-6">Crea tu cuenta o inicia sesión para comenzar tu viaje sensorial.</p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-full">
                Registrarse
            </a>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Aquí puedes añadir interacciones personalizadas si las necesitas
    </script>
@endsection
