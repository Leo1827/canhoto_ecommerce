<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Invoice;

class SubscriptionStoreController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $subscriptions = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $invoices = Invoice::where('user_id', $user->id)
            ->orderByDesc('issue_date')
            ->get();

        return view('user_subscription.index', compact('subscriptions', 'invoices'));
    }
}
