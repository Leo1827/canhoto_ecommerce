@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Métodos de Pagamento</h2>

        {{-- Formulário de criação --}}
        <form x-data="{ driver: '' }" action="{{ route('admin.payment_methods.store') }}" method="POST" class="mb-6 bg-white p-4 rounded-2xl shadow">
            @csrf
            <div class="grid md:grid-cols-3 gap-4">
                <input name="name" placeholder="Nome" required class="border p-2 border-gray-300 rounded-xl" />
                <input name="code" placeholder="Código" required class="border p-2 border-gray-300 rounded-xl" />
                <select name="driver" x-model="driver" class="border p-2 border-gray-300 rounded-xl" required>
                    <option value="">-- Seleccione o Driver --</option>
                    <option value="paypal">PayPal</option>
                    <option value="stripe">Stripe</option>
                    <option value="mollie">Mollie</option>
                    <option value="eupago">EuPago</option>
                </select>
                <input type="hidden" name="driver" :value="driver">

                <input name="icon" placeholder="Caminho do Ícone (/icons/paypal.svg)" class="border p-2 border-gray-300 rounded-xl" />
                <input name="order" type="number" placeholder="Ordem de exibição" class="border p-2 border-gray-300 rounded-xl" />
                <label class="flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_express" value="0">
                    <input type="checkbox" name="is_express" class="accent-red-600" value="1">
                    Exibir como Express?
                </label>
            </div>

            {{-- Configuração PayPal --}}
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'paypal'">
                <h4 class="font-semibold mb-3 text-gray-700">Configuração para PayPal</h4>
                <div class="grid md:grid-cols-3 gap-4">
                    <input type="text" name="config[client_id]" placeholder="Client ID do PayPal" class="border p-2 border-gray-300 rounded-xl" />
                    <input type="text" name="config[secret]" placeholder="Client Secret do PayPal" class="border p-2 border-gray-300 rounded-xl" />
                    <select name="config[mode]" class="border p-2 border-gray-300 rounded-xl">
                        <option value="sandbox">Sandbox</option>
                        <option value="live">Live</option>
                    </select>
                </div>
            </div>

            {{-- Configuração Stripe --}}
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'stripe'">
                <h4 class="font-semibold mb-3 text-gray-700">Configuração para Stripe</h4>
                <div class="grid md:grid-cols-3 gap-4">
                    <input type="text" name="config[public_key]" placeholder="Public Key" class="border p-2 border-gray-300 rounded-xl" />
                    <input type="text" name="config[secret_key]" placeholder="Secret Key" class="border p-2 border-gray-300 rounded-xl" />
                </div>
            </div>

            {{-- Configuração Mollie --}}
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border" x-show="driver === 'mollie'">
                <h4 class="font-semibold mb-3 text-gray-700">Configuração para Mollie</h4>
                <div class="grid md:grid-cols-3 gap-4">
                    <input type="text" name="config[mollie_api_key]" placeholder="API Key Mollie" ... />
                    <input type="text" name="config[mollie_profile_id]" placeholder="Profile ID Mollie" ... />

                </div>
            </div>


            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">
                    Adicionar Método
                </button>
            </div>
        </form>


    {{-- Tabela para desktop --}}
    <div class="overflow-auto bg-white rounded-2xl shadow hidden md:block">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Driver</th>
                    <th class="px-4 py-2">Ativo</th>
                    <th class="px-4 py-2">Ícone</th>
                    <th class="px-4 py-2">Express</th>
                    <th class="px-4 py-2">Ordem</th>
                    <th class="px-4 py-2">Configuração</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($methods as $method)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $method->name }}</td>
                        <td class="px-4 py-2">{{ $method->code }}</td>
                        <td class="px-4 py-2">{{ $method->driver ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            {{-- Switch --}}
                            <div 
                                x-data="{ active: {{ $method->is_active ? 'true' : 'false' }} }"
                                @click="
                                    fetch('{{ route('admin.payment_methods.toggleActive', $method->id) }}', {
                                        method: 'PATCH',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    }).then(res => res.json()).then(data => active = data.is_active)
                                "
                                class="relative inline-block w-14 h-7 cursor-pointer"
                                :title="active ? 'Ativo' : 'Inativo'"
                            >
                                <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>
                                <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            @if($method->icon)
                                <img src="{{ asset($method->icon) }}" alt="ícone" class="h-5">
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if($method->is_express)
                                <span class="text-green-600 font-semibold">Sim</span>
                            @else
                                <span class="text-gray-400">Não</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $method->order ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 max-w-[200px]">
                            @if(is_array($method->config))
                                @if($method->driver === 'paypal')
                                    <div><strong>Client ID:</strong> {{ \Illuminate\Support\Str::limit($method->config['client_id'] ?? '-', 30) }}</div>
                                    <div><strong>Modo:</strong> {{ ucfirst($method->config['mode'] ?? '-') }}</div>
                                @elseif($method->driver === 'stripe')
                                    <div><strong>Public Key:</strong> {{ \Illuminate\Support\Str::limit($method->config['public_key'] ?? '-', 30) }}</div>
                               @elseif($method->driver === 'mollie')
                                    <div><strong>API Key:</strong> {{ \Illuminate\Support\Str::limit($method->config['api_key'] ?? '-', 30) }}</div>
                                    <div><strong>Profile ID:</strong> {{ \Illuminate\Support\Str::limit($method->config['profile_id'] ?? '-', 30) }}</div>

                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.payment_methods.edit', $method->id) }}" 
                                class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                                Atualizar
                            </a>
                            <form action="{{ route('admin.payment_methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Deseja excluir este método?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-2xl">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Cards para mobile --}}
    <div class="md:hidden space-y-4">
        @forelse ($methods as $method)
            <div class="bg-white p-4 rounded-2xl shadow">
                <h3 class="text-lg font-semibold">{{ $method->name }}</h3>
                <p class="text-sm text-gray-600"><strong>Código:</strong> {{ $method->code }}</p>
                <p class="text-sm text-gray-600"><strong>Driver:</strong> {{ $method->driver ?? '-' }}</p>
                <p class="text-sm text-gray-600"><strong>Ícone:</strong>
                    @if($method->icon)
                        <img src="{{ asset($method->icon) }}" class="inline h-5" alt="ícone">
                    @else
                        -
                    @endif
                </p>
                <p class="text-sm text-gray-600"><strong>Express:</strong> {{ $method->is_express ? 'Sim' : 'Não' }}</p>
                <p class="text-sm text-gray-600"><strong>Ordem:</strong> {{ $method->order ?? '-' }}</p>
                @if($method->driver === 'mollie')
                    <ul class="list-disc list-inside text-xs text-gray-600">
                        <li><strong>API Key:</strong> {{ \Illuminate\Support\Str::limit($method->config['api_key'] ?? '-', 30) }}</li>
                        <li><strong>Profile ID:</strong> {{ \Illuminate\Support\Str::limit($method->config['profile_id'] ?? '-', 30) }}</li>
                    </ul>
                @else
                    <ul class="list-disc list-inside text-xs text-gray-600">
                        @foreach ($method->config as $key => $value)
                            <li>
                                <strong>{{ ucfirst($key) }}:</strong>
                                {{ in_array($key, ['secret', 'api_key']) ? '••••••••' : \Illuminate\Support\Str::limit($value, 30) }}
                            </li>
                        @endforeach
                    </ul>
                @endif


                <div class="flex items-center justify-between mt-4">
                    <div x-data="{ active: {{ $method->is_active ? 'true' : 'false' }} }"
                        @click="
                            fetch('{{ route('admin.payment_methods.toggleActive', $method->id) }}', {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).then(res => res.json()).then(data => active = data.is_active)
                        "
                        class="relative inline-block w-14 h-7 cursor-pointer"
                        :title="active ? 'Ativo' : 'Inativo'"
                    >
                        <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>
                        <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.payment_methods.edit', $method->id) }}" 
                            class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                            Atualizar
                        </a>
                        <form action="{{ route('admin.payment_methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Deseja excluir este método?')">
                            @csrf @method('DELETE')
                            <button class="text-sm px-3 py-1.5 bg-red-600 text-white rounded-lg">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Nenhum método registrado.</p>
        @endforelse
    </div>

</div>
@endsection

