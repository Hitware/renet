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
        Schema::create('embarcaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('matricula')->unique();
            $table->string('nombre');
            $table->enum('tipo', ['motonave_pasaje', 'carga', 'pesquera', 'recreativa'])->default('motonave_pasaje');
            $table->integer('capacidad_pasajeros')->nullable();
            $table->decimal('eslora', 8, 2)->nullable();
            $table->decimal('manga', 8, 2)->nullable();
            $table->decimal('tonelaje', 8, 2)->nullable();
            $table->year('ano_construccion')->nullable();
            $table->string('material_casco')->nullable();
            $table->string('motor_marca')->nullable();
            $table->string('motor_modelo')->nullable();
            $table->integer('motor_potencia')->nullable();
            $table->string('codigo_qr')->unique()->nullable();
            $table->enum('estado', ['disponible', 'no_disponible', 'mantenimiento', 'suspendida'])->default('no_disponible');
            $table->text('observaciones')->nullable();
            $table->timestamp('ultima_verificacion')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('estado');
            $table->index('codigo_qr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embarcaciones');
    }
};
