<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class MisComptrasController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments;

        return view('panel.mis-compras', compact('payments'));
    }

    public function generatePDF(Payment $payment)
    {
        // Cargar la vista con los datos del pago
        $pdf = Pdf::loadView('pdf.ticket', compact('payment'));

        // Descargar el PDF con el nombre adecuado
        return $pdf->download("ticket_{$payment->id}.pdf");
    }
}
