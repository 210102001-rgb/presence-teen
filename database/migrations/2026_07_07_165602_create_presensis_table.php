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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_presensi_id');
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('waktu_absen');
            $table->enum('status', ['hadir', 'telat'])->default('hadir');
            $table->timestamps();

            // satu siswa cuma boleh absen sekali per sesi
            $table->unique(['sesi_presensi_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
