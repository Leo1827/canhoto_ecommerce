<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Fatura #{{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #fff;
            background-color: #141414;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            color: #e50914;
        }

        .header p {
            font-size: 16px;
            color: #ccc;
        }

        .details {
            margin-top: 20px;
            color: #ddd;
        }

        .details p {
            margin: 6px 0;
        }

        .details strong {
            color: #fff;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
            color: #fff;
        }

        th {
            background-color: #333;
            font-weight: 600;
            color: #fff;
        }

        th, td {
            border: 1px solid #444;
            padding: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #1a1a1a;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .highlight {
            color: #e50914;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Fatura #{{ $invoice->invoice_number }}</h1>
            <p>Detalhes da sua subscrição</p>
        </div>

        <div class="details">
            <p><strong>Cliente:</strong> {{ $invoice->client_name }}</p>
            <p><strong>Email:</strong> {{ $invoice->client_email }}</p>
            <p><strong>Data de emissão:</strong> {{ $invoice->issue_date->format('d/m/Y H:i') }}</p>
            <p><strong>Vencimento:</strong> {{ $invoice->due_date->format('d/m/Y H:i') }}</p>
            <p><strong>Método de pagamento:</strong> {{ ucfirst($invoice->payment_method) }}</p>
            <p><strong>Status:</strong> <span class="highlight">{{ $invoice->status === 'paid' ? 'Pago' : 'Pendente' }}</span></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Assinatura do plano #{{ $invoice->subscription->plan_id }}</td>
                    <td>1</td>
                    <td>{{ number_format($invoice->amount, 2, ',', '.') }} {{ $invoice->currency }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Total: </strong> {{ number_format($invoice->amount, 2, ',', '.') }} {{ $invoice->currency }}</p>
        </div>

        <div class="footer">
            Garrafeira Canhoto - Documento gerado automaticamente. Nenhuma assinatura é necessária.
        </div>
    </div>

</body>
</html>
