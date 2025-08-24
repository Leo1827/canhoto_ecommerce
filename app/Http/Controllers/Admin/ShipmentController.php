<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderStatusHistory;

class ShipmentController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::whereHas('orders', function ($query) {
            $query->whereIn('status', ['paid','pending', 'shipped']);
        })
        ->with(['orders' => function ($query) {
            $query->whereIn('status', ['paid','pending', 'shipped'])->latest();
        }])
        ->paginate(15);

        return view('admin.shipments.index', compact('users'));
    }


    public function show(Order $order)
    {
        $order->load('statusHistories');
        return view('admin.shipments.show', compact('order'));
    }

    public function userOrders($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Traemos todos los pedidos con su factura
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->with('invoice')
            ->latest()
            ->get();

        return view('admin.shipments.user_orders', compact('user', 'orders'));
    }

    public function storeStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:shipped,delivered,cancelled',
            'description' => 'nullable|string|max:255',
        ]);

        // Guardar no histórico
        $order->statusHistories()->create([
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => now(),
        ]);

        // Opcional: atualizar status principal do pedido
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Novo status adicionado com sucesso!');
    }

    public function destroy($id)
    {
        $history = OrderStatusHistory::findOrFail($id);
        $history->delete();

        return back()->with('success', 'Histórico excluído com sucesso!');
    }

}
