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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nit')->unique();
            $table->string('razon_social');
            $table->string('nombre_comercial')->nullable();
            $table->text('direccion');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('representante_legal');
            $table->string('documento_representante');
            $table->enum('estado', ['activa', 'inactiva', 'suspendida'])->default('activa');
            $table->date('fecha_autorizacion_dimar')->nullable();
            $table->string('numero_autorizacion_dimar')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
