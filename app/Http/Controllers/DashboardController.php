<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'siswa' => redirect()->route('dashboard.siswa'),
            'guru' => redirect()->route('dashboard.guru'),
            'orang_tua' => redirect()->route('dashboard.orang_tua'),
            default => abort(403),
        };
    }

    public function siswa()
    {
        $user = Auth::user();
        $kelasIds = SiswaKelas::where('siswa_id', $user->id)->pluck('kelas_id');

        // Presensi Bulan Ini
        $totalSesiBulanIni = SesiPresensi::whereIn('kelas_id', $kelasIds)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalHadirBulanIni = Presensi::where('siswa_id', $user->id)
            ->whereMonth('waktu_absen', now()->month)
            ->whereYear('waktu_absen', now()->year)
            ->count();

        $tingkatKehadiran = $totalSesiBulanIni > 0
            ? round(($totalHadirBulanIni / $totalSesiBulanIni) * 100)
            : 100;

        // Tugas Aktif
        $tugasIds = Tugas::whereIn('kelas_id', $kelasIds)
            ->where('deadline', '>=', now())
            ->pluck('id');

        $tugasSudahKumpulIds = PengumpulanTugas::where('siswa_id', $user->id)
            ->whereIn('tugas_id', $tugasIds)
            ->pluck('tugas_id');

        $tugasAktifCount = $tugasIds->diff($tugasSudahKumpulIds)->count();

        // Materi Tersedia
        $materiTersediaCount = Materi::count();

        // Tugas Mendatang
        $tugasMendatang = Tugas::with('kelas')
            ->whereIn('kelas_id', $kelasIds)
            ->where('deadline', '>=', now())
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('tugas_id')
                    ->from('pengumpulan_tugas')
                    ->where('siswa_id', $user->id);
            })
            ->orderBy('deadline', 'asc')
            ->take(3)
            ->get();

        return view('dashboard.siswa', compact(
            'tingkatKehadiran',
            'tugasAktifCount',
            'materiTersediaCount',
            'tugasMendatang'
        ));
    }

    public function guru()
    {
        $user = Auth::user();

        $totalKelas = Kelas::where('guru_id', $user->id)->count();

        $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
        $totalSiswa = SiswaKelas::whereIn('kelas_id', $kelasIds)->distinct('siswa_id')->count();

        $totalTugas = Tugas::where('guru_id', $user->id)->count();

        return view('dashboard.guru', compact('totalKelas', 'totalSiswa', 'totalTugas'));
    }

    public function orangTua()
    {
        $user = Auth::user();
        $anakIds = $user->anak()->pluck('users.id');
        $anak = $user->anak()->with('kelasSaya')->first();

        // Kehadiran Hari Ini
        $kehadiranHariIni = Presensi::whereIn('siswa_id', $anakIds)
            ->whereDate('waktu_absen', now()->toDateString())
            ->exists() ? 'Hadir' : 'Tidak Hadir';

        // Tugas Aktif Anak
        $totalTugasBelumKumpul = 0;
        $kelasAnakIds = SiswaKelas::whereIn('siswa_id', $anakIds)->pluck('kelas_id');
        foreach ($anakIds as $anakId) {
            $kelasIds = SiswaKelas::where('siswa_id', $anakId)->pluck('kelas_id');
            $tugasIds = Tugas::whereIn('kelas_id', $kelasIds)->pluck('id');
            $sudahKumpul = PengumpulanTugas::where('siswa_id', $anakId)
                ->whereIn('tugas_id', $tugasIds)
                ->pluck('tugas_id');
            $totalTugasBelumKumpul += $tugasIds->diff($sudahKumpul)->count();
        }

        // Peringatan
        $peringatanCount = LaporanAi::whereIn('siswa_id', $anakIds)
            ->whereIn('level_peringatan', ['perhatian', 'kritis'])
            ->count();

        // Status Tugas Anak (List)
        $tugasAnak = Tugas::with([
            'kelas.siswa',
            'pengumpulan' => function ($q) use ($anakIds) {
                $q->whereIn('siswa_id', $anakIds);
            },
            'pengumpulan.siswa',
        ])
            ->whereIn('kelas_id', $kelasAnakIds)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Laporan AI Terbaru
        $laporanTerbaru = LaporanAi::whereIn('siswa_id', $anakIds)
            ->orderBy('created_at', 'desc')
            ->first();

        // Hitung Statistik Anak Pertama untuk Dashboard Bento
        $totalSesi = 0;
        $totalHadir = 0;
        $totalTelat = 0;
        $totalAlpha = 0;
        $kelasNama = 'Belum ada kelas';

        if ($anak) {
            $kelasIds = $anak->kelasSaya->pluck('id');
            $kelasNama = $anak->kelasSaya->first()->nama_kelas ?? 'Belum ada kelas';

            $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
            $presensi = Presensi::where('siswa_id', $anak->id)->get();
            $totalHadir = $presensi->where('status', 'hadir')->count();
            $totalTelat = $presensi->where('status', 'telat')->count();
            $totalAlpha = max(0, $totalSesi - $presensi->count());
        }

        $presentPercent = $totalSesi > 0
            ? round((($totalHadir + $totalTelat) / $totalSesi) * 100)
            : 100;

        return view('dashboard.orang_tua', compact(
            'kehadiranHariIni',
            'totalTugasBelumKumpul',
            'peringatanCount',
            'tugasAnak',
            'laporanTerbaru',
            'anakIds',
            'anak',
            'kelasNama',
            'totalSesi',
            'totalHadir',
            'totalTelat',
            'totalAlpha',
            'presentPercent'
        ));
    }
}
