<section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Gráfico de Ventas Mensuales -->
    <div class="bg-white rounded-2xl p-6 shadow flex flex-col">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📈 Ventas mensuales</h3>
        <div class="flex-1">
            <canvas id="chartVentas" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Gráfico de Top Productos -->
    <div class="bg-white rounded-2xl p-6 shadow flex flex-col">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">🥂 Top productos vendidos</h3>
        <div class="flex-1">
            <canvas id="chartProductos" class="w-full h-64"></canvas>
        </div>
    </div>
</section>
