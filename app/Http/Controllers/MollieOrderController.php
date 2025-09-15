<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Mollie\Laravel\Facades\Mollie;
use App\Models\PaymentMethod;
use App\Mail\InvoicePaid;
use Illuminate\Support\Str;

class MollieOrderController extends Controller
{
    public function startPayment(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|in:mollie',
            'accept_terms' => 'accepted',
        ]);

        \App\Models\TermAcceptance::create([
            'user_id' => Auth::id(),
            'accepted_at' => now(),
            'ip_address' => $request->ip(),
            'terms_version' => 'v1.0',
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Processo de pagamento iniciado.',
            'description' => 'O usuário foi redirecionado para o Mollie.',
        ]);

        // ⚡ Usamos los datos de sesión calculados en waitingRoom
        $checkoutData = session('checkout_data', []);
        $totals = $checkoutData['totals'] ?? [];

        $subtotal = $totals['subtotal'] ?? 0;
        $iva      = $totals['iva'] ?? 0;
        $total    = $totals['total_base'] ?? ($subtotal + $iva); // Producto + IVA
        $shipping = 0; // si más adelante tienes envío, súmalo aquí

        $method = PaymentMethod::where('code', 'mollie')->first();

        if (is_string($method->config)) {
            $config = json_decode($method->config, true);
        } elseif (is_array($method->config)) {
            $config = $method->config;
        } elseif (is_object($method->config)) {
            $config = (array) $method->config;
        } else {
            $config = [];
        }

        if (empty($config['api_key'])) {
            return redirect()->route('checkout.index')->with('error', 'API Key Mollie no encontrada.');
        }

        Mollie::api()->setApiKey($config['api_key']);

        $currency = \App\Models\Currency::where('code', 'EUR')->first();

        $payment = Mollie::api()->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($total + $shipping, 2, '.', ''),
            ],
            'description' => 'Compre pelo site',
            'redirectUrl' => route('mollie.store.success'),
            'cancelUrl' => route('mollie.store.cancel'),
            'metadata' => [
                'user_id' => Auth::id(),
            ]
        ]);

        session(['mollie_payment_id' => $payment->id]);

        Cache::put('mollie_checkout_' . $payment->id, [
            'address_id' => $request->address_id,
            'user_comment' => $request->user_comment,
            'totals' => [
                'subtotal' => $subtotal,
                'iva' => $iva,
                'shipping' => $shipping,
                'total' => $total + $shipping,
            ],
            'payment_id' => $payment->id,
            'currency_id' => optional($currency)->id ?? 1,
        ], now()->addMinutes(30));

        return redirect($payment->getCheckoutUrl());
    }

    public function success(Request $request)
    {
        // ✅ Recuperar el ID del pago desde la sesión
        $paymentId = session('mollie_payment_id');

        $checkoutData = Cache::get('mollie_checkout_' . $paymentId);

        if (!$checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Datos de checkout no disponibles.');
        }

        $method = PaymentMethod::where('code', 'mollie')->first();
        if (is_string($method->config)) {
            $config = json_decode($method->config, true);
        } elseif (is_array($method->config)) {
            $config = $method->config;
        } elseif (is_object($method->config)) {
            $config = (array) $method->config;
        } else {
            $config = [];
        }

        Mollie::api()->setApiKey($config['api_key']);

        $payment = Mollie::api()->payments->get($paymentId);

        // 👇 aquí defines la variable
        $paymentMethodUsed = $payment->method ?? 'mollie';

        if ($payment->isPaid()) {
            DB::beginTransaction();
            try {
                // Volver a traer los items del carrito del usuario
                $cartItems = Auth::user()->cartItems;

                //Calcular el IVA total
                $ivaTotal = $cartItems->sum(function ($item) {
                    $taxRate = $item->product->tax->rate ?? 0;
                    return $item->subtotal * ($taxRate / 100);
                });

                $order = \App\Models\Order::create([
                    'user_id' => Auth::id(),
                    'user_address_id' => $checkoutData['address_id'],
                    'subtotal' => $checkoutData['totals']['subtotal'],
                    'shipping_cost' => $checkoutData['totals']['shipping'],
                    'tax' => $ivaTotal,   // 👈 total IVA de los items
                    'total' => $checkoutData['totals']['total'],
                    'status' => 'paid',
                    'payment_status' => 'paid',
                    'payment_method' => 'Mollie - ' . ucfirst($paymentMethodUsed),
                    'paid_at' => now(),
                    'user_comment' => $checkoutData['user_comment'] ?? null,
                    'currency_id' => $checkoutData['currency_id'],
                ]);

                // ✅ Descontar stock antes de crear los ítems
                foreach (Auth::user()->cartItems as $item) {
                    $inventory = \App\Models\ProductInventory::find($item->inventory_id);

                    if (!$inventory) {
                        throw new \Exception('Inventario no encontrado para el producto: ' . $item->product->name);
                    }

                    if ($inventory->quantity < $item->quantity) {
                        throw new \Exception('No hay suficiente stock para el producto: ' . $item->product->name);
                    }

                    // Descontar stock
                    $inventory->quantity -= $item->quantity;
                    $inventory->save();

                    // obtener el impuesto desde la relación con el producto
                    $tax = $item->product->tax ?? null;

                    $order->items()->create([
                        'user_id' => Auth::id(),
                        'product_id' => $item->product_id,
                        'inventory_id' => $item->inventory_id,
                        'label_item' => $item->variant_label ?? null,
                        'quantity' => $item->quantity,
                        'price_unit' => $item->product->price,
                        'total' => $item->subtotal,
                        'tax_id' => $tax?->id,
                        'tax_rate' => $tax?->rate ?? 0,
                        'tax_amount' => $item->subtotal * (($tax?->rate ?? 0) / 100),
                    ]);

                }

                $invoice = \App\Models\InvoiceStore::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'invoice_number' => strtoupper(Str::random(10)),
                    'client_name' => Auth::user()->name,
                    'client_email' => Auth::user()->email,
                    'billing_address' => optional($order->address)->fullAddress(),
                    'amount' => $order->total,
                    'currency' => 'EUR',
                    'payment_method' => 'Mollie - ' . ucfirst($paymentMethodUsed),
                    'status' => 'paid',
                    'issue_date' => now()->toDateString(),
                    'due_date' => now()->addDays(5)->toDateString(),
                ]);

                $invoice->load('order.items');

                Mail::to(Auth::user()->email)->send(new InvoicePaid($invoice->order, $invoice));

                $order->statusHistories()->create([
                    'status' => 'paid',
                    'description' => 'Pagamento confirmado via Mollie.',
                    'changed_at' => now(),
                ]);

                \App\Models\ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'Pedido pago',
                    'description' => 'O pedido foi pago com sucesso via Mollie.',
                ]);

                // Limpiar carrito
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->cartItems()->delete();

                DB::commit();
                return redirect()->route('mollie.store.thanks')->with('success', 'Pagamento efetuado com sucesso. Obrigado pela sua compra.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao salvar pedido via Mollie', ['exception' => $e]);
                return redirect()->route('checkout.index')->with('error', 'Erro ao salvar dados do pedido.');
            }
        }

        return redirect()->route('checkout.index')->with('error', 'Pagamento Mollie não foi concluído.');
    }

    public function cancel(Request $request)
    {
        if ($request->has('id')) {
            Cache::forget('mollie_checkout_' . $request->id);
        }

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Processo de pagamento cancelado',
            'description' => 'O usuário cancelou o pagamento com o Mollie.',
        ]);

        return redirect()->route('checkout.index')->with('error', 'Você cancelou o pagamento com o Mollie.');
    }

    public function thanks()
    {
        return view('checkout.thanksCheckout');
    }
}

