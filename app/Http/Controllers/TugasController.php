<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\OrangTuaSiswa;
use App\Models\PengumpulanTugas;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $tugas = Tugas::whereIn('kelas_id', $kelasIds)->with('kelas')->latest()->get();
        } elseif ($user->role === 'siswa') {
            $kelasIds = SiswaKelas::where('siswa_id', $user->id)->pluck('kelas_id');
            $tugas = Tugas::whereIn('kelas_id', $kelasIds)->with('kelas', 'pengumpulan')->latest()->get();
        } else {
            // orang_tua
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            $kelasIds = SiswaKelas::whereIn('siswa_id', $siswaIds)->pluck('kelas_id');
            $tugas = Tugas::whereIn('kelas_id', $kelasIds)->with('kelas', 'pengumpulan')->latest()->get();
        }

        return view('tugas.index', compact('tugas'));
    }

    public function create()
    {
        $kelas = Kelas::where('guru_id', auth()->id())->get();

        return view('tugas.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        Tugas::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => auth()->id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Tugas $tugas)
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            abort_if($tugas->guru_id !== $user->id, 403);
        } elseif ($user->role === 'siswa') {
            $kelasIds = SiswaKelas::where('siswa_id', $user->id)->pluck('kelas_id');
            abort_if(! $kelasIds->contains($tugas->kelas_id), 403);
        } else {
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            $kelasIds = SiswaKelas::whereIn('siswa_id', $siswaIds)->pluck('kelas_id');
            abort_if(! $kelasIds->contains($tugas->kelas_id), 403);
        }

        $tugas->load('kelas', 'pengumpulan.siswa');

        return view('tugas.show', compact('tugas'));
    }

    public function edit(Tugas $tugas)
    {
        abort_if($tugas->guru_id !== auth()->id(), 403);
        $kelas = Kelas::where('guru_id', auth()->id())->get();

        return view('tugas.edit', compact('tugas', 'kelas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        abort_if($tugas->guru_id !== auth()->id(), 403);
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $tugas->update($request->only('kelas_id', 'judul', 'deskripsi', 'deadline'));

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        abort_if($tugas->guru_id !== auth()->id(), 403);
        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function kumpul(Request $request, Tugas $tugas)
    {
        $request->validate([
            'file' => 'nullable|file|max:10240',
        ]);

        $data = [
            'tugas_id' => $tugas->id,
            'siswa_id' => auth()->id(),
            'status' => 'sudah',
            'waktu_kumpul' => now(),
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('tugas_uploads', 'public');
        }

        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => auth()->id()],
            $data
        );

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
