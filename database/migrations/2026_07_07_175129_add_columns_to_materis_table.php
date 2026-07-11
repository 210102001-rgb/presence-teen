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
        Schema::table('materis', function (Blueprint $table) {
            $table->foreignId('siswa_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->longText('materi_asli');
            $table->longText('ringkasan_ai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['siswa_id', 'judul', 'materi_asli', 'ringkasan_ai']);
        });
    }
};
