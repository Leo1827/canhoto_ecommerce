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
        Schema::create('stripe_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');

            $table->string('session_id')->unique(); // ID del checkout de Stripe
            $table->string('payment_intent')->nullable(); // Intento de pago
            $table->string('payer_email')->nullable(); // correo del comprador
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10);
            $table->string('status'); // Ej: paid, pending, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_orders');
    }
};
