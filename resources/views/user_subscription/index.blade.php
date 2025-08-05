<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Minhas Assinaturas</h2>

        @if ($subscriptions->isEmpty())
            <p class="text-gray-600">Você ainda não possui assinaturas.</p>
        @else
            <!-- Filtro por mês -->
            <div class="mb-4">
                <label for="filter-month" class="font-semibold mr-2">Filtrar por mês:</label>
                <select id="filter-month" class="border rounded px-2 py-1">
                    <option value="">Todos</option>
                    @foreach($subscriptions->pluck('created_at')->unique()->sort() as $date)
                        <option value="{{ \Carbon\Carbon::parse($date)->format('Y-m') }}">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('F Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tabla de subscripciones -->
            <div class="overflow-x-auto bg-white p-4 shadow rounded">
                <table class="min-w-full display">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th>Início</th>
                            <th>Expira em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $subscription)
                            @php
                                $isActive = in_array(strtolower($subscription->stripe_status), ['active', 'completed']) &&
                                    (!$subscription->ends_at || \Carbon\Carbon::parse($subscription->ends_at)->isFuture());

                            @endphp
                            <tr class="{{ $isActive ? 'bg-green-100' : 'bg-red-100' }} border-b">
                                <td class="py-2 px-4">{{ $subscription->plan->name }}</td>
                                <td class="py-2 px-4">{{ $subscription->plan->price }} {{ $subscription->plan->currency->code }}</td>
                                <td class="py-2 px-4">{{ ucfirst($subscription->stripe_status) }}</td>
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($subscription->created_at)->format('d/m/Y') }}</td>
                                <td class="py-2 px-4">
                                    {{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->format('d/m/Y') : 'Ativo' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Script DataTables + filtro -->
    <script>
        $(document).ready(function() {

            $('#filter-month').on('change', function () {
                let selectedMonth = this.value;
                table.column(3).search(selectedMonth).draw(); // columna de 'Início'
            });
        });
    </script>
</x-app-layout>

