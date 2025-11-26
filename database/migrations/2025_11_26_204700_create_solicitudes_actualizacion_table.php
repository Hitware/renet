<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_actualizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos_embarcacion')->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->text('motivo');
            $table->enum('estado', ['pendiente', 'atendida'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_actualizacion');
    }
};
