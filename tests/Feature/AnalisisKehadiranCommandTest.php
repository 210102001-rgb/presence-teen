<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AnalisisKehadiranCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_analisis_kehadiran_command_runs_successfully(): void
    {
        // Mocking the AI Service response
        Http::fake([
            'messages' => Http::response([
                'content' => [
                    [
                        'text' => 'Mocked AI Analysis: Siswa ini memiliki tingkat kehadiran aman.',
                    ],
                ],
            ], 200),
        ]);

        $guru = User::factory()->create(['role' => 'guru']);
        $siswa = User::factory()->create(['role' => 'siswa']);

        $kelas = Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Biologi',
        ]);

        SiswaKelas::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id,
        ]);

        // Run command
        $this->artisan('app:analisis-kehadiran')
            ->assertExitCode(0);

        // Verify analysis was saved in database
        $this->assertDatabaseHas('laporan_ais', [
            'siswa_id' => $siswa->id,
            'level_peringatan' => 'aman',
            'hasil_analisis' => 'Mocked AI Analysis: Siswa ini memiliki tingkat kehadiran aman.',
        ]);
    }
}
