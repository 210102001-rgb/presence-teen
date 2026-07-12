<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\OrangTuaSiswa;
use App\Models\PengumpulanTugas;
use App\Models\Pengumuman;
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
        // 1. Guru
        $guru = User::factory()->create([
            'name' => 'Budi Sudarsono, S.Pd.',
            'email' => 'guru@presensi.test',
            'role' => 'guru',
        ]);

        // 2. Siswa (Anak Pertama)
        $siswa1 = User::factory()->create([
            'name' => 'Ahmad Rizky Pratama',
            'email' => 'siswa@presensi.test',
            'role' => 'siswa',
            'nis' => '123456',
        ]);

        // 3. Siswa (Anak Kedua)
        $siswa2 = User::factory()->create([
            'name' => 'Clarissa Putri',
            'email' => 'siswa2@presensi.test',
            'role' => 'siswa',
            'nis' => '654321',
        ]);

        // 4. Orang Tua
        $ortu = User::factory()->create([
            'name' => 'Hendra Pratama',
            'email' => 'ortu@presensi.test',
            'role' => 'orang_tua',
        ]);

        // 5. Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Matematika',
            'batas_terlambat_menit' => 15,
            'durasi_qr_detik' => 30,
            'kirim_notifikasi_otomatis' => true,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'XII IPA 2',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Fisika',
            'batas_terlambat_menit' => 15,
            'durasi_qr_detik' => 30,
            'kirim_notifikasi_otomatis' => true,
        ]);

        // 6. Link Siswa ke Kelas
        SiswaKelas::create([
            'siswa_id' => $siswa1->id,
            'kelas_id' => $kelas1->id,
        ]);

        SiswaKelas::create([
            'siswa_id' => $siswa2->id,
            'kelas_id' => $kelas2->id,
        ]);

        // 7. Link Orang Tua ke Siswa (Hendra memiliki 2 anak)
        OrangTuaSiswa::create([
            'orang_tua_id' => $ortu->id,
            'siswa_id' => $siswa1->id,
        ]);

        OrangTuaSiswa::create([
            'orang_tua_id' => $ortu->id,
            'siswa_id' => $siswa2->id,
        ]);

        // 8. Sesi Presensi & Presensi Dummy (Anak 1)
        for ($i = 1; $i <= 15; $i++) {
            $sesi = SesiPresensi::create([
                'kelas_id' => $kelas1->id,
                'guru_id' => $guru->id,
                'mata_pelajaran' => 'Matematika',
                'qr_token' => Str::random(10),
                'qr_expired_at' => now()->addHour(),
                'created_at' => now()->subDays(16 - $i),
            ]);

            // Tentukan status acak untuk keragaman data
            $status = 'hadir';
            if ($i === 5) {
                $status = 'telat';
            } elseif ($i === 9) {
                $status = 'sakit';
            } elseif ($i === 12) {
                $status = 'izin';
            }

            Presensi::create([
                'sesi_presensi_id' => $sesi->id,
                'siswa_id' => $siswa1->id,
                'waktu_absen' => now()->subDays(16 - $i)->addMinutes(rand(1, 10)),
                'status' => $status,
            ]);
        }

        // Sesi Presensi & Presensi Dummy (Anak 2)
        for ($i = 1; $i <= 15; $i++) {
            $sesi = SesiPresensi::create([
                'kelas_id' => $kelas2->id,
                'guru_id' => $guru->id,
                'mata_pelajaran' => 'Fisika',
                'qr_token' => Str::random(10),
                'qr_expired_at' => now()->addHour(),
                'created_at' => now()->subDays(16 - $i),
            ]);

            $status = 'hadir';
            if ($i === 3) {
                $status = 'telat';
            } elseif ($i === 7) {
                $status = 'alpha';
            }

            Presensi::create([
                'sesi_presensi_id' => $sesi->id,
                'siswa_id' => $siswa2->id,
                'waktu_absen' => now()->subDays(16 - $i)->addMinutes(rand(1, 10)),
                'status' => $status,
            ]);
        }

        // 9. Tugas Dummy (Kelas 1 & Kelas 2)
        $tugas1 = Tugas::create([
            'kelas_id' => $kelas1->id,
            'guru_id' => $guru->id,
            'judul' => 'Tugas Matematika - Limit Fungsi',
            'deskripsi' => 'Kerjakan latihan soal halaman 45.',
            'deadline' => now()->addDays(2),
        ]);

        $tugas2 = Tugas::create([
            'kelas_id' => $kelas1->id,
            'guru_id' => $guru->id,
            'judul' => 'Tugas Matematika - Turunan Aljabar',
            'deskripsi' => 'Kerjakan latihan soal halaman 52 nomor 1-5.',
            'deadline' => now()->addDays(5),
        ]);

        $tugas3 = Tugas::create([
            'kelas_id' => $kelas2->id,
            'guru_id' => $guru->id,
            'judul' => 'Tugas Fisika - Termodinamika',
            'deskripsi' => 'Rangkum materi hukum termodinamika I dan II.',
            'deadline' => now()->addDays(3),
        ]);

        // 10. Pengumpulan Tugas
        PengumpulanTugas::create([
            'tugas_id' => $tugas1->id,
            'siswa_id' => $siswa1->id,
            'status' => 'sudah',
            'nilai' => 90,
            'file_path' => 'tugas/dummy.pdf',
        ]);

        PengumpulanTugas::create([
            'tugas_id' => $tugas3->id,
            'siswa_id' => $siswa2->id,
            'status' => 'sudah',
            'nilai' => 85,
            'file_path' => 'tugas/dummy_fisika.pdf',
        ]);

        // 11. Laporan AI
        LaporanAi::create([
            'siswa_id' => $siswa1->id,
            'periode' => 'Minggu ke-1 Juli 2026',
            'level_peringatan' => 'aman',
            'hasil_analisis' => 'Ahmad Rizky Pratama menunjukkan konsistensi belajar yang luar biasa. Kehadiran sangat baik (di atas 90%), dan pengerjaan tugas matematika diselesaikan dengan performa tinggi.',
        ]);

        LaporanAi::create([
            'siswa_id' => $siswa2->id,
            'periode' => 'Minggu ke-1 Juli 2026',
            'level_peringatan' => 'perhatian',
            'hasil_analisis' => 'Clarissa Putri menunjukkan performa belajar yang stabil, namun terdapat 1 catatan alpha (tidak hadir tanpa keterangan). Disarankan orang tua berdiskusi dengan anak untuk meminimalkan absen kelas.',
        ]);

        // 12. Pengumuman
        Pengumuman::create([
            'judul' => 'Jadwal Ujian Akhir Semester Ganjil 2026/2027',
            'kategori' => 'Akademik',
            'prioritas' => 'Penting',
            'konten' => 'Berikut adalah jadwal lengkap untuk pelaksanaan Ujian Akhir Semester (UAS) Ganjil. Siswa diwajibkan membawa kartu peserta ujian dan hadir 15 menit sebelum waktu yang ditentukan.',
        ]);

        Pengumuman::create([
            'judul' => 'Pembaruan Sistem Pembayaran Uang Sekolah',
            'kategori' => 'Administrasi',
            'prioritas' => 'Sedang',
            'konten' => 'Mulai bulan depan, sistem pembayaran SPP akan beralih ke platform baru yang terintegrasi. Pastikan Anda telah melakukan verifikasi akun melalui email yang telah dikirimkan.',
        ]);

        Pengumuman::create([
            'judul' => 'Kegiatan Ekstrakurikuler Akhir Pekan',
            'kategori' => 'Kesiswaan',
            'prioritas' => 'Informasi',
            'konten' => 'Diberitahukan bahwa seluruh kegiatan ekstrakurikuler pada hari Sabtu besok akan ditiadakan karena adanya pemeliharaan fasilitas olahraga di lingkungan sekolah.',
        ]);
    }
}
