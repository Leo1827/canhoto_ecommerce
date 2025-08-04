<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Currency;
use App\Models\ActivityLog;
use App\Models\InvoiceStore;
use App\Models\TermAcceptance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\InvoicePaid;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class StripeOrderController extends Controller
{
    public function startPayment(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|in:stripe',
            'accept_terms' => 'accepted',
        ]);

        TermAcceptance::create([
            'user_id' => Auth::id(),
            'accepted_at' => now(),
            'ip_address' => $request->ip(),
            'terms_version' => 'v1.0',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Processo de pagamento iniciado.',
            'description' => 'O usuário foi redirecionado para o Stripe.',
        ]);

        $cartItems = Auth::user()->cartItems;
        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $shipping = 0;
        $tax = $subtotal * 0;
        $total = $subtotal + $shipping + $tax;

        $method = PaymentMethod::where('code', 'stripe')->first();

        if (!$method) {
            return redirect()->route('checkout.index')->with('error', 'Método de pagamento não encontrado.');
        }

        // Conversión segura del campo config
        if (is_string($method->config)) {
            $config = json_decode($method->config, true);
        } elseif (is_array($method->config)) {
            $config = $method->config;
        } elseif (is_object($method->config)) {
            $config = (array) $method->config;
        } else {
            $config = [];
        }

        if (empty($config['secret_key']) || empty($config['public_key'])) {
            return redirect()->route('checkout.index')->with('error', 'Configurações Stripe inválidas.');
        }

        Stripe::setApiKey($config['secret_key']);

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $currency = Currency::where('code', 'EUR')->first();

        $checkoutData = [
            'address_id'    => $request->address_id,
            'user_comment'  => $request->user_comment,
            'totals'        => compact('subtotal', 'shipping', 'tax', 'total'),
            'currency_id'   => optional($currency)->id ?? 1,
        ];

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.store.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.store.cancel'),
            'metadata' => [
                'user_id' => Auth::id(),
                'address_id' => $request->address_id,
            ],
        ]);

        Cache::put('stripe_checkout_' . $session->id, $checkoutData, now()->addMinutes(30));

        return redirect($session->url);
    }

    public function stripeSuccess(Request $request)
    {
        $session_id = $request->get('session_id');
        $checkoutData = Cache::get('stripe_checkout_' . $session_id);

        if (!$checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Sessão Stripe não encontrada.');
        }

        DB::beginTransaction();
        try {
            $order = \App\Models\Order::create([
                'user_id' => Auth::id(),
                'user_address_id' => $checkoutData['address_id'],
                'subtotal' => $checkoutData['totals']['subtotal'],
                'shipping_cost' => $checkoutData['totals']['shipping'],
                'tax' => $checkoutData['totals']['tax'],
                'total' => $checkoutData['totals']['total'],
                'status' => 'paid',
                'payment_status' => 'paid',
                'payment_method' => 'Stripe',
                'paid_at' => now(),
                'user_comment' => $checkoutData['user_comment'] ?? null,
                'currency_id' => $checkoutData['currency_id'],
            ]);

            foreach (Auth::user()->cartItems as $item) {
                $order->items()->create([
                    'user_id' => Auth::id(),
                    'product_id' => $item->product_id,
                    'inventory_id' => $item->inventory_id,
                    'label_item' => $item->variant_label,
                    'quantity' => $item->quantity,
                    'price_unit' => $item->product->price,
                    'total' => $item->subtotal,
                ]);
            }

            $invoice = InvoiceStore::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'invoice_number' => strtoupper(Str::random(10)),
                'client_name' => Auth::user()->name,
                'client_email' => Auth::user()->email,
                'billing_address' => optional($order->address)->fullAddress(),
                'amount' => $order->total,
                'currency' => 'EUR',
                'payment_method' => 'Stripe',
                'status' => 'paid',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(5)->toDateString(),
            ]);

            $invoice->load('order.items');

            Mail::to(Auth::user()->email)->send(new InvoicePaid($order, $invoice));

            $order->statusHistories()->create([
                'status' => 'paid',
                'description' => 'Pagamento confirmado via Stripe.',
                'changed_at' => now(),
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Pedido pago',
                'description' => 'O pedido foi pago com sucesso via Stripe.',
            ]);

            // Limpiar carrito
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('stripe.store.thanks')->with('success', 'Pagamento via Stripe confirmado.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro Stripe', ['exception' => $e]);
            return redirect()->route('checkout.index')->with('error', 'Erro ao processar o pedido.');
        }
    }

    public function stripeCancel()
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Pagamento cancelado',
            'description' => 'O usuário cancelou o pagamento com Stripe.',
        ]);

        return redirect()->route('checkout.index')->with('error', 'Pagamento com Stripe cancelado.');
    }

    public function stripeThanks()
    {
        return view('checkout.thanksCheckout');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            Log::info('🟢 Evento webhook Stripe recebido: checkout.session.completed');
        }

        return response()->json(['status' => 'success']);
    }
}
