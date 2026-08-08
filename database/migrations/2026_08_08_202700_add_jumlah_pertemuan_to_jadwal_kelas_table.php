<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->unsignedSmallInteger('jumlah_pertemuan')->default(16)->after('topik');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->dropColumn('jumlah_pertemuan');
        });
    }
};
