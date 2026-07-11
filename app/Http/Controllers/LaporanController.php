<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\OrangTuaSiswa;
use App\Models\SiswaKelas;

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

        return view('laporan.show', compact('laporan'));
    }
}
