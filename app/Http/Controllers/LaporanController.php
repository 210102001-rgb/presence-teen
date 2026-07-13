<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\OrangTuaSiswa;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');
            $laporans = LaporanAi::whereIn('siswa_id', $siswaIds)->with('siswa')->latest()->get();
        } else {
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            $laporans = LaporanAi::whereIn('siswa_id', $siswaIds)->with('siswa')->latest()->get();
        }

        return view('laporan.index', compact('laporans'));
    }

    public function show(LaporanAi $laporan)
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($laporan->siswa_id), 403);
        } else {
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($laporan->siswa_id), 403);
        }

        $laporan->load('siswa');

        // Hitung tren kehadiran 5 bulan terakhir
        $siswaId = $laporan->siswa_id;
        $userKelasIds = SiswaKelas::where('siswa_id', $siswaId)->pluck('kelas_id');
        $monthlyTrend = collect();
        $currentMonth = Carbon::parse($laporan->created_at);

        for ($i = 4; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $monthLabel = $month->translatedFormat('M');

            $totalSesi = SesiPresensi::whereIn('kelas_id', $userKelasIds)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $totalHadir = Presensi::where('siswa_id', $siswaId)
                ->whereIn('status', ['hadir', 'telat'])
                ->whereMonth('waktu_absen', $month->month)
                ->whereYear('waktu_absen', $month->year)
                ->count();

            $rate = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100) : 100;

            $monthlyTrend->push(['label' => $monthLabel, 'rate' => $rate]);
        }

        // Hitung perubahan % dari bulan lalu
        $currentRate = $monthlyTrend->last()['rate'];
        $previousRate = $monthlyTrend->count() > 1 ? $monthlyTrend->slice(0, -1)->last()['rate'] : $currentRate;
        $rateChange = $currentRate - $previousRate;

        return view('laporan.show', compact('laporan', 'monthlyTrend', 'rateChange'));
    }
}
