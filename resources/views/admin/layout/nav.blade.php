<nav class="flex items-center justify-between px-6 py-4 border-b bg-white shadow-sm">
    <div>
        <p class="text-lg font-semibold text-gray-800">Hola</p>
        <p class="text-sm text-gray-500">Administrador</p>
    </div>

    <div class="flex items-center space-x-4">
   
        <!-- Perfil -->
        <span class="text-sm text-gray-700 hidden sm:inline">{{ Auth::user()->name }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A9.004 9.004 0 0112 15c2.21 0 4.209.804 5.879 2.137M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
</nav>
{{-- Botón flotante para abrir el panel de tareas --}}
<button 
    @click="showTasks = true" 
    class="fixed bottom-8 right-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full shadow-lg flex items-center space-x-2 z-50">
    
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a2 2 0 100-4 2 2 0 000 4zm-10 0a2 2 0 100-4 2 2 0 000 4zm5 4v2m-4-2v2m8-2v2" />
    </svg>
    
    <span>Tareas!</span>
</button>