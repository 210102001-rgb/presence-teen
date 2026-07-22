<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_can_export_siswa(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);
        Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Biologi',
        ]);

        $response = $this->actingAs($guru)
            ->get(route('guru.kelas_siswa.export'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
