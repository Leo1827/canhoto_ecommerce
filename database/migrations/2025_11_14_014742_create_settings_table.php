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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Información general
            $table->string('site_name')->nullable();       // Nombre de la tienda
            $table->string('logo')->nullable();            // Ruta del logo
            $table->string('favicon')->nullable();         // Ruta del ícono del navegador

            // Información de contacto
            $table->string('email_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();

            // Preferencias del sistema
            $table->boolean('modo_oscuro')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
