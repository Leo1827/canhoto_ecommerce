<?php

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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del método (PayPal, Tarjeta, etc.)
            $table->string('code'); // Código interno (paypal, card, mbway, etc.)
            $table->string('driver')->nullable(); // Driver para procesamiento
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable(); // Configuración específica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
