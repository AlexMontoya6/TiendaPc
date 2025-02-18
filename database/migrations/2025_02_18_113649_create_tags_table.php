<?php

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear la tabla de etiquetas (tags)
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Crear la tabla pivote productos-etiquetas
        Schema::create('product_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable()->constrained()->onDelete('restrict');
            $table->foreignIdFor(Tag::class)->constrained()->onDelete('restrict');
            $table->timestamp('expires_at')->nullable(); // Fecha de expiración
            $table->boolean('is_active')->default(true); // Estado de la etiqueta
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('tags');
    }
};
