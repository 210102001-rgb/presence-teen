<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\OrangTuaSiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $guru = User::factory()->create([
            'name' => 'Guru Satu',
            'email' => 'guru@presensi.test',
            'role' => 'guru',
        ]);

        $siswa = User::factory()->create([
            'name' => 'Siswa Satu',
            'email' => 'siswa@presensi.test',
            'role' => 'siswa',
            'nis' => '123456',
        ]);

        $ortu = User::factory()->create([
            'name' => 'Orang Tua Satu',
            'email' => 'ortu@presensi.test',
            'role' => 'orang_tua',
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Matematika',
        ]);

        SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
        ]);

        OrangTuaSiswa::create([
            'orang_tua_id' => $ortu->id,
            'siswa_id' => $siswa->id,
        ]);
    }
}
