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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // BIGINT (unsigned)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con products
            $table->foreignId('inventory_id')->nullable()->constrained('product_inventories')->nullOnDelete(); // ✅ Opcional
            $table->integer('quantity')->default(1); // INTEGER
            $table->decimal('price_unit', 10, 2); // DECIMAL
            $table->decimal('subtotal', 10, 2); // DECIMAL
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
