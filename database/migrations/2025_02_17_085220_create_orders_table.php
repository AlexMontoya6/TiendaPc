<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('restrict');
            $table->string('shipping_name');
            $table->string('shipping_street');
            $table->string('shipping_city');
            $table->string('shipping_postal_code');
            $table->string('shipping_country')->default('España');

            // Método de entrega
            $table->tinyInteger('delivery_option'); // 1: Estándar, 2: Express, 3: Recogida en tienda...

            // Método de pago
            $table->string('payment_method'); // Tarjeta, PayPal, etc.

            // Total del pedido
            $table->integer('total_price');

            // Estado del pedido (Mejor con un `tinyInteger` en vez de `enum`)
            $table->tinyInteger('status')->default(1); // 1: Pendiente, 2: Pagado, 3: Cancelado, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
