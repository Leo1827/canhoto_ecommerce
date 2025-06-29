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
        Schema::create('paypal_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');

            $table->string('order_id')->unique(); // ID que devuelve PayPal
            $table->string('payer_id');
            $table->string('payer_name')->nullable();
            $table->string('payer_email')->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 10);
            $table->string('status'); // Ej: COMPLETED

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paypal_orders');
    }
};
