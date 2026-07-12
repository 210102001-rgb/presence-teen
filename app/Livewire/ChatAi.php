<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatAi extends Component
{
    public $messages = [];

    public $newMessage = '';

    public $isOpen = false;

    public function mount()
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Halo! Saya Asisten AI Presensi-Teen. Ada yang bisa saya bantu terkait kehadiran, tugas, atau perkembangan akademik hari ini?',
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        $userMessage = $this->newMessage;
        $this->messages[] = [
            'role' => 'user',
            'content' => $userMessage,
        ];
        $this->newMessage = '';

        $user = auth()->user();
        $role = $user->role;
        $contextText = '';

        if ($role === 'orang_tua') {
            $contextText = "Anda adalah Asisten AI Presensi-Teen. Anda sedang berbicara dengan orang tua bernama: {$user->name}.\n";
            $anakList = $user->anak()->with('kelasSaya', 'presensiSaya')->get();
            foreach ($anakList as $child) {
                $kelasNama = $child->kelasSaya->first()->nama_kelas ?? 'Tanpa Kelas';
                $hadir = $child->presensiSaya->where('status', 'hadir')->count();
                $telat = $child->presensiSaya->where('status', 'telat')->count();
                $alpha = $child->presensiSaya->where('status', 'alpha')->count();
                $contextText .= "- Anak: {$child->name}, Kelas: {$kelasNama}, Detail Presensi -> Hadir: {$hadir}, Terlambat: {$telat}, Alpha: {$alpha}. Status Akademik: GPA 3.9.\n";
            }
            $contextText .= 'Tolong berikan rekomendasi belajar atau masukan presensi yang spesifik mengenai anak-anak tersebut.';
        } else {
            $contextText = "Anda adalah Asisten AI Presensi-Teen. Anda sedang berbicara dengan siswa bernama: {$user->name}.\n";
            $kelasNama = $user->kelasSaya->first()->nama_kelas ?? 'Tanpa Kelas';
            $hadir = $user->presensiSaya->where('status', 'hadir')->count();
            $telat = $user->presensiSaya->where('status', 'telat')->count();
            $alpha = $user->presensiSaya->where('status', 'alpha')->count();
            $contextText .= "- Kelas: {$kelasNama}, Detail Presensi -> Hadir: {$hadir}, Terlambat: {$telat}, Alpha: {$alpha}.\n";
            $contextText .= 'Berikan rekomendasi belajar atau motivasi presensi yang spesifik untuk siswa ini.';
        }

        $apiMessages = [];
        $apiMessages[] = [
            'role' => 'user',
            'content' => $contextText,
        ];

        foreach ($this->messages as $msg) {
            // Claude API strictly requires alternating user/assistant roles
            if ($msg['role'] === 'user' || $msg['role'] === 'assistant') {
                $apiMessages[] = [
                    'role' => $msg['role'],
                    'content' => $msg['content'],
                ];
            }
        }

        try {
            $response = Http::withOptions([
                'base_uri' => config('services.ai.base_url'),
                'verify' => false,
            ])
                ->withHeaders([
                    'x-api-key' => config('services.ai.api_key'),
                    'anthropic-version' => config('services.ai.version'),
                ])
                ->post('messages', [
                    'model' => config('services.ai.model'),
                    'max_tokens' => 800,
                    'messages' => $apiMessages,
                ]);

            $reply = $response->json('content.0.text');

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $reply ?? 'Maaf, saya sedang mengalami kendala teknis dalam menghubungi server AI.',
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Gagal menghubungi server AI: '.$e->getMessage(),
            ];
        }
    }

    public function selectPrompt($promptText)
    {
        $this->newMessage = $promptText;
        $this->sendMessage();
    }

    public function render()
    {
        return view('livewire.chat-ai');
    }
}
