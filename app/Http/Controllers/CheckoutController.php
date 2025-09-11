<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\PaymentMethod;
use App\Models\UserAddress;
use App\Models\OrderItem;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // traemos los items de la orden activa del usuario
        $cartItems = CartItem::with(['product.tax', 'inventory'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                // si ya lo calculaste al guardar en order_items, solo lo lees:
                $item->tax_rate = $item->product->tax->rate ?? 0;
                $item->tax_amount = ($item->subtotal * $item->tax_rate) / 100;
                $item->total_with_tax = $item->subtotal + $item->tax_amount;
                return $item;
            });

        $subtotal = $cartItems->sum('subtotal');
        $iva = $cartItems->sum('tax_amount');
        $total = $subtotal + $iva;

        $paymentMethods = PaymentMethod::where('is_active', 1)
            ->orderBy('order')
            ->get();

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'iva',
            'total',
            'paymentMethods'
        ));
    }

    public function waitingRoom(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|integer',
            'payment_method' => 'required|string',
            'accept_terms' => 'accepted',
            'user_comment' => 'nullable|string',
        ]);

        $address = UserAddress::find($validated['address_id']);

        // Obtener carrito con producto + tax
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product.tax')
            ->get()
            ->map(function ($item) {
                $rate = $item->product->tax->rate ?? 0;
                $subtotal = $item->quantity * $item->product->price;
                $taxAmount = ($subtotal * $rate) / 100;

                $item->tax_rate = $rate;
                $item->subtotal = $subtotal;
                $item->tax_amount = $taxAmount;
                $item->total_with_tax = $subtotal + $taxAmount;

                return $item;
            });

        // Totales globales
        $subtotal = $cartItems->sum('subtotal');
        $iva = $cartItems->sum('tax_amount');
        $total = $subtotal + $iva;

        // Comisión extra de PayPal
        $paymentTax = 0;
        if ($validated['payment_method'] === 'paypal') {
            $paymentTax = $total * 0.21;
        }

        $finalTotal = $total + $paymentTax;

        // Guardar en sesión
        session([
            'checkout_data' => [
                'address_id' => $validated['address_id'],
                'payment_method' => $validated['payment_method'],
                'user_comment' => $validated['user_comment'],
                'currency_id' => 1,
                'totals' => [
                    'subtotal' => $subtotal,
                    'iva' => $iva,
                    'payment_tax' => $paymentTax,
                    'total' => $finalTotal,
                ],
            ]
        ]);

        return view('checkout.waiting-room', [
            'paymentMethod' => $validated['payment_method'],
            'address' => $address,
            'userComment' => $validated['user_comment'],
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'paymentTax' => $paymentTax,
            'finalTotal' => $finalTotal,
        ]);
    }


}
