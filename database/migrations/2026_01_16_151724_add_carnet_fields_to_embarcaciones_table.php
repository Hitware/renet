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
        Schema::table('embarcaciones', function (Blueprint $table) {
            $table->string('distintivo_llamada')->nullable()->after('nombre');
            $table->string('mmsi')->nullable()->after('distintivo_llamada');
            $table->decimal('puntal', 8, 2)->nullable()->after('manga');
            $table->decimal('calado', 8, 2)->nullable()->after('puntal');
            $table->text('numero_motores')->nullable()->after('motor_potencia');
            $table->string('numero_omi')->nullable()->after('codigo_qr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('embarcaciones', function (Blueprint $table) {
            $table->dropColumn([
                'distintivo_llamada',
                'mmsi',
                'puntal',
                'calado',
                'numero_motores',
                'numero_omi'
            ]);
        });
    }
};
