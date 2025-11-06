<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\MollieOrder;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Log;


class SubscriptionMollieController extends Controller
{
    /**
     * Crear el checkout de Mollie
     */
    public function createMollieCheckout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::with('currency')->findOrFail($request->plan_id);

        if (!$plan->currency) {
            return response()->json(['error' => 'El plan no tiene una moneda asignada.'], 422);
        }

        $method = PaymentMethod::where('driver', 'mollie')->first();
        $config = $method?->config ?? [];

        if (empty($config['api_key'])) {
            return response()->json(['error' => 'Mollie no está configurado correctamente.'], 422);
        }

        Mollie::api()->setApiKey($config['api_key']);

        try {
            // Crear el pago en Mollie
            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $plan->currency->code,
                    "value" => number_format($plan->price, 2, '.', ''),
                ],
                "description" => "Suscripción: {$plan->name}",
                "redirectUrl" => route('mollie.success'),  // NO pasamos payment_id por URL
                "webhookUrl"  => "", // agregar webhook mollie
                "metadata"    => [
                    "user_id" => Auth::id(),
                    "plan_id" => $plan->id,
                ],
            ]);

            // Guardar la orden en nuestra BD
            MollieOrder::create([
                'user_id'    => Auth::id(),
                'plan_id'    => $plan->id,
                'payment_id' => $payment->id,
                'status'     => $payment->status,
                'amount'     => $plan->price,
                'currency'   => $plan->currency->code,
                'is_completed' => false,
            ]);

            return response()->json(['checkout_url' => $payment->getCheckoutUrl()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el pago: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Cuando el usuario regresa del pago
     */
    public function mollieSuccess(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('plan.index')->with('error', 'Debes iniciar sesión para completar el proceso.');
            }

            // Buscar la última orden de Mollie pendiente del usuario
            $order = MollieOrder::where('user_id', $user->id)
                        ->where('is_completed', false)
                        ->latest()
                        ->first();

            if (!$order) {
                return redirect()->route('plan.index')->with('error', 'No se encontró una orden pendiente.');
            }

            $method = PaymentMethod::where('driver', 'mollie')->first();
            $config = $method?->config ?? [];

            Mollie::api()->setApiKey($config['api_key']);
            $payment = Mollie::api()->payments->get($order->payment_id);

            if (!$payment->isPaid()) {
                return redirect()->route('plan.index')->with('error', 'El pago no fue completado.');
            }

            $plan = Plan::findOrFail($order->plan_id);

            $ends_at = match ($plan->interval) {
                'monthly' => now()->addMonth(),
                'yearly' => now()->addYear(),
                'weekly' => now()->addWeek(),
                default => now()->addMonth(),
            };

            // Crear la suscripción
            $subscription = Subscription::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'name'           => 'Mollie Subscription',
                'stripe_id'      => $order->payment_id,
                'stripe_status'  => 'COMPLETED',
                'stripe_price'   => $plan->price,
                'quantity'       => 1,
                'ends_at'        => $ends_at,
            ]);

            // Crear la factura
            $invoice = Invoice::create([
                'user_id'         => $user->id,
                'subscription_id' => $subscription->id,
                'invoice_number'  => 'INV-' . strtoupper(Str::random(8)),
                'client_name'     => $user->name,
                'client_email'    => $user->email,
                'amount'          => $plan->price,
                'currency'        => $plan->currency->code,
                'payment_method'  => 'mollie',
                'status'          => 'paid',
                'issue_date'      => now(),
                'due_date'        => $ends_at,
            ]);

            // Marcar orden como completada
            $order->is_completed = true;
            $order->status = $payment->status;
            $order->save();

            // Enviar correo de factura
            Mail::to($user->email)->send(new \App\Mail\InvoiceMail($invoice));

            return redirect()->route('checkout.thanks');

        } catch (\Exception $e) {
            return redirect()->route('plan.index')->with('error', 'Error procesando pago: ' . $e->getMessage());
        }
    }

    /**
     * Webhook que recibe Mollie
     */
    public function mollieWebhook(Request $request)
    {
        Log::info('🌐 Mollie Webhook recibido', [
            'payload' => $request->all(),
            'raw' => $request->getContent(),
        ]);

        $payload = json_decode($request->getContent());

        if (!$payload || !isset($payload->id)) {
            Log::error('❌ Mollie Webhook: ID no encontrado en el payload', [
                'payload' => $payload
            ]);
            return response('ID no encontrado en el webhook', 400);
        }

        $paymentId = $payload->id;

        if (!$paymentId) {
            Log::error('❌ Mollie Webhook: Payment ID vacío');
            return response('No se recibió payment ID', 400);
        }

        $method = PaymentMethod::where('driver', 'mollie')->first();
        $config = $method?->config ?? [];

        Mollie::api()->setApiKey($config['api_key']);

        try {
            $payment = Mollie::api()->payments->get($paymentId);

            Log::info('✅ Mollie Payment info', [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'is_paid' => $payment->isPaid()
            ]);

            $order = MollieOrder::where('payment_id', $paymentId)->first();

            if (!$order) {
                Log::error('❌ Mollie Webhook: Orden no encontrada', [
                    'payment_id' => $paymentId
                ]);
                return response('Orden no encontrada', 404);
            }

            $order->status = $payment->status;
            $order->save();

            if ($payment->isPaid() && !$order->is_completed) {

                Log::info('🚩 Mollie Webhook: Entrando a crear suscripción e invoice', [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'plan_id' => $order->plan_id
                ]);

                $plan = Plan::findOrFail($order->plan_id);
                $user = User::findOrFail($order->user_id);

                $endsAt = match ($plan->interval) {
                    'monthly' => now()->addMonth(),
                    'yearly' => now()->addYear(),
                    'weekly' => now()->addWeek(),
                    default => now()->addMonth(),
                };

                $subscription = Subscription::create([
                    'user_id'        => $user->id,
                    'plan_id'        => $plan->id,
                    'name'           => 'Mollie Subscription',
                    'stripe_status'  => 'COMPLETED', // Correcto según tu tabla
                    'stripe_price'   => $plan->price,
                    'quantity'       => 1,
                    'ends_at'        => $endsAt,
                ]);

                Log::info('✅ Mollie Webhook: Suscripción creada', [
                    'subscription_id' => $subscription->id
                ]);

                $invoice = Invoice::create([
                    'user_id'         => $user->id,
                    'subscription_id' => $subscription->id,
                    'invoice_number'  => 'INV-' . strtoupper(Str::random(8)),
                    'client_name'     => $user->name,
                    'client_email'    => $user->email,
                    'amount'          => $plan->price,
                    'currency'        => $plan->currency->code,
                    'payment_method'  => 'mollie',
                    'status'          => 'paid',
                    'issue_date'      => now(),
                    'due_date'        => $endsAt,
                ]);

                Log::info('✅ Mollie Webhook: Invoice creada', [
                    'invoice_id' => $invoice->id
                ]);

                try {
                    Mail::to($user->email)->send(new \App\Mail\InvoiceMail($invoice));
                    Log::info('📧 Mollie Webhook: Email de factura enviado', [
                        'to' => $user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('❌ Error enviando correo de factura', [
                        'error' => $e->getMessage()
                    ]);
                }

                $order->is_completed = true;
                $order->save();

                Log::info('✅ Mollie Webhook: Orden marcada como completada', [
                    'order_id' => $order->id
                ]);
            } else {
                Log::warning('⚠️ Mollie Webhook: Pago no completado o la orden ya está marcada como completada', [
                    'payment_status' => $payment->status,
                    'is_paid'        => $payment->isPaid(),
                    'is_completed'   => $order->is_completed
                ]);
            }

            return response('Webhook procesado', 200);
        } catch (\Exception $e) {
            Log::error('❌ Mollie Webhook Error', [
                'error' => $e->getMessage()
            ]);
            return response('Error en webhook: ' . $e->getMessage(), 500);
        }
    }

}
