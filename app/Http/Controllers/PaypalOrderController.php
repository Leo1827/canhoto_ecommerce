<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePaid;
use Illuminate\Support\Facades\Cache;

class PaypalOrderController extends Controller
{
    //
    public function startPayment(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|in:paypal',
            'accept_terms' => 'accepted',
        ]);

        // Guardar aceptación de términos
        \App\Models\TermAcceptance::create([
            'user_id' => Auth::id(),
            'accepted_at' => now(),
            'ip_address' => $request->ip(),
            'terms_version' => 'v1.0',
        ]);

        // Log de actividad
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Processo de pagamento iniciado.',
            'description' => 'O usuário foi redirecionado para o PayPal.',
        ]);

        // Cálculo de totales
        $cartItems = Auth::user()->cartItems;
        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $shipping = 5.00;
        $tax = $subtotal * 0.21;
        $total = $subtotal + $shipping + $tax;

        // Obtener método de pago
        $method = \App\Models\PaymentMethod::where('code', $request->payment_method)->first();

        if (!$method) {
            return redirect()->route('checkout.index')->with('error', 'Método de pagamento não encontrado.');
        }

        // Convertir config a array si viene como string JSON
        if (is_string($method->config)) {
            $config = json_decode($method->config, true);
        } elseif (is_array($method->config)) {
            $config = $method->config;
        } elseif (is_object($method->config)) {
            $config = (array) $method->config;
        } else {
            $config = [];
        }


        if (
            empty($config['client_id']) ||
            empty($config['secret']) ||
            empty($config['mode'])
        ) {
            return redirect()->route('checkout.index')->with('error', 'As configurações do PayPal são inválidas ou incompletas.');
        }

        
        $paypalConfig = [
            'mode' => strtolower($config['mode']),
            'sandbox' => [
                'client_id' => $config['mode'] === 'sandbox' ? $config['client_id'] : '',
                'client_secret' => $config['mode'] === 'sandbox' ? $config['secret'] : '',
            ],
            'live' => [
                'client_id' => $config['mode'] === 'live' ? $config['client_id'] : '',
                'client_secret' => $config['mode'] === 'live' ? $config['secret'] : '',
            ],
            'currency' => $config['currency'] ?? 'EUR',
        ];

        // Inyectar config en tiempo de ejecución
        config([
            'paypal.mode' => $paypalConfig['mode'],
            'paypal.sandbox.client_id' => $paypalConfig['sandbox']['client_id'],
            'paypal.sandbox.client_secret' => $paypalConfig['sandbox']['client_secret'],
            'paypal.live.client_id' => $paypalConfig['live']['client_id'],
            'paypal.live.client_secret' => $paypalConfig['live']['client_secret'],
            'paypal.currency' => $paypalConfig['currency'],
        ]);

        

        $paypalFullConfig = [
            'mode' => $paypalConfig['mode'],
            'sandbox' => [
                'client_id'     => $paypalConfig['sandbox']['client_id'],
                'client_secret' => $paypalConfig['sandbox']['client_secret'],
                'app_id'        => '', // opcional
            ],
            'live' => [
                'client_id'     => $paypalConfig['live']['client_id'],
                'client_secret' => $paypalConfig['live']['client_secret'],
                'app_id'        => '', // opcional
            ],
            'payment_action' => 'Sale',
            'currency'       => $paypalConfig['currency'],
            'notify_url'     => '', // opcional
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];

        // dd($paypalFullConfig);

        $provider = new PayPalClient;
        $provider->setApiCredentials($paypalFullConfig);

        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => number_format($total, 2, '.', ''),
                ]
            ]]
        ]);

        // dd($response);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            $currency = \App\Models\Currency::where('code', $paypalFullConfig['currency'])->first();

            session()->put('checkout_data', [
                'address_id'    => $request->address_id,
                'user_comment'  => $request->user_comment,
                'totals'        => compact('subtotal', 'shipping', 'tax', 'total'),
                'payment_id'    => $response['id'],
                'currency_id'   => optional($currency)->id ?? 1, // usa 1 como fallback si no se encuentra
            ]);

            // Guarda los datos en cache 30 min usando el payment_id como key
            Cache::put('paypal_checkout_' . $response['id'], [
                'address_id'    => $request->address_id,
                'user_comment'  => $request->user_comment,
                'totals'        => compact('subtotal', 'shipping', 'tax', 'total'),
                'payment_id'    => $response['id'],
                'currency_id'   => optional($currency)->id ?? 1,
            ], now()->addMinutes(30));
            
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout.index')->with('error', 'O pagamento pelo PayPal não pôde ser iniciado.');
    }

    public function paypalSuccess(Request $request)
    {
        // Buscar método de pago
        $method = PaymentMethod::where('code', 'paypal')->first();

        if (!$method) {
            return redirect()->route('checkout')->with('error', 'Método de pagamento PayPal não configurado.');
        }

        // Convertir JSON a array
        $config = is_string($method->config) ? json_decode($method->config, true) : (array) $method->config;

        // Validar campos necesarios
        if (empty($config['client_id']) || empty($config['secret']) || empty($config['mode'])) {
            return redirect()->route('checkout')->with('error', 'As configurações do PayPal são inválidas ou incompletas.');
        }

        $mode = strtolower($config['mode']); // sandbox o live

        if (!in_array($mode, ['sandbox', 'live'])) {
            return redirect()->route('checkout')->with('error', 'O modo PayPal deve ser "sandbox" ou "ao vivo".');
        }

        // Preparar configuración completa para el SDK
        $paypalFullConfig = [
            'mode' => $mode,
            'sandbox' => [
                'client_id'     => $mode === 'sandbox' ? $config['client_id'] : '',
                'client_secret' => $mode === 'sandbox' ? $config['secret'] : '',
                'app_id'        => '',
            ],
            'live' => [
                'client_id'     => $mode === 'live' ? $config['client_id'] : '',
                'client_secret' => $mode === 'live' ? $config['secret'] : '',
                'app_id'        => '',
            ],
            'payment_action' => 'Sale',
            'currency'       => $config['currency'] ?? 'USD',
            'notify_url'     => '', // Si tienes un webhook, ponlo aquí
            'locale'         => 'es_ES',
            'validate_ssl'   => true,
        ];

        // Aplicar configuración en tiempo de ejecución
        config([
            'paypal.mode'                    => $paypalFullConfig['mode'],
            'paypal.sandbox.client_id'      => $paypalFullConfig['sandbox']['client_id'],
            'paypal.sandbox.client_secret'  => $paypalFullConfig['sandbox']['client_secret'],
            'paypal.live.client_id'         => $paypalFullConfig['live']['client_id'],
            'paypal.live.client_secret'     => $paypalFullConfig['live']['client_secret'],
            'paypal.currency'               => $paypalFullConfig['currency'],
        ]);

        // Inicializar cliente PayPal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);


        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
        Log::debug('🟢 Estado PayPal COMPLETED detectado.', ['status' => $response['status']]);

        $checkoutData = Cache::get('paypal_checkout_' . $request->token);

        if (!$checkoutData) {
            Log::debug('🔴 checkout_data no disponible ni en sesión ni en cache.');
            return redirect()->route('checkout.index')->with('error', 'Não foi possível recuperar as informações de pagamento.');
        }

        DB::beginTransaction();

        try {
            // Crear orden
            $order = \App\Models\Order::create([
                'user_id'          => Auth::id(),
                'user_address_id'  => $checkoutData['address_id'],
                'subtotal'         => $checkoutData['totals']['subtotal'],
                'shipping_cost'    => $checkoutData['totals']['shipping'],
                'tax'              => $checkoutData['totals']['tax'],
                'total'            => $checkoutData['totals']['total'],
                'status'           => 'paid',
                'payment_status'   => 'paid',
                'payment_method'   => 'paypal',
                'paid_at'          => now(),
                'user_comment'     => $checkoutData['user_comment'] ?? null,
                'currency_id'      => $checkoutData['currency_id'],
            ]);

            // Guardar ítems de la orden
            foreach (Auth::user()->cartItems as $item) {
                $order->items()->create([
                    'user_id'         => Auth::id(),
                    'product_id'      => $item->product_id,
                    'inventory_id'    => $item->inventory_id,
                    'label_item'      => $item->variant_label ?? null,
                    'quantity'        => $item->quantity,
                    'price_unit'      => $item->product->price,
                    'total'           => $item->subtotal,
                ]);
            }

            // Registrar aceptación de términos
            \App\Models\TermAcceptance::create([
                'user_id'        => Auth::id(),
                'accepted_at'    => now(),
                'ip_address'     => $request->ip(),
                'terms_version'  => 'v1.0',
            ]);

            // Crear factura
            $invoice = \App\Models\InvoiceStore::create([
                'user_id'         => Auth::id(),
                'order_id'        => $order->id,
                'invoice_number'  => strtoupper(Str::random(10)),
                'client_name'     => Auth::user()->name,
                'client_email'    => Auth::user()->email,
                'billing_address' => optional($order->address)->fullAddress(), // Previene el error si es null
                'amount'          => $order->total,
                'currency'        => $paypalFullConfig['currency'],
                'payment_method'  => 'paypal',
                'status'          => 'paid',
                'issue_date'      => now()->toDateString(),
                'due_date'        => now()->addDays(5)->toDateString(),
            ]);

            $invoice->load('order.items');

            // Enviar correo
            Mail::to(Auth::user()->email)->send(new InvoicePaid($invoice->order, $invoice));


            // Historial de estado
            $order->statusHistories()->create([
                'status'      => 'paid',
                'description' => 'Pagamento confirmado via PayPal.',
                'changed_at'  => now(),
            ]);

            // Registro de actividad
            \App\Models\ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Pedido pago',
                'description' => 'O pedido foi pago com sucesso via PayPal.',
            ]);

            // Limpiar carrito
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('paypal.thanks')->with('success', 'Pagamento efetuado com sucesso. Obrigado pela sua compra.');

        } catch (\Exception $e) {
                    // dd($e);
                    DB::rollBack();
                    Log::error('❌ Erro ao salvar pedido após pagamento via PayPal.', ['exception' => $e]);
                    return redirect()->route('checkout.index')->with('error', 'Erro ao salvar dados do pedido: ' . $e->getMessage());
                }
        }

        // Si el estado no es COMPLETED
        // Log::debug('⚠️ Estado PayPal no es COMPLETED.', ['status' => $response['status'] ?? 'no disponible']);
        return redirect()->route('checkout.index')->with('error', 'O pagamento não pôde ser concluído com o PayPal.');

    }

    public function webhook(Request $request)
    {
        // Puedes loguear temporalmente lo que llegue
        Log::info('Webhook recebido do PayPal', $request->all());

        $event = $request->input('event_type'); // p. ej. PAYMENT.CAPTURE.COMPLETED

        switch ($event) {
            case 'CHECKOUT.ORDER.APPROVED':
            case 'PAYMENT.CAPTURE.COMPLETED':
                // Puedes buscar la orden por ID si PayPal lo envía
                // y actualizar el estado o loguear acciones
                break;

            case 'PAYMENT.CAPTURE.DENIED':
                // Rechazo del pago
                break;

            default:
                Log::warning("Evento do PayPal não tratado: $event");
        }

        return response()->json(['status' => 'received']);
    }

    public function paypalThanks()
    {
        return view('checkout.thanksCheckout');
    }

    public function paypalCancel(Request $request)
    {
        // Si hay un token de PayPal, borra el cache relacionado
        if ($request->has('token')) {
            Cache::forget('paypal_checkout_' . $request->token);
        }

        // Log de actividad
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Processo de pagamento iniciado',
            'description' => 'O usuário cancelou o pagamento com o PayPal.',
        ]);

        // Redirige al checkout con un mensaje de error
        return redirect()->route('checkout.index')->with('error', 'Você cancelou o pagamento com o PayPal.');
    }


}
