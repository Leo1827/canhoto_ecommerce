<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Fatura {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            color: #2c2c2c;
            margin: 0;
            padding: 0 40px;
        }
        .header, .footer {
            margin-bottom: 40px;
            text-align: center;
        }
        .header h1 {
            font-size: 32px;
            margin-bottom: 5px;
            color: #5a1a01;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
        }
        .info h3 {
            font-size: 18px;
            color: #5a1a01;
            margin-bottom: 8px;
        }
        .info p {
            font-size: 14px;
            margin: 4px 0;
        }
        .items h3 {
            font-size: 18px;
            color: #5a1a01;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }
        th {
            background-color: #5a1a01;
            color: #fff;
            text-transform: uppercase;
            font-weight: normal;
        }
        .totals p {
            font-size: 15px;
            margin: 6px 0;
        }
        .footer small {
            font-size: 12px;
            color: #777;
        }
        .totals {
            text-align: right;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Fatura</h1>
        <p><strong>Nº:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Data de emissão:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</p>
    </div>

    <div class="info">
        <h3>Emitido por</h3>
        <p><strong>Loja:</strong> Loja de Vinhos do Porto Lda</p>
        <p><strong>NIF:</strong> 504123456</p>
        @if($order->userAddress)
            <p><strong>Endereço escolhido pelo cliente:</strong></p>
            <address class="not-italic text-gray-700 leading-snug">
                {{ $order->userAddress->full_name }}<br>
                {{ $order->userAddress->address }}<br>
                {{ $order->userAddress->city }},
                {{ $order->userAddress->state }}<br>
                {{ $order->userAddress->postal_code }}<br>
                {{ $order->userAddress->country }}<br>
                @if($order->userAddress->phone)
                    Tel: {{ $order->userAddress->phone }}
                @endif
            </address>
        @endif


        <p><strong>Email:</strong> suporte@vinhosporto.pt</p>

        <h3>Cliente</h3>
        <p><strong>Nome:</strong> {{ $invoice->client_name }}</p>
        <p><strong>Email:</strong> {{ $invoice->client_email }}</p>
        <p><strong>NIF:</strong> {{ $invoice->client_nif ?? '000000000' }}</p>
        <p><strong>Morada:</strong> {{ $invoice->client_address ?? 'Não disponível' }}</p>
    </div>

    <div class="items">
        <h3>Produtos</h3>
        <table>
            <thead>
                <tr>
                    <th style="width:40%;">Produto</th>
                    <th style="width:15%;">Quantidade</th>
                    <th style="width:20%;">Preço Unitário</th>
                    <th style="width:25%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->items as $item)
                    <tr>
                        <td>{{ $item->label_item ?? $item->product->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">€ {{ number_format($item->price_unit, 2, ',', '.') }}</td>
                        <td style="text-align:right;">€ {{ number_format($item->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="totals">
        <p><strong>Subtotal:</strong> € {{ number_format($invoice->order->subtotal, 2, ',', '.') }}</p>

        <p>
            <strong>IVA ({{ $invoice->order->subtotal > 0 ? number_format(($invoice->order->tax / $invoice->order->subtotal) * 100, 2, ',', '.') : 0 }}%):</strong>
            € {{ number_format($invoice->order->tax, 2, ',', '.') }}
        </p>

        <p><strong>Custo de envio:</strong> € {{ number_format($invoice->order->shipping_cost, 2, ',', '.') }}</p>

        <hr style="margin: 10px 0; border: none; border-top: 1px solid #ccc;">

        <p><strong>Total:</strong> € {{ number_format($invoice->order->total, 2, ',', '.') }} {{ $invoice->currency }}</p>

        <p><strong>Método de pagamento:</strong> {{ ucfirst($invoice->payment_method) }}</p>
    </div>


    <div class="footer">
        <p><em>Esta fatura serve como comprovativo oficial da sua compra.</em></p>
        <small>Emitido automaticamente em {{ now()->format('d/m/Y H:i') }}</small>
    </div>

</body>
</html>
