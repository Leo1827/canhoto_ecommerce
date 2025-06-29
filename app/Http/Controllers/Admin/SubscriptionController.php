<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])->latest()->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function edit(Subscription $subscription)
    {
        $plans = Plan::with('currency')->where('is_active', false)->get();
        return view('admin.subscriptions.edit', compact('subscription', 'plans'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'stripe_status' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $subscription->update($request->only(['plan_id', 'stripe_status', 'quantity']));

        return redirect()->route('admin.subscriptions.index')->with('success', 'Suscripción actualizada.');
    }

}
