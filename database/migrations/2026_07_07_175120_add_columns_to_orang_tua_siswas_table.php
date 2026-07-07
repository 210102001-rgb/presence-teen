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
        Schema::table('orang_tua_siswas', function (Blueprint $table) {
            $table->foreignId('orang_tua_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['orang_tua_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::table('orang_tua_siswas', function (Blueprint $table) {
            $table->dropForeign(['orang_tua_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['orang_tua_id', 'siswa_id']);
        });
    }
};
