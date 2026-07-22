<?php

namespace App\Notifications;

use App\Models\Pengumuman;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengumumanBaru extends Notification
{
    use Queueable;

    public function __construct(public Pengumuman $pengumuman) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'pengumuman',
            'judul' => $this->pengumuman->judul,
            'kategori' => $this->pengumuman->kategori,
            'prioritas' => $this->pengumuman->prioritas,
            'message' => "Pengumuman Baru: {$this->pengumuman->judul} ({$this->pengumuman->kategori})",
        ];
    }
}
