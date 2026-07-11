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
        Schema::table('laporan_ais', function (Blueprint $table) {
            $table->foreignId('siswa_id')->constrained('users')->after('id');
            $table->string('periode')->nullable()->after('siswa_id');
            $table->text('hasil_analisis')->nullable()->after('periode');
            $table->enum('level_peringatan', ['aman', 'perhatian', 'kritis'])->default('aman')->after('hasil_analisis');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_ais', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['siswa_id', 'periode', 'hasil_analisis', 'level_peringatan']);
        });
    }
};
