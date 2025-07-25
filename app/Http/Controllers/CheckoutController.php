<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\PaymentMethod;


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



}
