<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            ->get()
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

    public function exportSiswa()
    {
        $kelas = Kelas::with(['siswa'])->where('guru_id', auth()->id())->get();
        $kelasIds = $kelas->pluck('id');

        // Ambil data kehadiran per siswa
        $totalSesiPerKelas = SesiPresensi::whereIn('kelas_id', $kelasIds)
            ->selectRaw('kelas_id, COUNT(*) as total')
            ->groupBy('kelas_id')
            ->pluck('total', 'kelas_id');

        $hadirPerSiswa = Presensi::whereIn('status', ['hadir', 'telat'])
            ->whereHas('sesiPresensi', fn($q) => $q->whereIn('kelas_id', $kelasIds))
            ->join('sesi_presensi', 'presensi.sesi_presensi_id', '=', 'sesi_presensi.id')
            ->selectRaw('presensi.siswa_id, sesi_presensi.kelas_id, COUNT(*) as total')
            ->groupBy('presensi.siswa_id', 'sesi_presensi.kelas_id')
            ->get()
            ->pluck('total', fn($r) => $r->siswa_id . '_' . $r->kelas_id);

        $rows = collect();
        foreach ($kelas as $k) {
            $totalSesi = $totalSesiPerKelas->get($k->id, 0);
            foreach ($k->siswa as $s) {
                $hadir  = $hadirPerSiswa->get($s->id . '_' . $k->id, 0);
                $rate   = $totalSesi > 0 ? round($hadir / $totalSesi * 100) : 0;
                $rows->push([
                    'nama'        => $s->name,
                    'nis'         => $s->nis ?? '-',
                    'email'       => $s->email,
                    'kelas'       => $k->nama_kelas,
                    'mapel'       => $k->mata_pelajaran,
                    'total_sesi'  => $totalSesi,
                    'hadir'       => $hadir,
                    'kehadiran'   => $rate . '%',
                    'status'      => $rate > 0 ? 'Aktif' : 'Tidak Aktif',
                ]);
            }
        }

        $filename = 'data-siswa-' . now()->format('Ymd-His') . '.xls';

        // Gunakan HTML table sebagai XLS (dibaca oleh Excel)
        $html = view('guru.exports.siswa_excel', compact('rows', 'kelas'))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }

    public function createSiswa()
    {
        $kelas = Kelas::where('guru_id', auth()->id())->get();
        return view('guru.kelas_siswa_create', compact('kelas'));
    }

    public function tambahSiswa(Request $request)
    {
        $request->validate([
            'kelas_id'   => 'required|exists:kelas,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'nis'        => 'nullable|string|max:20',
            'password'   => 'required|string|min:8',
        ]);

        // Pastikan kelas milik guru yang sedang login
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('guru_id', auth()->id())
            ->firstOrFail();

        // Buat akun siswa baru
        $siswa = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nis'      => $request->nis,
            'password' => bcrypt($request->password),
            'role'     => 'siswa',
        ]);

        // Daftarkan ke kelas
        \App\Models\SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
        ]);

        return redirect()->route('guru.kelas_siswa')
            ->with('success', "Siswa \"{$siswa->name}\" berhasil ditambahkan ke kelas {$kelas->nama_kelas}.");
    }

    public function hapusSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Pastikan kelas milik guru
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('guru_id', auth()->id())
            ->firstOrFail();

        SiswaKelas::where('siswa_id', $request->siswa_id)
            ->where('kelas_id', $kelas->id)
            ->delete();

        return redirect()->route('guru.kelas_siswa')
            ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    public function showImport()
    {
        $kelas = Kelas::where('guru_id', auth()->id())->get();
        return view('guru.kelas_siswa_import', compact('kelas'));
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls',
            'kelas_id'   => 'required|exists:kelas,id',
        ]);

        // Pastikan kelas milik guru
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('guru_id', auth()->id())
            ->firstOrFail();

        $path = $request->file('file_excel')->store('imports', 'local');
        $fullPath = storage_path('app/' . $path);

        try {
            $spreadsheet = IOFactory::load($fullPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return back()->withErrors(['file_excel' => 'File tidak dapat dibaca: ' . $e->getMessage()]);
        } finally {
            // Hapus file temporary
            \Illuminate\Support\Facades\Storage::disk('local')->delete($path);
        }

        // Cari baris header (kolom A = "No", B = "Nama Siswa", dst)
        $headerRow = null;
        foreach ($rows as $rowIndex => $row) {
            $firstCell = strtolower(trim($row['A'] ?? ''));
            if ($firstCell === 'no') {
                $headerRow = $rowIndex;
                break;
            }
        }

        if (!$headerRow) {
            return back()->withErrors(['file_excel' => 'Format file tidak valid. Pastikan menggunakan file hasil export dari sistem ini.']);
        }

        $imported = 0;
        $skipped  = 0;
        $errors   = [];

        // Iterasi baris data (setelah header)
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex <= $headerRow) continue;

            // Hentikan jika baris kosong atau masuk bagian ringkasan
            $noVal   = trim($row['A'] ?? '');
            $namaVal = trim($row['B'] ?? '');
            if ($noVal === '' || $namaVal === '' || !is_numeric($noVal)) break;

            $nama  = $namaVal;
            $nis   = trim($row['C'] ?? '') ?: null;
            $email = trim($row['D'] ?? '');

            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Baris {$rowIndex}: Email tidak valid ({$email}), dilewati.";
                $skipped++;
                continue;
            }

            // Cek apakah user sudah ada
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Buat akun baru
                $user = User::create([
                    'name'     => $nama,
                    'email'    => $email,
                    'nis'      => $nis,
                    'password' => Hash::make('password'),
                    'role'     => 'siswa',
                ]);
            } else {
                // Update nama & NIS jika sudah ada
                $user->update([
                    'name' => $nama,
                    'nis'  => $nis ?? $user->nis,
                ]);
            }

            // Daftarkan ke kelas jika belum
            $sudahDaftar = SiswaKelas::where('siswa_id', $user->id)
                ->where('kelas_id', $kelas->id)
                ->exists();

            if (!$sudahDaftar) {
                SiswaKelas::create([
                    'siswa_id' => $user->id,
                    'kelas_id' => $kelas->id,
                ]);
                $imported++;
            } else {
                $skipped++;
            }
        }

        $message = "Import selesai: {$imported} siswa berhasil ditambahkan.";
        if ($skipped > 0) $message .= " {$skipped} dilewati (sudah terdaftar atau data tidak valid).";

        return redirect()->route('guru.kelas_siswa')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
