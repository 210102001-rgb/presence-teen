<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MateriControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ringkas_materi_using_ai_runs_successfully(): void
    {
        Http::fake([
            'messages' => Http::response([
                'content' => [
                    [
                        'text' => 'Ringkasan AI: Poin penting 1, Poin penting 2.',
                    ],
                ],
            ], 200),
        ]);

        $guru = User::factory()->create(['role' => 'guru']);
        $materi = Materi::create([
            'guru_id' => $guru->id,
            'judul' => 'Materi Biologi Sel',
            'deskripsi' => 'Pengenalan sel',
            'materi_asli' => 'Teks materi biologi sel yang sangat panjang tentang mitokondria.',
        ]);

        $response = $this->actingAs($guru)
            ->post(route('materi.ringkas', $materi));

        $response->assertRedirect(route('materi.show', $materi));

        $this->assertDatabaseHas('materis', [
            'id' => $materi->id,
            'ringkasan_ai' => 'Ringkasan AI: Poin penting 1, Poin penting 2.',
        ]);
    }
}
