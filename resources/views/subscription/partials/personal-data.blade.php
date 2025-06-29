<div class="space-y-4">
    <h3 class="text-xl font-semibold">Dados pessoais</h3>

    <div>
        <label class="block text-sm font-medium mb-1">E-mail</label>
        <input 
            type="email" 
            name="email" 
            value="{{ old('email', auth()->user()->email ?? '') }}" 
            class="w-full p-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500"
            required
        >
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Nome completo</label>
            <input 
                type="text" 
                name="nome" 
                value="{{ old('nome', auth()->user()->name ?? '') }}" 
                class="w-full p-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500"
                required
            >
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Telefone</label>
            <input 
                id="phoneInput"
                type="tel" 
                name="telefone" 
                value="{{ old('telefone') }}" 
                class="w-full p-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500"
                required
            >
        </div>


    </div>
</div>
