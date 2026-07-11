<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresensiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_can_update_kelas_settings(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);
        $kelas = Kelas::create([
            'nama_kelas' => 'X RPL 1',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'RPL',
        ]);

        $response = $this->actingAs($guru)
            ->post(route('presensi.guru.settings', $kelas->id), [
                'batas_terlambat_menit' => 20,
                'durasi_qr_detik' => 45,
                'email_pengirim_notifikasi' => 'kelasx@presensi.test',
                'kirim_notifikasi_otomatis' => '1',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('kelas', [
            'id' => $kelas->id,
            'batas_terlambat_menit' => 20,
            'durasi_qr_detik' => 45,
            'email_pengirim_notifikasi' => 'kelasx@presensi.test',
            'kirim_notifikasi_otomatis' => 1,
        ]);
    }
}
