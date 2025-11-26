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
        Schema::create('documentos_embarcacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('embarcacion_id')->constrained('embarcaciones')->onDelete('cascade');
            $table->enum('tipo_documento', [
                'matricula',
                'certificado_navegacion',
                'poliza_accidentes',
                'poliza_pandi',
                'resolucion_dimar'
            ]);
            $table->string('numero_documento');
            $table->string('entidad_emisora');
            $table->date('fecha_expedicion');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('aseguradora')->nullable();
            $table->decimal('monto_asegurado', 15, 2)->nullable();
            $table->integer('pasajeros_cubiertos')->nullable();
            $table->string('archivo_path')->nullable();
            $table->enum('estado', ['vigente', 'por_vencer', 'vencido'])->default('vigente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['embarcacion_id', 'tipo_documento']);
            $table->index('estado');
            $table->index('fecha_vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_embarcacion');
    }
};
