<h3 class="text-3xl font-bold text-center mb-6 text-gray-800">Resumo da sua assinatura</h3>

<div class="grid md:grid-cols-1 gap-6">
    @foreach ($planes as $plan)
        <label 
            class="cursor-pointer border rounded-2xl p-6 flex flex-col justify-between hover:shadow-lg transition-all bg-white"
            :class="plan == '{{ $plan->id }}' ? 'border-red-600 shadow-xl' : 'border-gray-200'"
        >
            <input 
                type="radio" 
                name="plan_id" 
                value="{{ $plan->id }}" 
                class="hidden"
                x-model="plan"
            >

            <div class="flex justify-between items-center mb-3">
                <h4 class="font-bold text-xl text-gray-800">{{ $plan->name }}</h4>
                <div class="text-right">
                    <div 
                        class="text-2xl font-extrabold text-red-600"
                        data-precio="{{ number_format($plan->price, 2) }}" 
                        data-raw="{{ $plan->price }}"
                    >
                        {{ $plan->currency->symbol }}{{ number_format($plan->price, 2) }}
                    </div>
                    <p class="text-sm text-gray-500">/ {{ $plan->interval == 'month' ? 'mensal' : 'anual' }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 mt-3 pt-3">
                <ul class="space-y-2">
                    @foreach (explode(',', $plan->features) as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 00-1.415 1.414l5 5a1 1 0 001.415 0l9-9a1 1 0 00-1.415-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ trim($feature) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </label>
    @endforeach
</div>
