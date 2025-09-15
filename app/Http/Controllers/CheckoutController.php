<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\PaymentMethod;
use App\Models\UserAddress;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Traemos el carrito
        $cartItems = CartItem::with(['product.tax', 'inventory'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $rate = $item->product->tax->rate ?? 0;
                $item->subtotal = $item->quantity * $item->product->price;
                $item->tax_rate = $rate;
                $item->tax_amount = ($item->subtotal * $rate) / 100;
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

        // Carrito con impuestos
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

        // Totales base
        $subtotal = $cartItems->sum('subtotal');
        $iva = $cartItems->sum('tax_amount');
        $totalBase = $subtotal + $iva; // Producto con IVA incluido

        // Valores por defecto
        $paypalFee = 0.00;
        $finalTotal = $totalBase;

        if ($validated['payment_method'] === 'paypal') {
            // Calcular comisión PayPal
            $paypalFee = $this->calculatePaypalFee($totalBase);

            // Cliente paga producto + IVA + comisión
            $finalTotal = $totalBase + $paypalFee;
        }

        // Guardar en sesión (para que lo lean los controladores de cada pasarela)
        session([
            'checkout_data' => [
                'address_id' => $validated['address_id'],
                'payment_method' => $validated['payment_method'],
                'user_comment' => $validated['user_comment'],
                'currency_id' => 1,
                'totals' => [
                    'subtotal' => $subtotal,
                    'iva' => $iva,
                    'total_base' => $totalBase,
                    'paypal_fee' => $paypalFee,
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
            'finalTotal' => $finalTotal,
            'paypalFee' => $paypalFee,
        ]);
    }

    private function calculatePaypalFee(float $amount): float
    {
        // Tarifa estándar PayPal (Europa): 3.49% + 0.35 €
        return round(($amount * 0.0349) + 0.35, 2);
    }
}
