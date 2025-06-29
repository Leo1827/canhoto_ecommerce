<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="" :status="session('status')" />

    <h2 class="text-lg font-bold mb-2 ">Acesso</h2>
    <p class="text-sm text-gray-600 mb-6">Escolha como você deseja iniciar sua conta</p>

    <!-- Botón de Google Sign-In -->
    <div class="flex justify-center mb-4">
        <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-800 py-2 rounded hover:bg-gray-100 shadow">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5">
            Comece com o Google
        </a>
    </div>

    <div class="flex items-center my-4">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="mx-2 text-sm text-gray-500">ou</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input placeholder="E-mail" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 mx-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">

            <x-text-input placeholder="Senha" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 mx-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('lembre de mim') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Conecte-se') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
