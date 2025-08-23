<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    //
    public function index()
    {
        $orders = Order::whereIn('status', ['pending', 'shipped'])->latest()->paginate(15);
        return view('admin.shipments.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('statusHistories');
        return view('admin.shipments.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.shipments.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,shipped,cancelled',
            'description' => 'nullable|string'
        ]);

        $order->update([
            'status' => $request->status,
            'shipped_at' => $request->status === 'shipped' ? now() : $order->shipped_at,
            'cancelled_at' => $request->status === 'cancelled' ? now() : $order->cancelled_at,
        ]);

        $order->statusHistories()->create([
            'status' => $request->status,
            'description' => $request->description ?? "Cambio de estado desde admin",
            'changed_at' => now(),
        ]);

        return redirect()->route('admin.shipments.index')->with('success', 'Estado de envío actualizado');
    }

    public function destroy(Order $order)
    {
        $order->statusHistories()->delete();
        $order->update(['status' => 'pending', 'shipped_at' => null, 'cancelled_at' => null]);

        return back()->with('success', 'Seguimiento eliminado');
    }
}
