<section>
    <header>
        <h2 class="text-base font-semibold text-gray-800">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            {{ __('Atualize suas informações de perfil e endereço de e-mail.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-4 text-sm">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome')" class="text-xs text-gray-700" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-1 text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('E-mail')" class="text-xs text-gray-700" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-1 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-xs text-gray-600">
                    <p>{{ __('Seu endereço de e-mail ainda não foi verificado.') }}</p>

                    <button form="send-verification"
                        class="underline text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 font-medium text-green-600">
                            {{ __('Um novo link de verificação foi enviado para seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button class="text-sm px-4 py-2">
                {{ __('Salvar') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-gray-500"
                >
                    {{ __('Salvo.') }}
                </p>
            @endif
        </div>
    </form>
</section>
