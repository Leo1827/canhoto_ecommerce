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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained();
            $table->string('name')->nullable(); // Nombre personalizado de la suscripción
            $table->string('stripe_id')->nullable(); // ID en Stripe
            $table->string('stripe_status')->nullable(); // active, trialing, cancelled, etc.
            $table->string('stripe_price')->nullable(); // ID del precio en Stripe
            $table->timestamp('trial_ends_at')->nullable(); // Fin del periodo de prueba
            $table->timestamp('ends_at')->nullable(); // Fin de la suscripción
            $table->integer('quantity')->default(1); // Cantidad (normalmente 1)
            $table->timestamps(); // created_at y updated_at

            // Índices para mejorar búsquedas
            $table->index(['user_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
