<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class UpdateStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchasedProducts;

    /**
     * Crear una nueva instancia del job.
     */
    public function __construct($purchasedProducts)
    {
        $this->purchasedProducts = $purchasedProducts;
    }

    /**
     * Ejecutar el job.
     */
    public function handle()
    {
        foreach ($this->purchasedProducts as $productData) {
            $product = Product::find($productData['id']);

            if ($product) {
                $product->stock -= $productData['quantity'];
                $product->save();

                Log::info("Stock actualizado: {$product->name} - Nuevo stock: {$product->stock}");
            } else {
                Log::warning("Producto no encontrado: ID {$productData['id']}");
            }
        }
    }
}
