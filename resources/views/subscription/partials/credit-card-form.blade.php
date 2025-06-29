<label class="block border rounded-xl cursor-pointer transition-all"
    :class="{ 'border-red-500 shadow-md': metodo === 'cartao' }">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
            <input type="radio" name="payment_method" value="cartao" x-model="metodo"
                class="accent-red-600" :disabled="plan === ''">
            <span class="font-medium text-gray-700">Cartão de crédito</span>
        </div>
        <div class="flex gap-2">
            <img src="https://imgs.search.brave.com/W83jgqCxQebsL_OfLvVb_RsxCOOUQWuOoK9z-wSjqus/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c3ZncmVwby5jb20v/c2hvdy8yMTUxMTQv/dmlzYS5zdmc" class="h-5" alt="Visa">
            <img src="https://imgs.search.brave.com/sWcoq5_EQo6UfD1mviaK40ibHQPCpUmN4LFO-Nium2k/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMtMDAuaWNvbmR1/Y2suY29tL2Fzc2V0/cy4wMC9tYXN0ZXJj/YXJkLWljb24tMTAy/NHg3OTMteGluemUz/OW4ucG5n" class="h-5" alt="MasterCard">
        </div>
    </div>

    <div x-show="metodo === 'cartao'" x-transition class="p-4 pt-0 space-y-3">
        <input type="text" name="card_number" placeholder="Número do cartão"
            class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500">

        <div class="grid grid-cols-2 gap-3">
            <input type="text" name="card_expiry" placeholder="MM/AA"
                class="p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500">
            <input type="text" name="card_cvv" placeholder="CVV"
                class="p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500">
        </div>

        <input type="text" name="card_name" placeholder="Nome no cartão"
            class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500">
    </div>
</label>
