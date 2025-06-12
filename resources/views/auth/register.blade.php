<x-guest-layout>
    <h1 class="text-center text-xl font-semibold mb-4">Garrafeira Canhoto</h1>
    
    <h2 class="text-lg font-bold mb-2">Criar conta</h2>
    <p class="text-sm text-gray-600 mb-6">Escolha como pretende criar a sua conta</p>

    <!-- Botón de Google Sign-In -->
    <div class="flex justify-center mb-4">
        <a href="" class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-800 py-2 rounded hover:bg-gray-100 shadow">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5">
            Registrar com Google
        </a>
    </div>

    <div class="flex items-center my-4">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="mx-2 text-sm text-gray-500">ou</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Formulario tradicional -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <x-text-input id="email" placeholder="E-mail" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-text-input id="password" placeholder="Senha" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-text-input id="password_confirmation" placeholder="Confirme sua senha" class="block mt-1 w-full" type="password" name="password_confirmation"  autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Already registered -->
        <div class="flex mx-2 items-center justify-between">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                {{ __('Já está cadastrado?') }}
            </a>
            <x-primary-button>
                {{ __('Continuar') }}
            </x-primary-button>
        </div>

        <div class="my-4 mx-2 text-sm">
            <a href="" class="pr-4">
                <span>Privacidade</span>
            </a>

            <a href="">
                <span>Termos</span>
            </a>
        </div>
    </form>
</x-guest-layout>
