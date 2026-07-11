<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\OrangTuaSiswa;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'batas_terlambat_menit' => 15,
            'durasi_qr_detik' => 30,
            'kirim_notifikasi_otomatis' => true,
        ]);

        SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
        ]);

        OrangTuaSiswa::create([
            'orang_tua_id' => $ortu->id,
            'siswa_id' => $siswa->id,
        ]);

        // Tambah Sesi Presensi & Presensi Dummy
        for ($i = 1; $i <= 10; $i++) {
            $sesi = SesiPresensi::create([
                'kelas_id' => $kelas->id,
                'guru_id' => $guru->id,
                'mata_pelajaran' => 'Matematika',
                'qr_token' => Str::random(10),
                'qr_expired_at' => now()->addHour(),
                'created_at' => now()->subDays(11 - $i),
            ]);

            Presensi::create([
                'sesi_presensi_id' => $sesi->id,
                'siswa_id' => $siswa->id,
                'waktu_absen' => now()->subDays(11 - $i)->addMinutes(rand(1, 10)),
                'status' => $i === 5 ? 'telat' : 'hadir',
            ]);
        }

        // Tambah Tugas Dummy
        $tugas1 = Tugas::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $guru->id,
            'judul' => 'Tugas Matematika - Limit Fungsi',
            'deskripsi' => 'Kerjakan latihan soal halaman 45.',
            'deadline' => now()->addDays(2),
        ]);

        $tugas2 = Tugas::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $guru->id,
            'judul' => 'Tugas Matematika - Turunan Aljabar',
            'deskripsi' => 'Kerjakan latihan soal halaman 52 nomor 1-5.',
            'deadline' => now()->addDays(5),
        ]);

        // Tambah Pengumpulan Tugas Dummy
        PengumpulanTugas::create([
            'tugas_id' => $tugas1->id,
            'siswa_id' => $siswa->id,
            'status' => 'sudah',
            'nilai' => 90,
            'file_path' => 'tugas/dummy.pdf',
        ]);

        // Tambah Laporan AI Dummy
        LaporanAi::create([
            'siswa_id' => $siswa->id,
            'periode' => 'Minggu ke-1 Juli 2026',
            'level_peringatan' => 'aman',
            'hasil_analisis' => 'Siswa menunjukkan antusiasme belajar yang sangat tinggi. Kehadiran tercatat 100% dan seluruh tugas dikumpulkan tepat waktu dengan nilai yang memuaskan.',
        ]);
    }
}
