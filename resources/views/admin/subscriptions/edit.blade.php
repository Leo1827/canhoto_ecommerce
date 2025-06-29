@extends('admin.layout.home')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Editar Assinatura</h2>

    <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST" class="bg-white p-4 rounded-2xl shadow">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Plano</label>
                <select name="plan_id" class="border p-1 border-gray-300 w-full">
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" @selected($subscription->plan_id == $plan->id)>
                            {{ $plan->name }} - {{ $plan->price }} {{ $plan->currency?->code ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Status Stripe</label>
                <input type="text" name="stripe_status" value="{{ old('stripe_status', $subscription->stripe_status) }}" class="border p-1 border-gray-300 w-full" />
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Quantidade</label>
                <input type="number" name="quantity" value="{{ old('quantity', $subscription->quantity) }}" class="border p-1 border-gray-300 w-full" />
            </div>
        </div>

        <button class="mt-4 btn btn-primary">Atualizar Assinatura</button>
        <a href="{{ route('admin.subscriptions.index') }}" class="mt-4 ml-4 btn btn-outline">Cancelar</a>
    </form>
</div>
@endsection
