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
        Schema::create('pilotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('tipo_documento', ['CC', 'CE', 'PAS']);
            $table->string('numero_documento', 50)->unique();
            $table->date('fecha_nacimiento');
            $table->string('telefono', 20);
            $table->string('email')->unique();
            $table->text('direccion');
            $table->string('foto_perfil')->nullable();
            $table->string('licencia_numero', 100)->unique();
            $table->enum('licencia_tipo', ['Capitán', 'Patrón', 'Marinero', 'Otro']);
            $table->date('licencia_fecha_expedicion');
            $table->date('licencia_fecha_vencimiento');
            $table->integer('anos_experiencia')->default(0);
            $table->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $table->string('codigo_qr')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('empresa_id');
            $table->index('estado');
            $table->index('licencia_fecha_vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilotos');
    }
};
