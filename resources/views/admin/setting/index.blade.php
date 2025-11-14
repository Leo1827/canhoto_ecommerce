@extends('admin.layout.home')

@section('content')
<div class="p-4">

    <h2 class="text-2xl font-bold mb-6">Configurações do Sistema</h2>

    @if(session('success'))
        <div class="p-3 bg-green-200 text-green-700 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3 bg-red-200 text-red-700 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ******************************** --}}
        {{-- SECCION 1: INFORMACION GENERAL --}}
        {{-- ******************************** --}}
        <div class="bg-white shadow p-4 rounded mb-6">
            <h3 class="text-xl font-semibold mb-4">Informações Gerais</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="font-semibold">Nome do Site</label>
                    <input type="text" name="site_name"
                        value="{{ $setting->site_name }}"
                        class="w-full border p-2 rounded mt-1">
                </div>

                <div>
                    <label class="font-semibold">Modo Escuro</label>
                    <div class="flex items-center space-x-2 mt-1">
                        <input type="checkbox" name="modo_oscuro" value="1"
                            {{ $setting->modo_oscuro ? 'checked' : '' }}>
                        <span>Ativar</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ******************************** --}}
        {{-- SECCION 2: LOGO E FAVICON --}}
        {{-- ******************************** --}}
        <div class="bg-white shadow p-4 rounded mb-6">
            <h3 class="text-xl font-semibold mb-4">Identidade Visual</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Logo --}}
                <div>
                    <label class="font-semibold">Logo</label>
                    <input type="file" name="logo" class="w-full border p-2 rounded mt-1">

                    @if($setting->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $setting->logo) }}"
                                class="w-32 h-32 object-contain border p-2 rounded">
                        </div>
                    @endif
                </div>

                {{-- Favicon --}}
                <div>
                    <label class="font-semibold">Favicon</label>
                    <input type="file" name="favicon" class="w-full border p-2 rounded mt-1">

                    @if($setting->favicon)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $setting->favicon) }}"
                                class="w-14 h-14 object-contain border p-2 rounded">
                        </div>
                    @endif
                </div>


            </div>
        </div>

        {{-- ******************************** --}}
        {{-- SECCION 3: CONTATO --}}
        {{-- ******************************** --}}
        <div class="bg-white shadow p-4 rounded mb-6">
            <h3 class="text-xl font-semibold mb-4">Contato</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold">Email</label>
                    <input type="text" name="email_contacto"
                        value="{{ $setting->email_contacto }}"
                        class="w-full border p-2 rounded mt-1">
                </div>

                <div>
                    <label class="font-semibold">Telefone</label>
                    <input type="text" name="telefono_contacto"
                        value="{{ $setting->telefono_contacto }}"
                        class="w-full border p-2 rounded mt-1">
                </div>
            </div>
        </div>

        {{-- BOTÃO SALVAR --}}
        <div class="text-right">
            <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Salvar Alterações
            </button>
        </div>

    </form>
</div>
@endsection
