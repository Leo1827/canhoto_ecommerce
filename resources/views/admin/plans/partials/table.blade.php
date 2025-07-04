{{-- Tabla principal para pantallas grandes --}}
<table class="w-full min-w-[600px] table-auto text-sm text-left text-gray-700 hidden md:table">
    <thead class="bg-gray-100 text-xs uppercase">
        <tr>
            <th class="px-4 py-2">Nome</th>
            <th class="px-4 py-2">Preço</th>
            <th class="px-4 py-2">Intervalo</th>
            <th class="py-2">Ativo</th>
            <th class="px-4 py-2">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plans as $plan)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $plan->name }}</td>
                <td class="px-4 py-2">{{ number_format($plan->price, 2) }}</td>
                <td class="px-4 py-2">{{ ucfirst($plan->interval) }}</td>

                {{-- Switch de activación/desactivación --}}
                <td class=" py-2 text-center">
                    <div 
                        x-data="{ active: {{ $plan->is_active ? 'false' : 'true' }} }"
                        @click="
                            fetch('{{ route('admin.plans.toggleActive', $plan) }}', {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => active = !data.is_active)
                        "
                        class="relative inline-block w-14 h-7 align-middle select-none transition duration-200 ease-in cursor-pointer"
                        :title="active ? 'Activo' : 'Inactivo'"
                    >
                        {{-- Fondo --}}
                        <div class="block w-14 h-7 rounded-full transition" :class="active ? 'bg-green-400' : 'bg-red-400'"></div>

                        {{-- Botón deslizable --}}
                        <div class="absolute left-0 top-0 w-7 h-7 bg-white border rounded-full shadow transform transition" :class="active ? 'translate-x-7' : 'translate-x-0'"></div>
                    </div>
                </td>

                {{-- Acciones --}}
                <td class="px-4 py-2 flex flex-wrap gap-2">
                    <a href="{{ route('admin.plans.edit', $plan) }}"
                    class="inline-flex items-center px-3 py-1.5 bg-green-400 text-white rounded-2xl text-sm font-medium hover:bg-blue-700 transition duration-150">
                        Atualizar
                    </a>

                   <form x-data x-ref="deleteForm" @submit.prevent="Swal.fire({
                        title: 'Você tem certeza?',
                        text: 'Esta ação não poderá ser desfeita.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $refs.deleteForm.submit();
                        }
                    })"
                    action="{{ route('admin.plans.destroy', $plan) }}"
                    method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-2xl hover:bg-red-700 transition duration-150">
                            Excluir
                        </button>
                    </form>


                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
