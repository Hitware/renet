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
        Schema::table('embarcacion_imagenes', function (Blueprint $table) {
            $table->string('lado', 50)->nullable()->after('ruta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('embarcacion_imagenes', function (Blueprint $table) {
            $table->dropColumn('lado');
        });
    }
};
