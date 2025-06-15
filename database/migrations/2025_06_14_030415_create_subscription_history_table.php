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
        Schema::create('subscription_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained();
            $table->string('status'); // created, renewed, cancelled, expired, etc.
            $table->text('description')->nullable(); // Descripción del evento
            $table->timestamp('subscribed_at')->useCurrent(); // Fecha del evento
            $table->timestamps(); // created_at y updated_at
            
            // Índices para mejorar búsquedas
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_history');
    }
};
