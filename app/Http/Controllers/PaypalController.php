<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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


        $product = Product::findOrFail($request->product_id);

        session()->put('product_name', $product->name);
        session()->put('product_id', $product->id);
        session()->put('quantity', $request->quantity);

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


    function success(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment = new Payment();
            $payment->payment_id = $response['id'];
            $payment->product_id = session('product_id');
            $payment->product_name = session('product_name');
            $payment->quantity = session('quantity');
            $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payment_status = $response['status'];
            $payment->payment_method = 'PayPal';
            $payment->save();
            return view('payments.success');



            unset($_SESSION['product_name']);
            unset($_SESSION['quantity']);
        } else {
            return redirect()->route('cancel')->with('error', 'El pago no se completó.');
        }
    }

    public function cancel()
    {
        return view('payments.cancel');
    }
}
