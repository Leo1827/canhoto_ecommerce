
@component('mail::message')
# ¡Gracias por tu compra, {{ $order->user->name }}!

Tu orden ha sido procesada con éxito.

## 🧾 Factura: {{ $invoice->invoice_number }}
- Fecha: {{ $invoice->issue_date }}
- Total: ${{ number_format($order->total, 2) }} {{ $invoice->currency }}
- Método de pago: {{ ucfirst($invoice->payment_method) }}

## 🛒 Detalles del pedido

@foreach($order->items as $item)
- {{ $item->label_item ?? $item->product->name }} x {{ $item->quantity }} - ${{ number_format($item->total, 2) }}
@endforeach

@component('mail::button', ['url' => route('user.orders.show', $order)])
Ver pedido
@endcomponent

Gracias por tu confianza.<br>
www.canhotopremium.com
@endcomponent
