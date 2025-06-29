<div class="bg-white shadow-lg rounded-2xl p-6 mb-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-3" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Inicio</a>
            </li>
            <li><span class="mx-1">/</span></li>
            <li class="text-gray-700 font-semibold">Agregar nuevo plan</li>
        </ol>
    </nav>

    <form action="{{ route('admin.plans.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Nome --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Preço --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Preço</label>
                <input type="number" step="0.01" name="price" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Intervalo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Intervalo</label>
                <select name="interval" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="monthly">Mensal</option>
                    <option value="yearly">Anual</option>
                    <option value="weekly">Semanal</option>
                </select>
            </div>

            {{-- Stripe ID --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Stripe</label>
                <input type="text" name="stripe_id" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Características --}}
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Características</label>
                <textarea name="features" rows="3" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            {{-- Ordem --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordem</label>
                <input type="number" name="order" min="0" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Moneda --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Moneda</label>
                <select name="currency_id" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->symbol }} ({{ $currency->name }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Ativo --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="0" class="h-5 w-5 text-blue-600 border-gray-300 rounded">
                <span class="ml-2 text-gray-700">Ativo</span>
            </label>
        </div>

        {{-- Botón --}}
        <div class="mt-6 right-0">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Salvar
            </button>
        </div>
    </form>
</div>
