<x-app-layout>
    <div class="container mx-auto px-4 md:px-32 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📦 Historial de Órdenes</h1>

        {{-- Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <!-- Filtro por número de factura -->
            <div>
                <form method="GET" action="{{ route('user.orders.index') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Filtro por número de factura -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Factura</label>
                            <input type="text" name="invoice" value="{{ request('invoice') }}" placeholder="Buscar factura..."
                                class="w-[200px] border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4B0D0D]">
                        </div>
                        
                        <!-- (Opcionalmente puedes dejar los otros filtros si deseas) -->
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-[#4B0D0D] text-white rounded">
                            🔍 Buscar
                        </button>
                    </div>
                </form>

            </div>

            <!-- Fecha desde -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" id="filter-from"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4B0D0D]">
            </div>

            <!-- Fecha hasta -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" id="filter-to"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4B0D0D]">
            </div>
        </div>

        @if($orders->isEmpty())
            <p class="text-gray-500">No tienes órdenes aún.</p>
        @else
            <!-- Cards de órdenes -->
            <div id="orders-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($orders as $order)
                    @php
                        $statusColor = match($order->status) {
                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                            'completado' => 'bg-green-100 text-green-800',
                            'cancelado' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp

                    <a href="{{ route('user.orders.show', $order->id) }}"
                       class="order-card block border border-gray-200 rounded-xl shadow hover:shadow-lg transition bg-white p-6"
                       data-invoice="{{ strtolower($order->invoice->invoice_number ?? '') }}"
                       data-date="{{ $order->created_at->format('Y-m-d') }}">
                        <div class="mb-3">
                            <h2 class="text-lg font-semibold text-[#4B0D0D]">
                                📄 Factura: {{ $order->invoice->invoice_number ?? 'Sin factura' }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Fecha: {{ $order->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div class="text-sm flex flex-col gap-1">
                            <span class="font-medium">💵 Total: €{{ number_format($order->total, 2) }}</span>
                            <span class="font-medium">📦 Estado:
                                <span class="px-2 py-1 rounded-full text-xs {{ $statusColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </span>
                        </div>

                        <div class="mt-4 text-right">
                            <span class="inline-block px-4 py-1 bg-[#4B0D0D] text-white text-xs rounded-full">Ver Detalles</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Paginación estándar -->
            @if (!$orders instanceof \Illuminate\Support\Collection)
                <div class="mt-8 flex justify-center space-x-2">
                    {{-- Paginación igual que tienes ahora --}}
                    @if ($orders->onFirstPage())
                        <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded">‹</span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1 bg-[#4B0D0D] text-white rounded">‹</a>
                    @endif

                    @for ($i = 1; $i <= $orders->lastPage(); $i++)
                        <a href="{{ $orders->url($i) }}"
                        class="px-3 py-1 rounded {{ $orders->currentPage() === $i ? 'bg-[#4B0D0D] text-white' : 'bg-gray-100 text-gray-700' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1 bg-[#4B0D0D] text-white rounded">›</a>
                    @else
                        <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded">›</span>
                    @endif
                </div>
            @endif

        @endif
    </div>

    <!-- Script de filtrado por factura y fecha -->
    <script>
        function filterOrders() {
            const invoiceInput = document.getElementById('filter-invoice').value.toLowerCase();
            const from = document.getElementById('filter-from').value;
            const to = document.getElementById('filter-to').value;

            document.querySelectorAll('.order-card').forEach(card => {
                const invoice = card.dataset.invoice || '';
                const date = card.dataset.date;

                const matchInvoice = !invoiceInput || invoice.includes(invoiceInput);
                const matchFrom = !from || date >= from;
                const matchTo = !to || date <= to;

                card.style.display = (matchInvoice && matchFrom && matchTo) ? 'block' : 'none';
            });
        }

        ['filter-invoice', 'filter-from', 'filter-to'].forEach(id => {
            document.getElementById(id).addEventListener('input', filterOrders);
        });

        // Aplicar al cargar
        filterOrders();
    </script>
</x-app-layout>
