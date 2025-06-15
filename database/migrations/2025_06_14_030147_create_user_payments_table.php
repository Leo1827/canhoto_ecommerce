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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_id'); // ID del proveedor de pago (Stripe, PayPal, etc.)
            $table->string('method'); // paypal, card, mbway, multibanco
            $table->decimal('amount', 10, 2); // Monto con 2 decimales
            $table->foreignId('currency_id')->constrained();
            $table->string('status'); // completed, pending, failed, refunded
            $table->json('metadata')->nullable(); // Datos adicionales en JSON
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
