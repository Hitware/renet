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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('tipo_documento', ['CC', 'CE', 'PAS', 'NIT'])->nullable()->after('name');
            $table->string('documento')->nullable()->after('tipo_documento');
            $table->string('telefono')->nullable()->after('documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'documento', 'telefono']);
        });
    }
};
