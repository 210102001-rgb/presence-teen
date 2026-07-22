<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

        $totalSesiPerKelas = SesiPresensi::whereIn('kelas_id', $kelasIds)
            ->selectRaw('kelas_id, COUNT(*) as total')
            ->groupBy('kelas_id')
            ->pluck('total', 'kelas_id');

        $hadirPerSiswa = Presensi::whereIn('status', ['hadir', 'telat'])
            ->whereHas('sesiPresensi', fn ($q) => $q->whereIn('kelas_id', $kelasIds))
            ->join('sesi_presensi', 'presensi.sesi_presensi_id', '=', 'sesi_presensi.id')
            ->selectRaw('presensi.siswa_id, sesi_presensi.kelas_id, COUNT(*) as total')
            ->groupBy('presensi.siswa_id', 'sesi_presensi.kelas_id')
            ->get()
            ->pluck('total', fn ($r) => $r->siswa_id.'_'.$r->kelas_id);

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Siswa');

        // Header row
        $headers = ['No', 'Nama Siswa', 'NIS', 'Email', 'Kelas', 'Mata Pelajaran', 'Total Sesi', 'Hadir', 'Kehadiran (%)', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        // Style header — hijau
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0E7A3D']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Data rows
        $row = 2;
        $no = 1;
        foreach ($kelas as $k) {
            $totalSesi = $totalSesiPerKelas->get($k->id, 0);
            foreach ($k->siswa as $s) {
                $hadir = $hadirPerSiswa->get($s->id.'_'.$k->id, 0);
                $rate = $totalSesi > 0 ? round($hadir / $totalSesi * 100) : 0;

                $sheet->fromArray([
                    $no++,
                    $s->name,
                    $s->nis ?? '-',
                    $s->email,
                    $k->nama_kelas,
                    $k->mata_pelajaran,
                    $totalSesi,
                    $hadir,
                    $rate.'%',
                    $rate > 0 ? 'Aktif' : 'Tidak Aktif',
                ], null, "A{$row}");

                // Zebra stripe
                if ($row % 2 === 0) {
                    $sheet->getStyle("A{$row}:J{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F6FAFE');
                }
                $row++;
            }
        }

        // Auto-size columns A–J
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        // Simpan ke temp file lalu kirim sebagai download
        $filename = 'data-siswa-'.now()->format('Ymd-His').'.xlsx';
        $tempPath = storage_path('app/'.$filename);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function createSiswa()
    {
        $kelas = Kelas::where('guru_id', auth()->id())->get();

        return view('guru.kelas_siswa_create', compact('kelas'));
    }

    public function tambahSiswa(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        // Pastikan kelas milik guru yang sedang login
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('guru_id', auth()->id())
            ->firstOrFail();

        // Buat akun siswa baru
        $siswa = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
        ]);

        // Daftarkan ke kelas
        SiswaKelas::create([
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
        return view('guru.kelas_siswa_import');
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);

        $guruId = auth()->id();
        $path = $request->file('file_excel')->store('imports', 'local');
        $fullPath = storage_path('app/'.$path);

        try {
            $spreadsheet = IOFactory::load($fullPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return back()->withErrors(['file_excel' => 'File tidak dapat dibaca: '.$e->getMessage()]);
        } finally {
            Storage::disk('local')->delete($path);
        }

        // Cari baris header — cari baris yang kolom A = "No" (case-insensitive)
        $headerRow = null;
        foreach ($rows as $rowIndex => $row) {
            if (strtolower(trim($row['A'] ?? '')) === 'no') {
                $headerRow = $rowIndex;
                break;
            }
        }

        if (! $headerRow) {
            return back()->withErrors(['file_excel' => 'Format file tidak valid. Pastikan menggunakan file hasil export dari sistem ini.']);
        }

        // Cache semua kelas milik guru ini (key: lowercase nama_kelas)
        $kelasList = Kelas::where('guru_id', $guruId)->get()
            ->keyBy(fn ($k) => strtolower(trim($k->nama_kelas)));

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex <= $headerRow) {
                continue;
            }

            // Stop jika baris kosong atau bukan data siswa
            $noVal = trim($row['A'] ?? '');
            $namaVal = trim($row['B'] ?? '');
            if ($noVal === '' || $namaVal === '' || ! is_numeric($noVal)) {
                break;
            }

            $nama = $namaVal;
            $nis = trim($row['C'] ?? '') ?: null;
            $email = trim($row['D'] ?? '');
            $namaKelas = strtolower(trim($row['E'] ?? ''));

            // Validasi email
            if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Baris {$rowIndex}: Email tidak valid ({$email}), dilewati.";
                $skipped++;

                continue;
            }

            // Cari kelas dari nama di kolom E
            $kelas = $kelasList->get($namaKelas);
            if (! $kelas) {
                $errors[] = "Baris {$rowIndex}: Kelas '{$row['E']}' tidak ditemukan atau bukan milik Anda, dilewati.";
                $skipped++;

                continue;
            }

            // Buat atau update akun siswa
            $user = User::where('email', $email)->first();
            if (! $user) {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'nis' => $nis,
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                ]);
            } else {
                $user->update([
                    'name' => $nama,
                    'nis' => $nis ?? $user->nis,
                ]);
            }

            // Daftarkan ke kelas jika belum ada
            $sudahDaftar = SiswaKelas::where('siswa_id', $user->id)
                ->where('kelas_id', $kelas->id)
                ->exists();

            if (! $sudahDaftar) {
                SiswaKelas::create([
                    'siswa_id' => $user->id,
                    'kelas_id' => $kelas->id,
                ]);
                $imported++;
            } else {
                $skipped++;
            }
        }

        $message = "Import selesai: {$imported} siswa berhasil diproses.";
        if ($skipped > 0) {
            $message .= " {$skipped} dilewati.";
        }

        return redirect()->route('guru.kelas_siswa')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
