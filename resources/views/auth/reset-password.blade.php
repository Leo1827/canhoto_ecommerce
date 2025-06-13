<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Mensaje si el token está vencido o inválido -->
        @if ($errors->has('token'))
            <div class="mb-4 p-4 text-sm text-red-800 bg-red-100 border border-red-200 rounded-lg">
                {{ __('passwords.token') }}
            </div>
        @endif

        <!-- Email Address -->
        <div>
            <x-text-input id="email" placeholder="E-mail" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" placeholder="Senha" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation" placeholder="Confirme sua senha" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Redefinir senha') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
