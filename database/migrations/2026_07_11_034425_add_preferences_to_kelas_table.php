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
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('batas_terlambat_menit')->default(15);
            $table->integer('durasi_qr_detik')->default(30);
            $table->string('email_pengirim_notifikasi')->nullable();
            $table->boolean('kirim_notifikasi_otomatis')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn([
                'batas_terlambat_menit',
                'durasi_qr_detik',
                'email_pengirim_notifikasi',
                'kirim_notifikasi_otomatis',
            ]);
        });
    }
};
