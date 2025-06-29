<div class="pt-6 border-t mt-6">
    <template x-if="planSelected">
        <div class="space-y-1 text-lg font-semibold">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span x-text="planSelected.symbol + ' ' + Number(planSelected.price).toFixed(2)"></span>
            </div>
            
            <div class="flex justify-between border-t pt-2">
                <span>Total</span>
                <span class="text-red-600 font-bold text-lg" 
                    x-text="planSelected.symbol + ' ' + planSelected.price">
                </span>
            </div>
        </div>
    </template>

    <div x-show="!plan" class="text-red-600 mt-2">Selecione um plano</div>
</div>
