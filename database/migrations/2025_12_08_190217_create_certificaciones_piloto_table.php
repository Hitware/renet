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
        Schema::create('certificaciones_piloto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piloto_id')->constrained('pilotos')->onDelete('cascade');
            $table->string('tipo_certificacion');
            $table->string('numero_certificado', 100)->nullable();
            $table->string('institucion_emisora');
            $table->date('fecha_expedicion');
            $table->date('fecha_vencimiento');
            $table->string('documento_ruta')->nullable();
            $table->timestamps();
            
            $table->index('piloto_id');
            $table->index('fecha_vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificaciones_piloto');
    }
};
