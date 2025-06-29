{{-- Tabla simplificada para móviles --}}
<div class="md:hidden space-y-6">
    @foreach ($plans as $plan)
        <div x-data="{ open: true, isActive: {{ $plan->is_active ? 'true' : 'false' }} }"
             class="bg-white border border-gray-200 shadow-md rounded-2xl p-5 transition hover:shadow-lg">

            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-gray-800">{{ $plan->name }}</h3>
                <span class="text-xs px-2 py-1 rounded-full font-semibold"
                      :class="isActive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                    <template x-if="isActive">Ativo</template>
                    <template x-if="!isActive">Inativo</template>
                </span>
            </div>

            <div x-show="open" x-transition class="text-sm text-gray-700 space-y-2">
                <p><strong>Preço:</strong> R${{ number_format($plan->price, 2) }}</p>

                {{-- Switch Activación --}}
                <div class="flex items-center justify-between mt-2">
                    <span class="font-medium">Status:</span>
                    <div
                        @click="
                            fetch('{{ route('admin.plans.toggleActive', $plan) }}', {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => isActive = data.is_active)
                        "
                        class="relative inline-block w-14 h-7 cursor-pointer"
                        :title="isActive ? 'Desativar plano' : 'Ativar plano'"
                    >
                        <div class="block w-14 h-7 rounded-full transition-colors duration-300"
                             :class="isActive ? 'bg-green-500' : 'bg-gray-300'"></div>
                        <div class="absolute top-0 left-0 w-7 h-7 bg-white border border-gray-300 rounded-full shadow transform transition-transform duration-300"
                             :class="isActive ? 'translate-x-7' : 'translate-x-0'"></div>
                    </div>
                </div>

                <p><strong>Intervalo:</strong> {{ ucfirst($plan->interval) }}</p>

                {{-- Botones --}}
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('admin.plans.edit', $plan) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition">
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
                </div>
            </div>
        </div>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>