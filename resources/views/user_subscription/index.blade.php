<x-app-layout>
    <div class="container mx-auto px-4 md:px-32 py-8">
        <h2 class="text-2xl font-bold mb-6">Minhas Assinaturas</h2>

        @if ($subscriptions->isEmpty())
            <p class="text-gray-600">Você ainda não possui assinaturas.</p>
        @else
            <!-- Filtros: Mês + Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 mt-10">
                <!-- Filtro por mes -->
                <div>
                    <label for="filter-month" class="block text-sm font-medium text-gray-700 mb-1">Mês de Início</label>
                    <select id="filter-month" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#7C1D1D]">
                        <option value="">Todos</option>
                        @foreach($subscriptions->pluck('created_at')->unique()->sort() as $date)
                            <option value="{{ \Carbon\Carbon::parse($date)->format('Y-m') }}">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="filter-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="filter-status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#7C1D1D]">
                        <option value="">Todos</option>
                        <option value="active">Ativas</option>
                        <option value="expired">Expiradas</option>
                    </select>
                </div>
            </div>

            <!-- Lista de tarjetas responsiva -->
            <div id="subscription-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($subscriptions as $subscription)
                    @php
                        $startDate = \Carbon\Carbon::parse($subscription->created_at);
                        $endDate = $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at) : null;
                        $status = strtolower($subscription->stripe_status);
                        $isActive = in_array($status, ['active', 'completed']) && (!$endDate || $endDate->isFuture());

                        $bgClass = $isActive 
                            ? 'bg-[#FBEAEA] border-[#7C1D1D] ring-2 ring-[#7C1D1D] text-[#3D0D0D]'
                            : 'bg-[#F3F4F6] border-[#D1D5DB] text-[#6B7280] opacity-60';
                    @endphp

                    <div class="subscription-card {{ $bgClass }} w-full rounded-xl p-4 shadow-md border relative transition-all duration-300"
                        data-start="{{ $startDate }}"
                        data-end="{{ $endDate }}"
                        data-id="sub-{{ $loop->index }}">
                        <h3 class="text-base font-semibold mb-1">{{ $subscription->plan->name }}</h3>
                        <p class="text-sm"><strong>{{ $subscription->plan->price }} {{ $subscription->plan->currency->code }}</strong></p>
                        <p class="text-sm">Início: <strong>{{ $startDate->format('d/m/Y') }}</strong></p>
                        <p class="text-sm mb-2">Expira em: 
                            <strong>{{ $endDate ? $endDate->format('d/m/Y') : 'Indeterminado' }}</strong>
                        </p>
                        <p class="text-sm">Status: <strong class="capitalize">{{ $subscription->stripe_status }}</strong></p>

                        @if($endDate)
                            <div id="timer-sub-{{ $loop->index }}" class="text-xs font-bold px-3 py-1 mt-3 rounded w-fit transition-colors bg-[#FBEAEA] text-[#7C1D1D]">
                                Calculando...
                            </div>
                        @else
                            <div class="text-xs font-semibold text-[#7C1D1D] mt-3">Ativa sem data final</div>
                        @endif
                    </div>
                @endforeach

                @if ($subscriptions->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex items-center space-x-2">
                            {{-- Botón anterior --}}
                            @if ($subscriptions->onFirstPage())
                                <span class="px-3 py-1 rounded-md bg-gray-200 text-gray-500 cursor-not-allowed">Anterior</span>
                            @else
                                <a href="{{ $subscriptions->previousPageUrl() }}" class="px-3 py-1 rounded-md bg-white text-gray-700 border border-gray-300 hover:bg-gray-100 transition">Anterior</a>
                            @endif

                            {{-- Números de página --}}
                            @foreach ($subscriptions->getUrlRange(1, $subscriptions->lastPage()) as $page => $url)
                                @if ($page == $subscriptions->currentPage())
                                    <span class="px-3 py-1 rounded-md bg-blue-600 text-white font-semibold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1 rounded-md bg-white text-gray-700 border border-gray-300 hover:bg-gray-100 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Botón siguiente --}}
                            @if ($subscriptions->hasMorePages())
                                <a href="{{ $subscriptions->nextPageUrl() }}" class="px-3 py-1 rounded-md bg-white text-gray-700 border border-gray-300 hover:bg-gray-100 transition">Siguiente</a>
                            @else
                                <span class="px-3 py-1 rounded-md bg-gray-200 text-gray-500 cursor-not-allowed">Siguiente</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>

        @endif
    </div>

    <!-- Cronómetro con JS -->
    <script>
        function updateCountdowns() {
            document.querySelectorAll('.subscription-card').forEach(card => {
                const end = card.dataset.end;
                const id = card.dataset.id;
                const container = document.getElementById('timer-' + id);

                if (!end || !container) return;

                const endDate = new Date(end);
                const now = new Date();
                const diff = endDate - now;

                if (diff <= 0) {
                    container.innerText = "Expirada";
                    container.classList.remove('bg-[#FBEAEA]', 'text-[#7C1D1D]');
                    container.classList.add('bg-[#D1D5DB]', 'text-[#6B7280]');
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((diff / (1000 * 60)) % 60);
                const seconds = Math.floor((diff / 1000) % 60);

                container.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s restantes`;

                if (days <= 3) {
                    container.classList.remove('bg-[#FBEAEA]', 'text-[#7C1D1D]');
                    container.classList.add('bg-[#D1D5DB]', 'text-[#6B7280]');
                } else {
                    container.classList.remove('bg-[#D1D5DB]', 'text-[#6B7280]');
                    container.classList.add('bg-[#FBEAEA]', 'text-[#7C1D1D]');
                }
            });
        }

        setInterval(updateCountdowns, 1000);
        updateCountdowns();

        function applyFilters() {
            const selectedMonth = document.getElementById('filter-month').value;
            const selectedStatus = document.getElementById('filter-status').value;

            document.querySelectorAll('.subscription-card').forEach(card => {
                const start = new Date(card.dataset.start);
                const cardMonth = start.toISOString().slice(0, 7);
                const status = card.dataset.end ? new Date(card.dataset.end) > new Date() ? 'active' : 'expired' : 'active';

                const show =
                    (!selectedMonth || cardMonth === selectedMonth) &&
                    (!selectedStatus || status === selectedStatus);

                card.style.display = show ? 'block' : 'none';
            });
        }

        // Activar filtros al cambiar
        ['filter-month', 'filter-status'].forEach(id => {
            document.getElementById(id).addEventListener('change', applyFilters);
        });

        applyFilters(); // Aplicar al cargar


        // Filtro por mes
        document.getElementById('filter-month').addEventListener('change', function () {
            const selectedMonth = this.value;
            document.querySelectorAll('.subscription-card').forEach(card => {
                const start = new Date(card.dataset.start);
                const cardMonth = start.toISOString().slice(0, 7);
                card.style.display = (!selectedMonth || cardMonth === selectedMonth) ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
