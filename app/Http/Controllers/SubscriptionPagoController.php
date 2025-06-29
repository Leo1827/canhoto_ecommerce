<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\PaypalOrder;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Str;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class SubscriptionPagoController extends Controller
{
    //
    public function capturePaypalOrder(Request $request)
    {
        try {
            $data = $request->validate([
                'order_id' => 'required|string',
                'payer_id' => 'required|string',
                'payer_email' => 'required|email',
                'payer_name' => 'nullable|string',
                'amount' => 'required|numeric',
                'currency' => 'required|string',
                'status' => 'required|string',
                'plan_id' => 'required|exists:plans,id',
            ]);

            // 1. Obtener el plan para saber el intervalo (monthly, yearly, etc.)
            $plan = Plan::findOrFail($data['plan_id']);

            // 2. Calcular la fecha de finalización
            $ends_at = match ($plan->interval) {
                'monthly' => Carbon::now()->addMonth(),
                'yearly' => Carbon::now()->addYear(),
                'weekly' => Carbon::now()->addWeek(),
                default => null // puedes manejar otros casos según necesidad
            };

            // 3. Guardar orden de PayPal
            PaypalOrder::create([
                'user_id' => Auth::id(),
                'plan_id' => $data['plan_id'],
                'order_id' => $data['order_id'],
                'payer_id' => $data['payer_id'],
                'payer_email' => $data['payer_email'],
                'payer_name' => $data['payer_name'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'status' => $data['status'],
            ]);

            // 4. Crear la suscripción con la fecha de finalización
            $subscription = Subscription::create([
                'user_id' => Auth::id(),
                'plan_id' => $data['plan_id'],
                'name' => 'PayPal Subscription',
                'stripe_id' => $data['order_id'],
                'stripe_status' => $data['status'],
                'stripe_price' => $data['amount'],
                'quantity' => 1,
                'ends_at' => $ends_at,
            ]);


            $invoice = Invoice::create([
                'user_id' => Auth::id(),
                'subscription_id' => $subscription->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'client_name' => $data['payer_name'],
                'client_email' => $data['payer_email'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'payment_method' => 'paypal',
                'status' => $data['status'] === 'COMPLETED' ? 'paid' : 'pending',
                'issue_date' => now(),
                'due_date' => $ends_at,
            ]);

            // email payment
            // Mail::to($data['payer_email'])->send(new InvoiceMail($invoice));
            // email user
            Mail::to(Auth::user()->email)->send(new InvoiceMail($invoice));

            return response()->json(['message' => 'Orden registrada correctamente']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la orden: ' . $e->getMessage()], 500);
        }
    }

    public function viewThanks()
    {
        return view('subscription.thanks');
    }

    public function paypalWebhook(Request $request)
    {
        try {
            // Captura el payload completo del webhook
            $payload = $request->all();

            // Log opcional
            Log::info('📬 PayPal Webhook recibido', $payload);

            // Verifica que sea un evento de pago completado
            if (
                isset($payload['event_type']) &&
                $payload['event_type'] === 'CHECKOUT.ORDER.APPROVED'
            ) {
                $resource = $payload['resource'] ?? null;

                if (!$resource) {
                    return response('Resource not found', 400);
                }

                $orderId = $resource['id'] ?? null;
                $payer = $resource['payer'] ?? [];
                $payerId = $payer['payer_id'] ?? null;
                $payerEmail = $payer['email_address'] ?? null;
                $payerName = ($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? '');

                // Metadata: debes enviar plan_id y user_id en la creación de la orden desde tu frontend
                $customId = $resource['custom_id'] ?? null; // Aquí podrías concatenar user_id y plan_id: "userID-planID"
                [$userId, $planId] = explode('-', $customId);

                $amountValue = $resource['purchase_units'][0]['amount']['value'] ?? null;
                $currency = $resource['purchase_units'][0]['amount']['currency_code'] ?? null;

                if (!$userId || !$planId) {
                    return response('Metadata user_id or plan_id missing', 400);
                }

                $user = \App\Models\User::find($userId);
                $plan = \App\Models\Plan::find($planId);

                if (!$user || !$plan) {
                    return response('User or Plan not found', 404);
                }

                // Verificar si la orden ya existe
                $exists = \App\Models\PaypalOrder::where('order_id', $orderId)->first();
                if ($exists) {
                    return response('Order already processed', 200);
                }

                // Calcular fecha de fin
                $ends_at = match ($plan->interval) {
                    'monthly' => now()->addMonth(),
                    'yearly' => now()->addYear(),
                    'weekly' => now()->addWeek(),
                    default => now()->addMonth(),
                };

                // Guardar la orden
                \App\Models\PaypalOrder::create([
                    'user_id' => $userId,
                    'plan_id' => $planId,
                    'order_id' => $orderId,
                    'payer_id' => $payerId,
                    'payer_email' => $payerEmail,
                    'payer_name' => $payerName,
                    'amount' => $amountValue,
                    'currency' => $currency,
                    'status' => 'COMPLETED',
                ]);

                // Crear suscripción
                $subscription = Subscription::create([
                    'user_id' => $userId,
                    'plan_id' => $planId,
                    'name' => 'PayPal Subscription',
                    'stripe_id' => $orderId, // Puedes mantenerlo como referencia
                    'stripe_status' => 'COMPLETED',
                    'stripe_price' => $amountValue,
                    'quantity' => 1,
                    'ends_at' => $ends_at,
                ]);

                // Crear factura
                $invoice = Invoice::create([
                    'user_id' => $userId,
                    'subscription_id' => $subscription->id,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                    'client_name' => $payerName,
                    'client_email' => $payerEmail,
                    'amount' => $amountValue,
                    'currency' => $currency,
                    'payment_method' => 'paypal',
                    'status' => 'paid',
                    'issue_date' => now(),
                    'due_date' => $ends_at,
                ]);

                // Enviar factura al usuario
                try {
                    Mail::to($payerEmail)->send(new InvoiceMail($invoice));
                } catch (\Exception $e) {
                    Log::error('❌ Error enviando email de PayPal', [
                        'error' => $e->getMessage(),
                    ]);
                }

                return response('Webhook processed', 200);
            }

            return response('Event type not handled', 200);

        } catch (\Exception $e) {
            Log::error('❌ PayPal Webhook error', [
                'error' => $e->getMessage(),
            ]);
            return response('Error in webhook: ' . $e->getMessage(), 500);
        }
    }

}
