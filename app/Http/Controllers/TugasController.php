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

        if ($this->isAdmin()) {
            $tugas = Tugas::with('kelas', 'pengumpulan')->latest()->get();
        } elseif ($user->role === 'guru') {
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
        $kelas = ($this->isAdmin() ? Kelas::query() : Kelas::where('guru_id', auth()->id()))->get();

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

        $kelas = Kelas::findOrFail($request->kelas_id);

        Tugas::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => $kelas->guru_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Tugas $tugas)
    {
        $user = auth()->user();

        if ($this->isAdmin()) {
            // super admin bisa melihat semua tugas
        } elseif ($user->role === 'guru') {
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
        if (! $this->isAdmin() && $tugas->guru_id !== auth()->id()) {
            abort(403);
        }
        $kelas = ($this->isAdmin() ? Kelas::query() : Kelas::where('guru_id', auth()->id()))->get();

        return view('tugas.edit', compact('tugas', 'kelas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        if (! $this->isAdmin() && $tugas->guru_id !== auth()->id()) {
            abort(403);
        }
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
        if (! $this->isAdmin() && $tugas->guru_id !== auth()->id()) {
            abort(403);
        }
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

    public function download(PengumpulanTugas $pengumpulanTugas)
    {
        // Check if the logged-in user is the student who submitted or the teacher
        $user = auth()->user();

        if ($this->isAdmin()) {
            // admin dapat mendownload semua pengumpulan
        } elseif ($user->role === 'siswa') {
            // Student can only download their own submission
            abort_if($pengumpulanTugas->siswa_id !== $user->id, 403);
        } elseif ($user->role === 'guru') {
            // Teacher can download from their own classes
            abort_if($pengumpulanTugas->tugas->guru_id !== $user->id, 403);
        } else {
            // Parent can see their children's submissions
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($pengumpulanTugas->siswa_id), 403);
        }

        if (! $pengumpulanTugas->file_path || ! \Storage::disk('public')->exists($pengumpulanTugas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return \Storage::disk('public')->download($pengumpulanTugas->file_path);
    }
}
