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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Básico, Premium, etc.
            $table->string('stripe_id')->nullable(); // ID en Stripe si aplica
            $table->decimal('price', 10, 2); // Precio mensual/anual
            $table->string('interval')->default('month'); // month o year
            $table->text('features'); // Lista de características separadas por comas
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Para ordenar los planes
            $table->foreignId('currency_id')->constrained('currencies'); // Nueva relación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
