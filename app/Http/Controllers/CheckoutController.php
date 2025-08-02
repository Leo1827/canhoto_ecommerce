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

        $cartItems = CartItem::with(['product', 'inventory'])
            ->where('user_id', $user->id)
            ->get();

        $total = $cartItems->sum('subtotal');

        // Obtener métodos de pago activos directamente desde la base de datos
        $paymentMethods = PaymentMethod::where('is_active', 1)
            ->orderBy('order')
            ->get(); // ahora tienes todos los datos, incluyendo `icon`

        return view('checkout.index', compact('cartItems', 'total', 'paymentMethods'));
    }

    public function waitingRoom(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|integer',
            'payment_method' => 'required|string',
            'accept_terms' => 'accepted',
            'user_comment' => 'nullable|string',
        ]);

        // Obtener la dirección
        $address = UserAddress::find($validated['address_id']);

        // Obtener los items del carrito con sus productos
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        // Calcular el total
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Simulación de comisión para PayPal (21%)
        $tax = 0;
        if ($validated['payment_method'] === 'paypal') {
            $tax = $total * 0.21;
        }

        $finalTotal = $total + $tax;

        // 🔐 Guardar los datos en sesión para usarlos después del pago
        session([
            'checkout_data' => [
                'address_id' => $validated['address_id'],
                'payment_method' => $validated['payment_method'],
                'user_comment' => $validated['user_comment'],
                'currency_id' => 1, // ajusta si usas otro sistema
                'totals' => [
                    'subtotal' => $total,
                    'shipping' => 0, // si usas costo de envío, reemplázalo aquí
                    'tax' => $tax,
                    'total' => $finalTotal,
                ],
            ]
        ]);

        return view('checkout.waiting-room', [
            'paymentMethod' => $validated['payment_method'],
            'address' => $address,
            'userComment' => $validated['user_comment'],
            'cartItems' => $cartItems,
            'total' => $total,
            'tax' => $tax,
            'finalTotal' => $finalTotal,
        ]);
    }





}
