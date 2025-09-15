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
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->decimal('payment_provider_total', 10, 2)->nullable()
                  ->after('payment_provider_tax'); // Total exacto cobrado por PayPal
            $table->string('payment_provider_currency', 10)->nullable()
                  ->after('payment_provider_total'); // Moneda exacta de PayPal (USD, EUR, etc.)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_provider_total', 'payment_provider_currency']);
        });
    }
};
