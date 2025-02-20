<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        h1 { color: #4CAF50; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ticket de Compra</h1>
        <p><strong>Pedido ID:</strong> {{ $payment->payment_id }}</p>
        <p><strong>Cliente:</strong> {{ $payment->payer_name }}</p>
        <p><strong>Email:</strong> {{ $payment->payer_email }}</p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $payment->product_name }}</td>
                    <td>{{ $payment->quantity }}</td>
                    <td>{{ $payment->amount }} {{ $payment->currency }}</td>
                </tr>
            </tbody>
        </table>

        <p class="footer">Gracias por tu compra en TiendaPc.</p>
    </div>
</body>
</html>
