<!-- Tarjetas de resumen -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Ventas Totales -->
    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Ventas Totales</p>
                <h2 class="text-2xl font-bold text-gray-800">
                    ${{ number_format($ventasTotales, 0, ',', '.') }}
                </h2>
            </div>
            <i data-lucide="dollar-sign" class="text-blue-500 w-8 h-8"></i>
        </div>
    </div>

    <!-- Órdenes -->
    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Órdenes</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $ordenes }}</h2>
            </div>
            <i data-lucide="shopping-cart" class="text-green-500 w-8 h-8"></i>
        </div>
    </div>

    <!-- Usuarios -->
    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Usuarios</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $usuarios }}</h2>
            </div>
            <i data-lucide="users" class="text-yellow-500 w-8 h-8"></i>
        </div>
    </div>

    <!-- Productos -->
    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Productos</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $productos }}</h2>
            </div>
            <i data-lucide="package" class="text-red-500 w-8 h-8"></i>
        </div>
    </div>

</section>
