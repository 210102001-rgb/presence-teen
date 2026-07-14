<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
            'nama_kelas'   => 'required|string|max:100',
            'mata_pelajaran' => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        Kelas::create([
            'nama_kelas'    => $request->nama_kelas,
            'guru_id'       => auth()->id(),
            'mata_pelajaran'=> $request->mata_pelajaran,
            'tahun_ajaran'  => $request->tahun_ajaran,
        ]);

        return redirect()->route('guru.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kelas)
    {
        abort_if($kelas->guru_id !== auth()->id(), 403);

        $request->validate([
            'nama_kelas'   => 'required|string|max:100',
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
}
