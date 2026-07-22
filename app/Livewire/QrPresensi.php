<?php

namespace App\Livewire;

use App\Models\JadwalKelas;
use App\Models\Kelas;
use App\Models\SesiPresensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class QrPresensi extends Component
{
    public $kelasList;

    public $selectedKelasId;

    public $mataPelajaran;

    public $topik;

    public int $durasi = 60; // Sesi berlangsung selama 60 menit secara default

    public ?SesiPresensi $sesiAktif = null;

    public bool $sesiBerhasilDibuat = false;

    public int $durasiExpired = 15; // Selalu 15 detik untuk refresh QR

    public bool $showConfirmAkhiri = false;

    public function mount($kelasId = null, $jadwalId = null)
    {
        $this->kelasList = Kelas::where('guru_id', auth()->id())->get();

        // Check if there is an active session for this teacher
        $this->sesiAktif = SesiPresensi::where('guru_id', auth()->id())
            ->where('is_active', true)
            ->first();

        if ($this->sesiAktif) {
            $this->selectedKelasId = $this->sesiAktif->kelas_id;
            $this->mataPelajaran = $this->sesiAktif->mata_pelajaran;
            $this->topik = $this->sesiAktif->topik;
        } elseif ($jadwalId) {
            $jadwal = JadwalKelas::where('guru_id', auth()->id())->find($jadwalId);
            if ($jadwal) {
                $this->selectedKelasId = $jadwal->kelas_id;
                $this->mataPelajaran = $jadwal->mata_pelajaran;
                $this->topik = $jadwal->topik;
            }
        } elseif ($kelasId) {
            $this->selectedKelasId = $kelasId;
            $kelas = Kelas::find($kelasId);
            if ($kelas) {
                $this->mataPelajaran = $kelas->mata_pelajaran;
            }
        } elseif ($this->kelasList->count() > 0) {
            $this->selectedKelasId = $this->kelasList->first()->id;
            $this->mataPelajaran = $this->kelasList->first()->mata_pelajaran;
        }
    }

    public function updatedSelectedKelasId($value)
    {
        $kelas = Kelas::find($value);
        if ($kelas) {
            $this->mataPelajaran = $kelas->mata_pelajaran;
        }
    }

    public function mulaiSesi()
    {
        $this->validate([
            'selectedKelasId' => 'required|exists:kelas,id',
            'mataPelajaran' => 'required|string|max:100',
            'topik' => 'nullable|string|max:150',
        ]);

        // Close any existing active session first
        $this->durasi = 60; // default 60 menit sesi berjalan

        DB::transaction(function () {
            SesiPresensi::where('guru_id', auth()->id())
                ->where('is_active', true)
                ->update(['is_active' => false]);

            $this->sesiAktif = SesiPresensi::create([
                'kelas_id' => $this->selectedKelasId,
                'guru_id' => auth()->id(),
                'mata_pelajaran' => $this->mataPelajaran,
                'topik' => $this->topik,
                'qr_token' => Str::random(32),
                'qr_expired_at' => now()->addSeconds($this->durasiExpired),
                'is_active' => true,
            ]);
        });

        $this->sesiBerhasilDibuat = true;
    }

    public function showQr()
    {
        $this->sesiBerhasilDibuat = false;
    }

    public function kembaliKeBeranda()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        // load last 5 sessions for history
        $riwayatSesi = SesiPresensi::where('guru_id', auth()->id())
            ->with(['kelas.siswa', 'presensi'])
            ->latest()
            ->take(5)
            ->get();

        // Calculate active stats
        $totalSiswa = 0;
        $hadirCount = 0;
        $belumHadirCount = 0;

        if ($this->sesiAktif) {
            $totalSiswa = $this->sesiAktif->kelas->siswa->count();
            $hadirCount = $this->sesiAktif->presensi()->whereIn('status', ['hadir', 'telat'])->count();
            $belumHadirCount = max(0, $totalSiswa - $hadirCount);
        }

        return view('livewire.qr-presensi', compact(
            'riwayatSesi',
            'totalSiswa',
            'hadirCount',
            'belumHadirCount'
        ));
    }

    public function konfirmasiAkhiri()
    {
        $this->showConfirmAkhiri = true;
    }

    public function batalAkhiri()
    {
        $this->showConfirmAkhiri = false;
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
        $this->sesiBerhasilDibuat = false;
        $this->showConfirmAkhiri = false;
    }
}
