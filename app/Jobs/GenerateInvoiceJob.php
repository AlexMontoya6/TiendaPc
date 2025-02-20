<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment_id;

    /**
     * Crear una nueva instancia del job.
     */
    public function __construct($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    /**
     * Ejecutar el job.
     */
    public function handle()
    {
        // Obtener el pago desde la base de datos
        $payment = Payment::where('payment_id', $this->payment_id)->first();

        if (!$payment) {
            Log::error("❌ GenerateInvoiceJob: No se encontró el pago con ID " . $this->payment_id);
            return null;
        }

        Log::info("🔄 Generando PDF para el pago ID: " . $payment->id);

        // Generar el nombre del archivo
        $pdf_filename = "payment_{$payment->id}.pdf";
        $pdf_relative_path = "public/tickets/{$pdf_filename}";
        $pdf_absolute_path = storage_path("app/" . $pdf_relative_path);

        // Verificar si ya existe antes de generar uno nuevo
        if (Storage::exists($pdf_relative_path)) {
            Log::warning("⚠️ El archivo PDF ya existe: " . $pdf_absolute_path);
            return $pdf_absolute_path;
        }

        // Asegurar que la carpeta de destino existe
        Storage::makeDirectory("public/tickets");

        // Generar el PDF con la vista `pdf.ticket`
        try {
            $pdf = Pdf::loadView('pdf.ticket', ['payment' => $payment]);
        } catch (\Exception $e) {
            Log::error("❌ Error al generar el PDF: " . $e->getMessage());
            return null;
        }

        // Guardar el PDF en la ubicación correcta
        Storage::put($pdf_relative_path, $pdf->output());

        // Verificar que se guardó correctamente
        if (!Storage::exists($pdf_relative_path)) {
            Log::error("❌ Error al guardar el PDF en: " . $pdf_absolute_path);
            return null;
        }

        Log::info("✅ PDF generado correctamente en: " . $pdf_absolute_path);

        // Devolver la ruta absoluta del archivo
        return $pdf_absolute_path;
    }
}
