<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PaymentMethod;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;


class PlanController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->activeSubscription) {
            return redirect()->route('dashboard')->with('info', 'Ya tienes una suscripción activa.');
        }

        $planes = Plan::where('is_active', false)->with('currency')->get(); // <-- importante with('currency')

        $planesData = $planes->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'interval' => $p->interval,
                'symbol' => $p->currency->symbol,
            ];
        });

        $metodos = PaymentMethod::where('is_active', true)->get()->map(function ($metodo) {
            $metodo->config = is_string($metodo->config)
                ? json_decode($metodo->config, true)
                : ($metodo->config ?? []);
            return $metodo;
          
        })->keyBy('code'); // <--- esta línea es CLAVE


        $monedas = Currency::where('is_active', true)->get();

        return view('subscription.checkout', compact('planes', 'planesData', 'metodos', 'monedas'));
    }

    
}
