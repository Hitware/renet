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
        Schema::create('historial_navegacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piloto_id')->constrained('pilotos')->onDelete('cascade');
            $table->foreignId('embarcacion_id')->constrained('embarcaciones')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('cargo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index('piloto_id');
            $table->index('embarcacion_id');
            $table->index('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_navegacion');
    }
};
