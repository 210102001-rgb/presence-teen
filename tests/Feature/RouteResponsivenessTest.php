<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteResponsivenessTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswa;

    protected User $guru;

    protected User $ortu;

    protected Kelas $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic users & roles
        $this->guru = User::factory()->create(['role' => 'guru', 'name' => 'Guru Test']);
        $this->siswa = User::factory()->create(['role' => 'siswa', 'name' => 'Siswa Test']);
        $this->ortu = User::factory()->create(['role' => 'orang_tua', 'name' => 'Ortu Test']);

        // Create kelas
        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'guru_id' => $this->guru->id,
            'mata_pelajaran' => 'Mathematics',
            'tahun_ajaran' => '2026/2027',
            'batas_terlambat_menit' => 15,
            'durasi_qr_detik' => 15,
        ]);

        // Connect siswa to kelas
        SiswaKelas::create([
            'siswa_id' => $this->siswa->id,
            'kelas_id' => $this->kelas->id,
        ]);

        // Connect parent to student
        $this->ortu->anak()->attach($this->siswa->id);

        // Add some dummy records to prevent empty loops crashing
        Tugas::create([
            'kelas_id' => $this->kelas->id,
            'guru_id' => $this->guru->id,
            'judul' => 'Tugas Matematika',
            'deskripsi' => 'Kerjakan halaman 10',
            'deadline' => now()->addDays(2),
        ]);

        Materi::create([
            'guru_id' => $this->guru->id,
            'judul' => 'Bab 1 Aljabar',
            'materi_asli' => 'Isi materi aljabar linear dan kalkulus',
        ]);
    }

    public function test_siswa_routes()
    {
        $this->actingAs($this->siswa);

        $routes = [
            'dashboard' => 302, // redirects to dashboard.siswa
            'dashboard.siswa' => 200,
            'presensi.riwayat' => 200,
            'presensi.scan' => 200,
            'tugas.index' => 200,
            'materi.index' => 200,
            'pengumuman.index' => 200,
            'prediksi.index' => 200,
            'motivasi.index' => 200,
            'aktivitas.index' => 200,
            'profile.edit' => 200,
        ];

        foreach ($routes as $route => $status) {
            $response = $this->get(route($route));
            if ($response->status() !== $status) {
                dump("Siswa Route {$route} failed: expected {$status}, got ".$response->status().'. Content: '.substr($response->content(), 0, 500));
            }
            $response->assertStatus($status);
        }
    }

    public function test_guru_routes()
    {
        $this->actingAs($this->guru);

        $routes = [
            'dashboard' => 302, // redirects to dashboard.guru
            'dashboard.guru' => 200,
            'presensi.guru' => 200,
            'presensi.manual' => 200,
            'guru.jadwal' => 200,
            'guru.kelas' => 200,
            'guru.kelas_siswa' => 200,
            'tugas.index' => 200,
            'tugas.create' => 200,
            'materi.index' => 200,
            'materi.create' => 200,
            'profile.edit' => 200,
        ];

        foreach ($routes as $route => $status) {
            $response = $this->get(route($route));
            if ($response->status() !== $status) {
                dump("Guru Route {$route} failed: expected {$status}, got ".$response->status().'. Content: '.substr($response->content(), 0, 500));
            }
            $response->assertStatus($status);
        }
    }

    public function test_orang_tua_routes()
    {
        $this->actingAs($this->ortu);

        $routes = [
            'dashboard' => 302, // redirects to dashboard.orang_tua
            'dashboard.orang_tua' => 200,
            'presensi.riwayat' => 200,
            'pengumuman.index' => 200,
            'prediksi.index' => 200,
            'motivasi.index' => 200,
            'aktivitas.index' => 200,
            'laporan.index' => 200,
            'profile.edit' => 200,
        ];

        foreach ($routes as $route => $status) {
            $response = $this->get(route($route));
            if ($response->status() !== $status) {
                dump("Orang Tua Route {$route} failed: expected {$status}, got ".$response->status().'. Content: '.substr($response->content(), 0, 500));
            }
            $response->assertStatus($status);
        }
    }
}
