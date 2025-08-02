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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Usuario que hizo el pedido
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Dirección de envío usada en este pedido
            $table->foreignId('user_address_id')->nullable()->constrained('user_addresses')->nullOnDelete();

            $table->text('user_comment')->nullable();

            // Estado de la orden
            $table->string('status')->default('pending'); // pending, paid, cancelled

            // Totales
            $table->decimal('subtotal', 10, 2); // Suma de los ítems sin descuentos/imp
            $table->decimal('shipping_cost', 10, 2)->default(0); // Costo de envío
            $table->decimal('tax', 10, 2)->default(0); // Impuesto (si aplica)
            $table->decimal('total', 10, 2); // Total final

            // Métodos de pago
            $table->foreignId('currency_id')->constrained('currencies'); // USD, EUR, etc.
            $table->string('payment_method')->nullable(); // paypal, stripe, etc.
            $table->string('payment_status')->default('pending'); // paid, pending, failed, refunded

            // Fechas adicionales
            $table->timestamp('paid_at')->nullable(); // Fecha de pago (si aplica)
            $table->timestamp('cancelled_at')->nullable(); // Fecha de cancelación (si aplica)
            $table->timestamp('shipped_at')->nullable(); // Fecha de envío (si aplica)

            $table->timestamps(); // created_at y updated_at
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
