<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeSession;

class SuscriptionStripeController extends Controller
{
    //
    public function createStripeCheckout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $method = \App\Models\PaymentMethod::where('driver', 'stripe')->first();

        $stripeConfig = $method?->config ?? [];
        if (!isset($stripeConfig['secret_key']) || !isset($stripeConfig['public_key'])) {
            return response()->json(['error' => 'Stripe no está configurado correctamente.'], 422);
        }

        Stripe::setApiKey($stripeConfig['secret_key']);

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($plan->currency->code),
                    'product_data' => ['name' => $plan->name],
                    'unit_amount' => $plan->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $plan->id,
            'cancel_url' => route('stripe.cancel'),
            'metadata' => [
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
            ]
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function stripeSuccess(Request $request)
    {
        try {
            $session_id = $request->query('session_id');
            $plan_id = $request->query('plan_id');

            $method = \App\Models\PaymentMethod::where('driver', 'stripe')->first();
            $stripeConfig = $method?->config ?? [];

            if (!isset($stripeConfig['secret_key'])) {
                throw new \Exception("Stripe no está configurado correctamente.");
            }

            Stripe::setApiKey($stripeConfig['secret_key']);
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            $plan = Plan::findOrFail($plan_id);
            $user = Auth::user();

            // Registrar orden de Stripe
            \App\Models\StripeOrder::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'session_id' => $session->id,
                'payment_intent' => $session->payment_intent,
                'payer_email' => $session->customer_email,
                'amount' => $plan->price,
                'currency' => strtolower($plan->currency->code),
                'status' => $session->status,
            ]);

            // Calcular fecha de finalización
            $ends_at = match ($plan->interval) {
                'monthly' => now()->addMonth(),
                'yearly' => now()->addYear(),
                'weekly' => now()->addWeek(),
                default => now()->addMonth(),
            };

            // Crear suscripción
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'name' => 'Stripe Subscription',
                'stripe_id' => $session->id,
                'stripe_status' => 'COMPLETED',
                'stripe_price' => $plan->price,
                'quantity' => 1,
                'ends_at' => $ends_at,
            ]);

            // Crear factura
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'client_name' => $user->name,
                'client_email' => $user->email,
                'amount' => $plan->price,
                'currency' => $plan->currency->code,
                'payment_method' => 'stripe',
                'status' => 'paid',
                'issue_date' => now(),
                'due_date' => $ends_at,
            ]);

            // Enviar correo
            Mail::to($user->email)->send(new \App\Mail\InvoiceMail($invoice));

            return redirect()->route('checkout.thanks');

        } catch (\Exception $e) {
            return redirect()
                ->route('plan.index')
                ->with('error', 'Ocurrió un error procesando el pago: ' . $e->getMessage());
        }
    }

    public function stripeCancel()
    {
        return redirect()->route('subscription.checkout')->with('error', 'Pago cancelado.');
    }
    
    // webhook stripe
    public function stripeWebhook(Request $request)
    {
        $method = \App\Models\PaymentMethod::where('driver', 'stripe')->first();
        $stripeConfig = $method?->config ?? [];

        \Stripe\Stripe::setApiKey($stripeConfig['secret_key']);

        $endpoint_secret = $stripeConfig['webhook_secret'] ?? null;

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $user_id = $session->metadata->user_id ?? null;
            $plan_id = $session->metadata->plan_id ?? null;

            $user = \App\Models\User::find($user_id);
            $plan = \App\Models\Plan::find($plan_id);

            if (!$user || !$plan) {
                return response('User or plan not found', 404);
            }

            // Verificar si ya existe la orden
            $existingOrder = \App\Models\StripeOrder::where('session_id', $session->id)->first();
            if ($existingOrder) {
                return response('Order already processed', 200);
            }

            // Registrar orden
            \App\Models\StripeOrder::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'session_id'     => $session->id,
                'payment_intent' => $session->payment_intent,
                'payer_email'    => $session->customer_email,
                'amount'         => $plan->price,
                'currency'       => strtolower($plan->currency->code),
                'status'         => 'paid',
            ]);

            $ends_at = match ($plan->interval) {
                'monthly' => now()->addMonth(),
                'yearly' => now()->addYear(),
                'weekly' => now()->addWeek(),
                default => now()->addMonth(),
            };

            // Crear suscripción
            $subscription = Subscription::create([
                'user_id'       => $user->id,
                'plan_id'       => $plan->id,
                'name'          => 'Stripe Subscription',
                'stripe_id'     => $session->id,
                'stripe_status' => 'COMPLETED',
                'stripe_price'  => $plan->price,
                'quantity'      => 1,
                'ends_at'       => $ends_at,
            ]);

            // Crear factura
            $invoice = Invoice::create([
                'user_id'         => $user->id,
                'subscription_id' => $subscription->id,
                'invoice_number'  => 'INV-' . strtoupper(Str::random(8)),
                'client_name'     => $user->name,
                'client_email'    => $user->email,
                'amount'          => $plan->price,
                'currency'        => $plan->currency->code,
                'payment_method'  => 'stripe',
                'status'          => 'paid',
                'issue_date'      => now(),
                'due_date'        => $ends_at,
            ]);

            try {
                Mail::to($user->email)->send(new \App\Mail\InvoiceMail($invoice));
            } catch (\Exception $e) {
                Log::error('Error sending invoice email: ' . $e->getMessage());
            }

            return response('Webhook processed', 200);
        }

        return response('Event type not handled', 200);
    }

}
