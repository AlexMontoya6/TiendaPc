<?php

namespace App\Http\Controllers;

use App\Events\PaymentSuccessful;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Barryvdh\DomPDF\Facades\Pdf;



class PaypalController extends Controller
{
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ],

                ]
            ]
        ]);

        // 🔹 Guardamos los datos en sesión para usarlos después
        session()->put('product_name', $request->product_name);
        session()->put('quantity', $request->quantity); // ✅ Corregido error tipográfico

        // 🔹 Verificamos la respuesta de PayPal
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('cancel'); // Si falla, redirigir a la cancelación
    }


    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Capturar el pago con PayPal
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Guardar el pago en la base de datos
            $payment = $this->storePayment($response);

            // Generar el ticket en PDF
            $pdf_path = $this->generateTicketPDF($payment);

            // Manejar eventos y encolar Jobs
            $this->handlePaymentSuccess($payment, $pdf_path);

            return view('payments.success');
        }

        return redirect()->route('cancel')->with('error', 'El pago no se completó.');
    }

    /**
     * Guarda los detalles del pago en la base de datos.
     */
    private function storePayment($response)
    {
        $payment = new Payment();
        $payment->payment_id = $response['id'];
        $payment->product_name = session('product_name');
        $payment->quantity = session('quantity');
        $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
        $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
        $payment->payer_name = $response['payer']['name']['given_name'];
        $payment->payer_email = $response['payer']['email_address'];
        $payment->payment_status = $response['status'];
        $payment->payment_method = 'PayPal';
        $payment->save();

        return $payment;
    }

    /**
     * Genera el ticket de compra en PDF y lo guarda en el sistema.
     */
    private function generateTicketPDF($payment)
    {
        $pdf_path = storage_path('app/public/tickets/ticket_' . $payment->payment_id . '.pdf');

        FacadePdf::loadView('pdf.ticket', ['payment' => $payment])
            ->save($pdf_path);

        return $pdf_path;
    }

    /**
     * Maneja la lógica extra después de un pago exitoso.
     */
    /**
     * Maneja la lógica extra después de un pago exitoso.
     */
    private function handlePaymentSuccess($payment, $pdf_path)
    {
        // ✅ Enviar el evento con el email del usuario autenticado
        event(new PaymentSuccessful($payment->payment_id, auth()->user()->email, $pdf_path));

        // ✅ Limpiar variables de sesión
        session()->forget(['product_name', 'quantity', 'purchased_products']);
    }




    public function cancel()
    {
        return view('payments.cancel');
    }
}
