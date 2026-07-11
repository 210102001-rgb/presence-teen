<?php

namespace App\Notifications;

use App\Models\Presensi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PresensiTercatat extends Notification
{
    use Queueable;

    public function __construct(public Presensi $presensi) {}

    public function via($notifiable)
    {
        return ['mail', 'database']; // database dulu buat notif in-app, mail nyusul
    }

    public function toMail($notifiable)
    {
        $siswa = $this->presensi->siswa;
        $sesi = $this->presensi->sesi;

        return (new MailMessage)
            ->subject('Info Kehadiran Anak Anda')
            ->line("{$siswa->name} tercatat {$this->presensi->status} pada mata pelajaran {$sesi->mata_pelajaran}.")
            ->line('Waktu: '.$this->presensi->waktu_absen->format('d M Y H:i'));
    }

    public function toArray($notifiable)
    {
        return [
            'siswa' => $this->presensi->siswa->name,
            'status' => $this->presensi->status,
            'mata_pelajaran' => $this->presensi->sesi->mata_pelajaran,
        ];
    }
}
