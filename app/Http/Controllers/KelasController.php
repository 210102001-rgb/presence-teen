<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('guru_id', auth()->id())
            ->withCount('siswa')
            ->with('waliKelas')
            ->orderBy('nama_kelas')
            ->get();

        return view('guru.kelas', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'mata_pelajaran' => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'guru_id' => auth()->id(),
            'mata_pelajaran' => $request->mata_pelajaran,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('guru.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kelas)
    {
        abort_if($kelas->guru_id !== auth()->id(), 403);

        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'mata_pelajaran' => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        $kelas->update($request->only('nama_kelas', 'mata_pelajaran', 'tahun_ajaran'));

        return redirect()->route('guru.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        abort_if($kelas->guru_id !== auth()->id(), 403);
        $kelas->delete();

        return redirect()->route('guru.kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    public function siswa()
    {
        $kelas = Kelas::with('siswa')->where('guru_id', auth()->id())->get();
        $kelasIds = $kelas->pluck('id');

        // Batch: total sesi per kelas (1 query)
        $totalSesiPerKelas = SesiPresensi::whereIn('kelas_id', $kelasIds)
            ->selectRaw('kelas_id, COUNT(*) as total')
            ->groupBy('kelas_id')
            ->pluck('total', 'kelas_id');

        // Batch: hadir+telat per siswa per kelas (1 query dengan join)
        $hadirPerSiswa = Presensi::whereIn('status', ['hadir', 'telat'])
            ->whereHas('sesiPresensi', fn ($q) => $q->whereIn('kelas_id', $kelasIds))
            ->join('sesi_presensi', 'presensi.sesi_presensi_id', '=', 'sesi_presensi.id')
            ->selectRaw('presensi.siswa_id, sesi_presensi.kelas_id, COUNT(*) as total')
            ->groupBy('presensi.siswa_id', 'sesi_presensi.kelas_id')
            ->pluck('total', fn ($r) => $r->siswa_id.'_'.$r->kelas_id);

        // Flatten: semua siswa dengan kelas & stats
        $semuaSiswa = collect();
        foreach ($kelas as $k) {
            $total = $totalSesiPerKelas->get($k->id, 0);
            foreach ($k->siswa as $s) {
                $hadir = $hadirPerSiswa->get($s->id.'_'.$k->id, 0);
                $rate = $total > 0 ? round($hadir / $total * 100) : 0;
                $semuaSiswa->push([
                    'siswa' => $s,
                    'kelas' => $k,
                    'rate' => $rate,
                ]);
            }
        }

        return view('guru.kelas_siswa', compact('kelas', 'semuaSiswa'));
    }
}
