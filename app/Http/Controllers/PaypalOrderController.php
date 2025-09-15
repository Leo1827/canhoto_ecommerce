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
use Illuminate\Support\Arr;

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
            'action' => 'Proceso de pago iniciado.',
            'description' => 'El usuario fue redirigido para pagar por PayPal.',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product', 'product.tax', 'inventory')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('checkout.index')->with('error', 'El carrito está vacío.');
        }

        $currency = \App\Models\Currency::where('code', config('paypal.currency', 'EUR'))->first();
        $currencyCode = $currency->code ?? 'EUR';

        // Construir items para PayPal y cache
        $paypalItems = [];
        $checkoutItems = [];
        $item_total = 0.0;
        $tax_total = 0.0;
        $shipping = 0.00;

        foreach ($cartItems as $ci) {
            $product = $ci->product;
            $inventory = $ci->inventory;
            $qty = (int) $ci->quantity;

            $unitPrice = $ci->price_unit ?? ($inventory?->price ?? $product->price);
            $unitPrice = floatval($unitPrice);

            $taxRate = $product->tax->rate ?? 0;
            $unitTax = round($unitPrice * ($taxRate / 100), 2);

            $subtotal = round($unitPrice * $qty, 2);
            $taxAmount = round($unitTax * $qty, 2);

            $item_total += $subtotal;
            $tax_total += $taxAmount;

            $paypalItems[] = [
                'name' => Str::limit($product->name, 127),
                'unit_amount' => [
                    'currency_code' => $currencyCode,
                    'value' => number_format($unitPrice, 2, '.', ''),
                ],
                'tax' => [
                    'currency_code' => $currencyCode,
                    'value' => number_format($unitTax, 2, '.', ''),
                ],
                'quantity' => (string)$qty,
                'sku' => $product->sku ?? (string)$product->id,
            ];

            $checkoutItems[] = [
                'product_id' => $product->id,
                'inventory_id' => $ci->inventory_id,
                'name' => $product->name,
                'price_unit' => number_format($unitPrice, 2, '.', ''),
                'quantity' => $qty,
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'tax_rate' => $taxRate,
                'tax_amount' => number_format($taxAmount, 2, '.', ''),
            ];
        }

        // Total base (subtotal + impuestos + envío)
        $totalBase = round($item_total + $tax_total + $shipping, 2);

        // 👉 Comisión PayPal (ejemplo: 3.49% + 0.35 fijo)
        $paypalFee = round(($totalBase * 0.0349) + 0.35, 2);

        // 👉 Total final con comisión incluida
        $total = round($totalBase + $paypalFee, 2);

        // Configuración PayPal
        $method = \App\Models\PaymentMethod::where('code', $request->payment_method)->first();
        if (!$method) {
            return redirect()->route('checkout.index')->with('error', 'Método de pago no encontrado.');
        }

        $config = is_string($method->config) ? json_decode($method->config, true) : (array) $method->config;

        $paypalConfig = [
            'mode' => strtolower($config['mode'] ?? 'sandbox'),
            'sandbox' => [
                'client_id' => $config['mode'] === 'sandbox' ? ($config['client_id'] ?? '') : '',
                'client_secret' => $config['mode'] === 'sandbox' ? ($config['secret'] ?? '') : '',
            ],
            'live' => [
                'client_id' => $config['mode'] === 'live' ? ($config['client_id'] ?? '') : '',
                'client_secret' => $config['mode'] === 'live' ? ($config['secret'] ?? '') : '',
            ],
            'currency' => $config['currency'] ?? $currencyCode,
        ];

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
                'client_id' => $paypalConfig['sandbox']['client_id'],
                'client_secret' => $paypalConfig['sandbox']['client_secret'],
                'app_id' => '',
            ],
            'live' => [
                'client_id' => $paypalConfig['live']['client_id'],
                'client_secret' => $paypalConfig['live']['client_secret'],
                'app_id' => '',
            ],
            'payment_action' => 'Sale',
            'currency' => $paypalConfig['currency'],
            'notify_url' => '',
            'locale' => 'en_US',
            'validate_ssl' => true,
        ];

        $provider = new PayPalClient;
        $provider->setApiCredentials($paypalFullConfig);
        $provider->getAccessToken();

        $createOrderPayload = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currencyCode,
                    'value' => number_format($total, 2, '.', ''), // total con comisión
                    'breakdown' => [
                        'item_total' => [
                            'currency_code' => $currencyCode,
                            'value' => number_format($item_total, 2, '.', ''),
                        ],
                        'tax_total' => [
                            'currency_code' => $currencyCode,
                            'value' => number_format($tax_total, 2, '.', ''),
                        ],
                        'shipping' => [
                            'currency_code' => $currencyCode,
                            'value' => number_format($shipping, 2, '.', ''),
                        ],
                        'handling' => [ // 👈 aquí guardamos la comisión como "handling"
                            'currency_code' => $currencyCode,
                            'value' => number_format($paypalFee, 2, '.', ''),
                        ],
                    ],
                ],
                'items' => $paypalItems,
            ]],
        ];

        $response = $provider->createOrder($createOrderPayload);

        if (isset($response['id']) && ($response['status'] === 'CREATED' || $response['status'] === 'APPROVED')) {
            Cache::put('paypal_checkout_' . $response['id'], [
                'address_id' => $request->address_id,
                'user_comment' => $request->user_comment,
                'totals' => [
                    'item_total' => number_format($item_total, 2, '.', ''),
                    'tax_total' => number_format($tax_total, 2, '.', ''),
                    'shipping' => number_format($shipping, 2, '.', ''),
                    'paypal_fee' => number_format($paypalFee, 2, '.', ''), // lo guardamos para mostrarlo en waiting room
                    'total' => number_format($total, 2, '.', ''),
                ],
                'items' => $checkoutItems,
                'currency_id' => optional($currency)->id ?? 1,
            ], now()->addMinutes(30));

            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout.index')->with('error', 'El pago por PayPal no pudo iniciarse.');
    }

    public function paypalSuccess(Request $request)
    {
        $method = PaymentMethod::where('code', 'paypal')->first();
        if (!$method) {
            return redirect()->route('checkout.index')->with('error', 'Método PayPal no configurado.');
        }
        $config = is_string($method->config) ? json_decode($method->config, true) : (array)$method->config;
        if (empty($config['client_id']) || empty($config['secret']) || empty($config['mode'])) {
            return redirect()->route('checkout.index')->with('error', 'Configuración PayPal incompleta.');
        }

        $mode = strtolower($config['mode']);
        $paypalFullConfig = [
            'mode' => $mode,
            'sandbox' => [
                'client_id' => $mode === 'sandbox' ? $config['client_id'] : '',
                'client_secret' => $mode === 'sandbox' ? $config['secret'] : '',
                'app_id' => '',
            ],
            'live' => [
                'client_id' => $mode === 'live' ? $config['client_id'] : '',
                'client_secret' => $mode === 'live' ? $config['secret'] : '',
                'app_id' => '',
            ],
            'payment_action' => 'Sale',
            'currency' => $config['currency'] ?? 'EUR',
            'notify_url' => '',
            'locale' => 'es_ES',
            'validate_ssl' => true,
        ];

        config([
            'paypal.mode' => $paypalFullConfig['mode'],
            'paypal.sandbox.client_id' => $paypalFullConfig['sandbox']['client_id'],
            'paypal.sandbox.client_secret' => $paypalFullConfig['sandbox']['client_secret'],
            'paypal.live.client_id' => $paypalFullConfig['live']['client_id'],
            'paypal.live.client_secret' => $paypalFullConfig['live']['client_secret'],
            'paypal.currency' => $paypalFullConfig['currency'],
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (!isset($response['status'])) {
            Log::error('Respuesta PayPal inesperada en capture', ['response' => $response]);
            return redirect()->route('checkout.index')->with('error', 'No fue posible verificar el pago con PayPal.');
        }

        if ($response['status'] !== 'COMPLETED') {
            Log::warning('Estado PayPal no completado', ['status' => $response['status'], 'response' => $response]);
            // Puedes permitir pending y mostrar mensaje o tratarlo como error
            return redirect()->route('checkout.index')->with('error', 'El pago no se completó.');
        }

        // Recuperar checkoutData de cache
        $checkoutData = Cache::get('paypal_checkout_' . $request->token);
        if (!$checkoutData) {
            Log::error('checkout_data no encontrado en cache al confirmar PayPal', ['token' => $request->token]);
            return redirect()->route('checkout.index')->with('error', 'No se pudo recuperar la información del pago.');
        }

        DB::beginTransaction();
        try {
            // Extraer valores desde response (uso data_get para evitar notices)
            $purchaseUnit = data_get($response, 'purchase_units.0', []);
            $capture = data_get($purchaseUnit, 'payments.captures.0', $response); // fallback a root si estructura distinta

            // Tax informado por PayPal (si lo provee)
            $paypalTax = (float) data_get($capture, 'amount.breakdown.tax_total.value') 
                        ?? (float) data_get($purchaseUnit, 'amount.breakdown.tax_total.value')
                        ?? (float) ($checkoutData['totals']['tax_total'] ?? 0);

            // PayPal fee (puede estar en seller_receivable_breakdown)
            $paypalFee = null;
            if (data_get($capture, 'seller_receivable_breakdown.paypal_fee.value') !== null) {
                $paypalFee = (float) data_get($capture, 'seller_receivable_breakdown.paypal_fee.value');
            } elseif (data_get($capture, 'seller_receivable_breakdown.paypal_fee') !== null) {
                $paypalFee = (float) data_get($capture, 'seller_receivable_breakdown.paypal_fee');
            } else {
                // fallback: si no viene, estimar o 0
                $paypalFee = 0.00;
            }

            $currency = \App\Models\Currency::where('code', 'EUR')->first();

            $order = \App\Models\Order::create([
                'user_id' => Auth::id(),
                'user_address_id' => $checkoutData['address_id'],
                'subtotal' => $checkoutData['totals']['item_total'],
                'shipping_cost' => $checkoutData['totals']['shipping'],
                'tax' => $checkoutData['totals']['tax_total'], // 👈 lo que calculaste en tu tienda
                'total' => $checkoutData['totals']['total'],   // 👈 lo que calculaste en tu tienda
                'status' => 'paid',
                'payment_status' => 'paid',
                'payment_method' => 'PayPal',
                'paid_at' => now(),
                'user_comment' => $checkoutData['user_comment'] ?? null,
                'currency_id' => $currency->id,
                // 📌 valores reales desde PayPal
                'payment_provider_fee' => $paypalFee,
                'payment_provider_tax' => $paypalTax,
                'payment_provider_total' => (float) data_get($capture, 'amount.value'),
                'payment_provider_currency' => data_get($capture, 'amount.currency_code', $paypalFullConfig['currency']),
                'payment_provider_id' => $response['id'] ?? $request->token,
                'payment_provider_raw' => json_encode($response),
            ]);

            // Crear order_items usando los datos guardados en cache (para garantizar igualdad con PayPal)
            foreach ($checkoutData['items'] as $it) {
                // Si necesitas verificar stock, hazlo aquí (similar a lo que ya tenías)
                $inventory = \App\Models\ProductInventory::find($it['inventory_id']);
                if ($inventory && $inventory->quantity < $it['quantity']) {
                    throw new \Exception('No hay suficiente stock para el producto: ' . $it['name']);
                }
                if ($inventory) {
                    $inventory->quantity -= $it['quantity'];
                    $inventory->save();
                }

                $order->items()->create([
                    'user_id' => Auth::id(),
                    'product_id' => $it['product_id'],
                    'inventory_id' => $it['inventory_id'],
                    'label_item' => $it['name'],
                    'quantity' => $it['quantity'],
                    'price_unit' => $it['price_unit'],
                    'total' => $it['subtotal'],
                    'tax_id' => null,
                    'tax_rate' => $it['tax_rate'],
                    'tax_amount' => $it['tax_amount'], // impuesto calculado en tu tienda
                    'provider_tax_amount' => $it['provider_tax_amount'] ?? null, // impuesto real que informó PayPal
                ]);
            }

            // terms acceptance, invoice, mails, logs (igual que antes)
            \App\Models\TermAcceptance::create([
                'user_id' => Auth::id(),
                'accepted_at' => now(),
                'ip_address' => $request->ip(),
                'terms_version' => 'v1.0',
            ]);

            $invoice = \App\Models\InvoiceStore::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'invoice_number' => strtoupper(Str::random(10)),
                'client_name' => Auth::user()->name,
                'client_email' => Auth::user()->email,
                'billing_address' => optional($order->address)->fullAddress(),
                'amount' => $order->total,
                'currency' => $paypalFullConfig['currency'],
                'payment_method' => 'paypal',
                'status' => 'paid',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(5)->toDateString(),
            ]);

            Mail::to(Auth::user()->email)->send(new InvoicePaid($order, $invoice));

            $order->statusHistories()->create([
                'status' => 'paid',
                'description' => 'Pago confirmado vía PayPal.',
                'changed_at' => now(),
            ]);

            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Pedido pagado',
                'description' => 'Pedido pagado con PayPal.',
            ]);
            

            // Limpiar carrito
            Auth::user()->cartItems()->delete();

            DB::commit();

            // Borrar cache
            Cache::forget('paypal_checkout_' . $request->token);

            return redirect()->route('paypal.thanks')->with('success', 'Pago efectuado con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar pedido tras PayPal: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('checkout.index')->with('error', 'Error al guardar el pedido: ' . $e->getMessage());
        }
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
