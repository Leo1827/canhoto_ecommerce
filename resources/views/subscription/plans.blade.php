@extends('layouts.front')

@section('meta')
    <meta name="description" content="Loja exclusiva de vinhos finos - Garrafeira Canhoto - Canhoto Black">
@endsection

@section('title')
    <title>Garrafeira Canhoto - Vinhos Exclusivos</title>
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative">
        <!-- Botón de Logout -->
        <div class="absolute top-4 right-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded font-semibold">
                    Cerrar sesión
                </button>
            </form>
        </div>

        <div class="max-w-6xl w-full">
            <div class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Descubre el Mundo del Vino</h1>
                <p class="text-gray-400 text-lg">Accede a vinos exclusivos con nuestra membresía premium</p>
            </div>

            @if ($planes->isEmpty())
                <div class="text-center text-white text-2xl bg-gray-800 p-10 rounded-xl border border-red-600">
                    No hay planes disponibles por el momento.
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($planes as $plan)
                        <div class="bg-gray-900 rounded-2xl p-8 text-center text-white transition duration-300 hover:shadow-red-600/40 hover:shadow-lg border border-red-600">
                            <h2 class="text-3xl font-bold mb-2">{{ $plan->name }}</h2>
                            <p class="text-gray-400 mb-6">{{ $plan->description }}</p>

                            <div class="text-5xl font-extrabold text-red-500 mb-6">
                                ${{ number_format($plan->price, 0) }}
                                <span class="text-lg text-gray-400 font-medium">/ {{ $plan->interval }}</span>
                            </div>

                            <ul class="text-gray-300 text-sm space-y-2 mb-8">
                                <li>✔ Acceso ilimitado a catálogo premium</li>
                                <li>✔ Recomendaciones personalizadas</li>
                                <li>✔ Envíos prioritarios</li>
                                <li>✔ Eventos exclusivos</li>
                            </ul>

                            <form method="POST" action="">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-xl text-lg font-semibold transition duration-200">
                                    Suscribirme Ahora
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
