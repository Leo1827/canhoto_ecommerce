<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\StripeOrder;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook;

class SuscriptionStripeController extends Controller
{
    /**
     * Crear Stripe Checkout
     */
    public function createStripeCheckout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::with('currency')->findOrFail($request->plan_id);
        $method = PaymentMethod::where('driver', 'stripe')->first();
        $stripeConfig = $method?->config ?? [];

        if (empty($stripeConfig['secret_key']) || empty($stripeConfig['public_key'])) {
            return response()->json(['error' => 'Stripe no está configurado correctamente.'], 422);
        }

        Stripe::setApiKey($stripeConfig['secret_key']);

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($plan->currency->code),
                        'product_data' => ['name' => $plan->name],
                        'unit_amount' => intval($plan->price * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $plan->id,
                'cancel_url' => route('stripe.cancel'),
                'metadata' => [
                    'user_id' => Auth::id(),
                    'plan_id' => $plan->id,
                ],
            ]);

            Log::info('Stripe Checkout creado', [
                'session_id' => $session->id,
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
            ]);

            return response()->json(['id' => $session->id]);

        } catch (\Exception $e) {
            Log::error('❌ Error creando Stripe Checkout', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al crear el checkout: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Stripe success (solo visual, no crítico)
     */
    public function stripeSuccess(Request $request)
    {
        $session_id = $request->query('session_id');
        $plan_id = $request->query('plan_id');
    
        $method = PaymentMethod::where('driver', 'stripe')->first();
        $stripeConfig = $method?->config ?? [];
    
        \Stripe\Stripe::setApiKey($stripeConfig['secret_key']);
    
        try {
            // Obtenemos la sesión directamente de Stripe
            $session = \Stripe\Checkout\Session::retrieve($session_id);
    
            if ($session->payment_status === 'paid') {
                return redirect()->route('checkout.thanks');
            } else {
                return redirect()->route('plan.index')
                    ->with('error', 'Estamos procesando tu pago. Si ya realizaste el pago, tu suscripción estará activa en unos minutos.');
            }
    
        } catch (\Exception $e) {
            Log::error('❌ Stripe Success Error', ['error' => $e->getMessage()]);
    
            return redirect()->route('plan.index')
                ->with('error', 'Error al verificar el estado de tu pago. Por favor contacta a soporte.');
        }
    }
    

    /**
     * Stripe cancel
     */
    public function stripeCancel()
    {
        return redirect()->route('plan.index')->with('error', 'Pago cancelado.');
    }

    /**
     * Stripe webhook
     */
    public function stripeWebhook(Request $request)
    {
        $payload = @file_get_contents('php://input');

        try {
            $event = json_decode($payload);
        } catch (\Exception $e) {
            Log::error('❌ Error en webhook: ' . $e->getMessage());
            return response('Invalid payload', 400);
        }

        if (!$event) {
            Log::error('❌ Payload inválido');
            return response('Invalid payload', 400);
        }

        if (isset($event->type) && $event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $user_id = $session->metadata->user_id ?? null;
            $plan_id = $session->metadata->plan_id ?? null;

            $user = \App\Models\User::find($user_id);
            $plan = \App\Models\Plan::find($plan_id);

            if (!$user || !$plan) {
                Log::error('❌ Usuario o Plan no encontrado', [
                    'user_id' => $user_id,
                    'plan_id' => $plan_id,
                ]);
                return response('User or plan not found', 404);
            }

            // Verificar si ya existe la orden
            $existingOrder = \App\Models\StripeOrder::where('session_id', $session->id)->first();
            if ($existingOrder) {
                Log::info('⚠️ Orden ya procesada', [
                    'session_id' => $session->id,
                ]);
                return response('Order already processed', 200);
            }

            try {
                // Guardar la orden
                \App\Models\StripeOrder::create([
                    'user_id'        => $user->id,
                    'plan_id'        => $plan->id,
                    'session_id'     => $session->id,
                    'payment_intent' => $session->payment_intent ?? null,
                    'payer_email'    => $session->customer_email ?? null,
                    'amount'         => $plan->price,
                    'currency'       => strtolower($plan->currency->code),
                    'status'         => 'paid',
                ]);

                $ends_at = match ($plan->interval) {
                    'monthly' => now()->addMonth(),
                    'yearly'  => now()->addYear(),
                    'weekly'  => now()->addWeek(),
                    default   => now()->addMonth(),
                };

                // Crear la suscripción
                $subscription = \App\Models\Subscription::create([
                    'user_id'       => $user->id,
                    'plan_id'       => $plan->id,
                    'name'          => 'Stripe Subscription',
                    'stripe_id'     => $session->id,
                    'stripe_status' => 'COMPLETED',
                    'stripe_price'  => $plan->price,
                    'quantity'      => 1,
                    'ends_at'       => $ends_at,
                ]);

                // Crear la factura
                $invoice = \App\Models\Invoice::create([
                    'user_id'         => $user->id,
                    'subscription_id' => $subscription->id,
                    'invoice_number'  => 'INV-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'client_name'     => $user->name,
                    'client_email'    => $user->email,
                    'amount'          => $plan->price,
                    'currency'        => $plan->currency->code,
                    'payment_method'  => 'stripe',
                    'status'          => 'paid',
                    'issue_date'      => now(),
                    'due_date'        => $ends_at,
                ]);

                // Opcional: enviar factura por correo
                try {
                    Mail::to($user->email)->send(new \App\Mail\InvoiceMail($invoice));
                    Log::info('📧 Factura enviada a ' . $user->email);
                } catch (\Exception $e) {
                    Log::error('❌ Error enviando factura: ' . $e->getMessage());
                }

                Log::info('✅ Webhook procesado correctamente', [
                    'session_id' => $session->id,
                    'subscription_id' => $subscription->id,
                ]);

                return response('Webhook procesado correctamente', 200);

            } catch (\Exception $e) {
                Log::error('❌ Error procesando webhook: ' . $e->getMessage());
                return response('Error procesando webhook', 500);
            }
        }

        return response('Evento no manejado', 200);
    }


}
