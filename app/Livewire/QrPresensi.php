<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\SesiPresensi;
use Illuminate\Support\Str;
use Livewire\Component;

class QrPresensi extends Component
{
    public $kelasId;

    public $mataPelajaran;

    public ?SesiPresensi $sesiAktif = null;

    public int $durasiExpired = 30; // detik

    public function mount($kelasId)
    {
        $this->kelasId = $kelasId;
        $kelas = Kelas::find($kelasId);
        if ($kelas) {
            $this->durasiExpired = $kelas->durasi_qr_detik ?? 30;
        }
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
