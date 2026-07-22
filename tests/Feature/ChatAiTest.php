<?php

namespace Tests\Feature;

use App\Livewire\ChatAi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ChatAiTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_ai_sends_message_and_receives_reply_successfully(): void
    {
        Http::fake([
            'messages' => Http::response([
                'content' => [
                    [
                        'text' => 'Halo! Ini adalah jawaban dari Claude AI.',
                    ],
                ],
            ], 200),
        ]);

        $siswa = User::factory()->create(['role' => 'siswa']);

        Livewire::actingAs($siswa)
            ->test(ChatAi::class)
            ->set('newMessage', 'Bagaimana kehadiran saya pekan ini?')
            ->call('sendMessage')
            ->assertSet('newMessage', '')
            ->assertSee('Halo! Ini adalah jawaban dari Claude AI.');
    }
}
