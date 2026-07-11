<?php

namespace App\Livewire;

use App\Models\SesiPresensi;
use Illuminate\Support\Str;
use Livewire\Component;

class QrPresensi extends Component
{
    public $kelasId;

    public $mataPelajaran;

    public ?SesiPresensi $sesiAktif = null;

    public int $durasiExpired = 30; // detik, sesuai catatan [ISI SENDIRI]

    public function mount($kelasId)
    {
        $this->kelasId = $kelasId;
    }

    public function mulaiSesi()
    {
        $this->validate([
            'mataPelajaran' => 'required|string|max:100',
        ]);

        $this->sesiAktif = SesiPresensi::create([
            'kelas_id' => $this->kelasId,
            'guru_id' => auth()->id(),
            'mata_pelajaran' => $this->mataPelajaran,
            'qr_token' => Str::random(32),
            'qr_expired_at' => now()->addSeconds($this->durasiExpired),
            'is_active' => true,
        ]);
    }

    // dipanggil otomatis lewat wire:poll di view
    public function refreshToken()
    {
        if (! $this->sesiAktif || ! $this->sesiAktif->is_active) {
            return;
        }

        if ($this->sesiAktif->isExpired()) {
            $this->sesiAktif->update([
                'qr_token' => Str::random(32),
                'qr_expired_at' => now()->addSeconds($this->durasiExpired),
            ]);
            $this->sesiAktif->refresh();
        }
    }

    public function akhiriSesi()
    {
        $this->sesiAktif?->update(['is_active' => false]);
        $this->sesiAktif = null;
    }

    public function render()
    {
        return view('livewire.qr-presensi');
    }
}
