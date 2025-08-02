<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserOrderController extends Controller
{
    use AuthorizesRequests;
    //
    public function index()
    {
        $orders = Order::with(['invoice', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // Asegúrate de tener una policy

        // Asegúrate de cargar las relaciones necesarias
        $order->load(['items.product', 'invoice', 'statusHistories', 'address']);

        return view('orders.show', compact('order'));
    }
}
