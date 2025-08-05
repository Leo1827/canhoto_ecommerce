<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Sidebar de navegación -->
                <div class="col-span-1">
                    <nav class="space-y-2">
                        <button onclick="mostrarSeccion('perfil')" id="btn-perfil"
                            class="w-full text-left px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            Informações do perfil
                        </button>
                        <button onclick="mostrarSeccion('direcciones')" id="btn-direcciones"
                            class="w-full text-left px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            Endereço
                        </button>
                        <button onclick="mostrarSeccion('password')" id="btn-password"
                            class="w-full text-left px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            Alterar a senha
                        </button>
                        <button onclick="mostrarSeccion('eliminar')" id="btn-eliminar"
                            class="w-full text-left px-4 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition">
                            Excluir conta
                        </button>
                    </nav>
                </div>

                <!-- Secciones de contenido -->
                <div class="col-span-1 md:col-span-3 space-y-6">
                    <div id="seccion-perfil">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div id="seccion-direcciones" class="hidden">
                        @include('profile.partials.user-addresses')
                    </div>
                    <div id="seccion-password" class="hidden">
                        @include('profile.partials.update-password-form')
                    </div>
                    <div id="seccion-eliminar" class="hidden">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function mostrarSeccion(seccion) {
            const secciones = ['perfil', 'direcciones', 'password', 'eliminar'];
            secciones.forEach(id => {
                document.getElementById('seccion-' + id).classList.add('hidden');
                document.getElementById('btn-' + id).classList.remove('bg-gray-100', 'font-semibold');
            });

            document.getElementById('seccion-' + seccion).classList.remove('hidden');
            document.getElementById('btn-' + seccion).classList.add('bg-gray-100', 'font-semibold');
        }

        // Mostrar por defecto
        document.addEventListener('DOMContentLoaded', () => {
            mostrarSeccion('perfil');
        });
    </script>
</x-app-layout>
