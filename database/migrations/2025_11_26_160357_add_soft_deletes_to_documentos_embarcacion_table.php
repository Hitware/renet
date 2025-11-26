<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentos_embarcacion', function (Blueprint $table) {
            $table->string('motivo_reemplazo')->nullable()->after('observaciones');
            $table->unsignedBigInteger('reemplazado_por')->nullable()->after('motivo_reemplazo');
        });
    }

    public function down(): void
    {
        Schema::table('documentos_embarcacion', function (Blueprint $table) {
            $table->dropColumn(['motivo_reemplazo', 'reemplazado_por']);
        });
    }
};
