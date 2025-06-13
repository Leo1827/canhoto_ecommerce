<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Obrigado por se registar! Antes de começar, pode verificar o seu endereço de e-mail clicando no link que acabámos de enviar? Se não recebeu o e-mail, teremos todo o gosto em enviar outro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que forneceu durante o registo.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Reenviar E-mail de Verificação') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Terminar Sessão') }}
            </button>
        </form>
    </div>
</x-guest-layout>