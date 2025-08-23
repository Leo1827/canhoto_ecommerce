<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Models\Product;

class OrderController extends CustomBaseController
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(1);

        $users = User::all(); 

        $currencies = Currency::orderBy('code')
            ->get(['id','code','name']);  

        $addresses = UserAddress::all(); 

        $products = Product::where('status', true) // solo activos
            ->orderBy('name')
            ->get(['id','name','price']);

        return view('admin.orders.index', compact(
            'orders',
            'users',
            'currencies',
            'addresses',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'user_address_id' => 'required|exists:user_addresses,id',
            'subtotal'        => 'required|numeric',
            'shipping_cost'   => 'nullable|numeric',
            'tax'             => 'nullable|numeric',
            'total'           => 'required|numeric',
            'status'          => 'required|string|in:pending,paid,cancelled',
            'currency_id'     => 'required|exists:currencies,id',
            'payment_method'  => 'nullable|string|max:100',
            'user_comment'    => 'nullable|string',
            'items'           => 'required|array|min:1',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.price_unit'  => 'required|numeric|min:0',
            'items.*.total'       => 'required|numeric|min:0',
        ]);

        // Definir estados en base al status enviado desde el formulario
        $paymentStatus = 'pending';
        $paidAt = null;
        $cancelledAt = null;

        if ($request->status === 'paid') {
            $paymentStatus = 'paid';
            $paidAt = now();
        } elseif ($request->status === 'cancelled') {
            $paymentStatus = 'failed';
            $cancelledAt = now();
        }

        // Crear orden
        $order = Order::create([
            'user_id'         => $request->user_id,
            'user_address_id' => $request->user_address_id,
            'subtotal'        => $request->subtotal,
            'shipping_cost'   => $request->shipping_cost ?? 0,
            'tax'             => $request->tax ?? 0,
            'total'           => $request->total,
            'currency_id'     => $request->currency_id,
            'status'          => $request->status,   // pending / paid / cancelled
            'payment_status'  => $paymentStatus,     // pending / paid / failed
            'payment_method'  => $request->payment_method,
            'user_comment'    => $request->user_comment,
            'paid_at'         => $paidAt,
            'cancelled_at'    => $cancelledAt,
        ]);

        // Guardar items
        foreach ($request->items as $item) {
            $order->items()->create([
                'user_id'     => $request->user_id,
                'product_id'  => $item['product_id'],
                'quantity'    => $item['quantity'],
                'price_unit'  => $item['price_unit'],
                'total'       => $item['total'],
            ]);
        }

        // Crear factura vinculada
        $invoice = \App\Models\InvoiceStore::create([
            'user_id'        => $request->user_id,
            'order_id'       => $order->id,
            'invoice_number' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'client_name'    => $order->user->name,
            'client_email'   => $order->user->email,
            'billing_address' => optional($order->address)->fullAddress(),
            'amount'         => $order->total,
            'currency'       => $order->currency->code,
            'payment_method' => $order->payment_method ?? 'manual',
            'status'         => $order->payment_status, // sincronizado con la orden
            'issue_date'     => now(),
            'due_date'       => now()->addDays(7),
        ]);

        // Historial de estado
        $order->statusHistories()->create([
            'status'      => $request->status,
            'description' => 'Pedido gerado pelo administrador',
        ]);

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Encomenda e fatura criados corretamente');
    }

}
