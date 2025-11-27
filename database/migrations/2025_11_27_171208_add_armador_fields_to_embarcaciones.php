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
            $table->string('armador_direccion', 255)->nullable()->after('observaciones');
            $table->string('armador_email', 255)->nullable()->after('armador_direccion');
            $table->string('armador_contacto', 255)->nullable()->after('armador_email');
            $table->string('armador_telefono', 50)->nullable()->after('armador_contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('embarcaciones', function (Blueprint $table) {
            $table->dropColumn(['armador_direccion', 'armador_email', 'armador_contacto', 'armador_telefono']);
        });
    }
};
