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
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade'); // Relación con usuarios
            $table->string('name'); // Nombre de la dirección (Ej. "Casa", "Trabajo")
            $table->string('street'); // Calle y número
            $table->string('city'); // Ciudad
            $table->string('postal_code'); // Código postal
            $table->string('country')->default('España'); // País
            $table->boolean('is_default')->default(false); // Dirección por defecto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
