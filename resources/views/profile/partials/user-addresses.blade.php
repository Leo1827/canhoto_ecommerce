<section>
    <header class="mb-6">
        <h2 class="text-base font-semibold text-gray-900">
            {{ __('Endereços salvos') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Gerencie seus endereços de envio salvos.') }}
        </p>
    </header>

    {{-- Formulário para adicionar novo endereço --}}
    <form method="POST" action="{{ route('addresses.store') }}" class="space-y-4 text-sm">
        @csrf

        <div>
            <x-input-label for="full_name" class="text-gray-700 text-sm" :value="__('Nome completo')" />
            <x-text-input id="full_name" name="full_name" type="text"
                class="mt-1 block w-full h-9 text-sm px-3" required />
            <x-input-error :messages="$errors->get('full_name')" class="mt-1 text-xs text-red-500" />
        </div>

        <div>
            <x-input-label for="address" class="text-gray-700 text-sm" :value="__('Endereço')" />
            <x-text-input id="address" name="address" type="text"
                class="mt-1 block w-full h-9 text-sm px-3" required />
            <x-input-error :messages="$errors->get('address')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="city" class="text-gray-700 text-sm" :value="__('Cidade')" />
                <x-text-input id="city" name="city" type="text"
                    class="mt-1 block w-full h-9 text-sm px-3" required />
                <x-input-error :messages="$errors->get('city')" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
                <x-input-label for="state" class="text-gray-700 text-sm" :value="__('Estado')" />
                <x-text-input id="state" name="state" type="text"
                    class="mt-1 block w-full h-9 text-sm px-3" required />
                <x-input-error :messages="$errors->get('state')" class="mt-1 text-xs text-red-500" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="country" class="text-gray-700 text-sm" :value="__('País')" />
                <x-text-input id="country" name="country" type="text"
                    class="mt-1 block w-full h-9 text-sm px-3" required />
                <x-input-error :messages="$errors->get('country')" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
                <x-input-label for="postal_code" class="text-gray-700 text-sm" :value="__('CEP')" />
                <x-text-input id="postal_code" name="postal_code" type="text"
                    class="mt-1 block w-full h-9 text-sm px-3" required />
                <x-input-error :messages="$errors->get('postal_code')" class="mt-1 text-xs text-red-500" />
            </div>
        </div>

        <div>
            <x-input-label for="phone" class="text-gray-700 text-sm" :value="__('Telefone')" />
            <x-text-input id="phone" name="phone" type="text"
                class="mt-1 block w-full h-9 text-sm px-3" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-4 py-2 text-sm">
                {{ __('Salvar endereço') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Lista de endereços existentes --}}
    @if (auth()->user()->addresses->count())
        <div class="mt-10 space-y-4">
            @foreach (auth()->user()->addresses as $address)
                <div class="border border-gray-200 p-4 rounded-lg bg-gray-50 text-sm">
                    <div class="flex justify-between items-start">
                        <div class="text-gray-800 space-y-1">
                            <p class="font-medium">{{ $address->full_name }}</p>
                            <p>{{ $address->address }}, {{ $address->city }} - {{ $address->state }}</p>
                            <p>{{ $address->country }}, {{ $address->postal_code }} - {{ $address->phone }}</p>
                        </div>

                        <div class="flex space-x-2">
                            {{-- Editar --}}
                            <form method="POST" action="{{ route('addresses.update', $address->id) }}">
                                @csrf
                                @method('PUT')
                                <x-secondary-button class="text-xs px-3 py-1">
                                    {{ __('Editar') }}
                                </x-secondary-button>
                            </form>

                            {{-- Eliminar --}}
                            <form method="POST" action="{{ route('addresses.destroy', $address->id) }}"
                                onsubmit="return confirm('Tem certeza que deseja excluir este endereço?')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="text-xs px-3 py-1">
                                    {{ __('Excluir') }}
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
