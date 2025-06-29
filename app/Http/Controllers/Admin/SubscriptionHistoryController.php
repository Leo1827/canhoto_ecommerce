<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionHistory;
use Illuminate\Http\Request;

class SubscriptionHistoryController extends Controller
{
    //
    public function index()
    {
        $history = SubscriptionHistory::with(['user', 'subscription.plan']) // eager loading
                        ->latest('subscribed_at')
                        ->paginate(15); // puedes ajustar la cantidad

        return view('admin.subscription_history.index', compact('history'));
    }
}
