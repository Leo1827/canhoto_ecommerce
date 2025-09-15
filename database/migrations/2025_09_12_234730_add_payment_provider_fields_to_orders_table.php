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
            $table->decimal('payment_provider_fee', 10, 2)->nullable();
            $table->decimal('payment_provider_tax', 10, 2)->nullable();
            $table->string('payment_provider_id')->nullable();
            $table->json('payment_provider_raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn(['payment_provider_fee', 'payment_provider_tax', 'payment_provider_id', 'payment_provider_raw']);
        });
    }
};
