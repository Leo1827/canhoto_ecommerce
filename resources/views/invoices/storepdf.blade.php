<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Fatura {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #2c2c2c;
            margin: 0;
            padding: 0 40px;
            font-size: 13px;
        }
        .header, .footer {
            margin-bottom: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 26px;
            margin-bottom: 5px;
            color: #5a1a01;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
        }
        .info {
            margin-bottom: 25px;
        }
        .info h3 {
            font-size: 16px;
            color: #5a1a01;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        .info p {
            font-size: 13px;
            margin: 2px 0;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items th, .items td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 13px;
        }
        .items th {
            background-color: #5a1a01;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
        }
        .items td {
            vertical-align: middle;
        }
        .totals {
            text-align: right;
            margin-bottom: 30px;
        }
        .totals p {
            font-size: 14px;
            margin: 4px 0;
        }
        .totals strong {
            font-size: 15px;
        }
        .footer small {
            font-size: 11px;
            color: #777;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0;
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
        <p><strong>Empresa:</strong> Loja de Vinhos do Porto Lda</p>
        <p><strong>NIF:</strong> 504123456</p>
        <p><strong>Email:</strong> suporte@vinhosporto.pt</p>
        <p><strong>Morada:</strong> Rua das Caves nº 12, Vila Nova de Gaia, Porto - Portugal</p>

        <h3>Cliente</h3>
        <p><strong>Nome:</strong> {{ $invoice->client_name }}</p>
        <p><strong>Email:</strong> {{ $invoice->client_email }}</p>
        <p><strong>NIF:</strong> {{ $invoice->client_nif ?? 'Consumidor final' }}</p>
        <p><strong>Morada:</strong> {{ $invoice->client_address ?? 'Não disponível' }}</p>
    </div>

    <div class="items">
        <h3>Produtos</h3>
        <table>
            <thead>
                <tr>
                    <th style="width:30%;">Produto</th>
                    <th style="width:10%;">Qtd</th>
                    <th style="width:15%;">Preço Unit. (€)</th>
                    <th style="width:10%;">IVA</th>
                    <th style="width:15%;">Valor IVA (€)</th>
                    <th style="width:20%;">Total c/ IVA (€)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalTax = 0;
                    $subtotal = 0;
                @endphp

                @foreach($invoice->order->items as $item)
                    @php
                        $taxRate   = $item->tax_rate ?? 0;
                        $taxValue  = $item->tax_amount ?? 0;
                        $lineTotal = ($item->price_unit * $item->quantity) + $taxValue;
                        $totalTax += $taxValue;
                        $subtotal += ($item->price_unit * $item->quantity);
                    @endphp
                    <tr>
                        <td>{{ $item->label_item ?? $item->product->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">{{ number_format($item->price_unit, 2, ',', '.') }}</td>
                        <td style="text-align:center;">{{ $taxRate ? $taxRate.'%' : 'Isento' }}</td>
                        <td style="text-align:right;">{{ number_format($taxValue, 2, ',', '.') }}</td>
                        <td style="text-align:right;">{{ number_format($lineTotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="totals">
        <p><strong>Subtotal (s/ IVA):</strong> € {{ number_format($subtotal, 2, ',', '.') }}</p>
        <p><strong>Total IVA:</strong> € {{ number_format($totalTax, 2, ',', '.') }}</p>
        <p><strong>Portes de envio:</strong> € {{ number_format($invoice->order->shipping_cost, 2, ',', '.') }}</p>
        <hr>
        <p><strong>Total a pagar:</strong> € {{ number_format($subtotal + $totalTax + $invoice->order->shipping_cost, 2, ',', '.') }} {{ $invoice->currency }}</p>
        <p><strong>Método de pagamento:</strong> {{ ucfirst($invoice->payment_method) }}</p>
    </div>

    <div class="footer">
        <p><em>Documento emitido nos termos legais – válido como fatura-recibo.</em></p>
        <small>Emitido automaticamente em {{ now()->format('d/m/Y H:i') }}</small>
    </div>

</body>
</html>
