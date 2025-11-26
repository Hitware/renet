<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('embarcacion_id')->constrained('embarcaciones')->onDelete('cascade');
            $table->string('nombre_reportante');
            $table->string('email_reportante')->nullable();
            $table->string('telefono_reportante')->nullable();
            $table->text('descripcion');
            $table->string('imagen')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('estado', ['pendiente', 'revisado', 'resuelto'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
