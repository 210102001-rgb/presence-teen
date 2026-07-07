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
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->enum('status', ['belum', 'sudah'])->default('belum');
            $table->timestamp('waktu_kumpul')->nullable();
            $table->unique(['tugas_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->dropForeign(['tugas_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['tugas_id', 'siswa_id', 'file_path', 'status', 'waktu_kumpul']);
        });
    }
};
