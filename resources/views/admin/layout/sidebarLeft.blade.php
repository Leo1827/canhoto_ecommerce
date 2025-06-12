<!-- Panel derecho de tareas -->
<aside
    class="w-80 bg-gray-100 border-l border-gray-300 p-4 overflow-y-auto
           fixed right-0 top-0 h-full z-40 shadow-lg transform transition-transform duration-300 ease-in-out"
    :class="showTasks ? 'translate-x-0' : 'translate-x-full'"
    x-show="showTasks"
    @click.away="showTasks = false"
    x-transition
>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Tareas</h2>
        <!-- Botón para cerrar -->
        <button class="text-gray-600 hover:text-black" @click="showTasks = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <ul class="space-y-3">
        <li class="bg-white p-3 rounded shadow text-sm">
            <strong>✔ Revisar pruebas activas</strong>
            <p class="text-gray-500">Verificar pruebas con fecha cercana.</p>
        </li>
        <li class="bg-white p-3 rounded shadow text-sm">
            <strong>📝 Crear nueva prueba</strong>
            <p class="text-gray-500">Agregar nueva evaluación para el curso 2025.</p>
        </li>
        <li class="bg-white p-3 rounded shadow text-sm">
            <strong>📊 Ver estadísticas</strong>
            <p class="text-gray-500">Revisar resultados por usuario.</p>
        </li>
    </ul>
</aside>
