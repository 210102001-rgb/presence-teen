<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\Materi;
use App\Models\OrangTuaSiswa;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use App\Models\User;
use Carbon\Carbon;
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

    public function guru()
    {
        $user = Auth::user();
        $kelas = Kelas::where('guru_id', $user->id)->get();
        $kelasIds = $kelas->pluck('id');

        $totalKelas = $kelas->count();
        $totalSiswa = SiswaKelas::whereIn('kelas_id', $kelasIds)->count();
        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $totalMateri = Materi::where('guru_id', $user->id)->count();

        // Total sesi presensi minggu ini
        $totalSesi = SesiPresensi::where('guru_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Avg attendance rate (hadir+telat / total presensi minggu ini)
        $totalPresensiMingguIni = Presensi::whereHas('sesiPresensi', fn ($q) => $q->where('guru_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        )->count();
        $hadirMingguIni = Presensi::whereHas('sesiPresensi', fn ($q) => $q->where('guru_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        )->whereIn('status', ['hadir', 'telat'])->count();
        $avgAttendance = $totalPresensiMingguIni > 0
            ? round($hadirMingguIni / $totalPresensiMingguIni * 100)
            : 0;

        // Data chart kehadiran per hari (Mon-Sun minggu ini)
        $chartData = [];
        $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $monday = now()->startOfWeek(Carbon::MONDAY);
        for ($i = 0; $i < 7; $i++) {
            $day = $monday->copy()->addDays($i);
            $sesiHari = SesiPresensi::where('guru_id', $user->id)
                ->whereDate('created_at', $day)->get();
            $totalSiswaHari = $sesiHari->sum(fn ($s) => $s->kelas->siswa()->count());
            $hadirHari = Presensi::whereHas('sesiPresensi', fn ($q) => $q->where('guru_id', $user->id)->whereDate('created_at', $day)
            )->whereIn('status', ['hadir', 'telat'])->count();
            $chartData[] = [
                'label' => $dayNames[$i],
                'hadir' => $hadirHari,
                'total' => max($totalSiswaHari, $hadirHari),
            ];
        }

        // Today's Schedule (dari jadwal_kelas)
        $todayHari = ['Sen' => 'Senin', 'Sel' => 'Selasa', 'Rab' => 'Rabu', 'Kam' => 'Kamis',
            'Jum' => 'Jumat', 'Sab' => 'Sabtu'][now()->shortDayName] ??
                     ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                         'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'][now()->englishDayOfWeek] ?? '';
        $jadwalHariIni = JadwalKelas::where('guru_id', $user->id)
            ->where('hari', $todayHari)
            ->with('kelas')
            ->orderBy('jam_mulai')
            ->get();

        // Recent Activity (5 presensi terakhir dari sesi guru)
        $recentActivity = Presensi::whereHas('sesiPresensi', fn ($q) => $q->where('guru_id', $user->id)
        )->with(['siswa', 'sesiPresensi'])
            ->latest('waktu_absen')
            ->limit(5)
            ->get();

        // 5 tugas terbaru
        $tugasTerbaru = Tugas::whereIn('kelas_id', $kelasIds)
            ->with('kelas')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.guru', compact(
            'totalKelas', 'totalSiswa', 'totalTugas', 'totalMateri',
            'totalSesi', 'avgAttendance', 'chartData',
            'jadwalHariIni', 'recentActivity',
            'tugasTerbaru', 'kelas'
        ));
    }

    public function siswa()
    {
        $user = Auth::user();
        $kelasIds = SiswaKelas::where('siswa_id', $user->id)->pluck('kelas_id');

        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $totalMateri = Materi::whereIn('kelas_id', $kelasIds)->count();

        // Kehadiran bulan ini
        $kehadiranBulanIni = Presensi::where('siswa_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Tugas yg belum dikumpul
        $tugasBelum = Tugas::whereIn('kelas_id', $kelasIds)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $user->id)->where('status', 'sudah'))
            ->where('deadline', '>=', now())
            ->with('kelas')
            ->latest()
            ->limit(5)
            ->get();

        // Tugas yg sudah dikumpul bulan ini
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $user->id)
            ->where('status', 'sudah')
            ->whereMonth('created_at', now()->month)
            ->count();

        return view('dashboard.siswa', compact(
            'totalTugas', 'totalMateri', 'kehadiranBulanIni',
            'tugasBelum', 'tugasSelesai'
        ));
    }

    public function orangTua()
    {
        $user = Auth::user();

        // Cari siswa yang dihubungkan ke ortu ini
        $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
        $siswa = User::whereIn('id', $siswaIds)->with(['siswaKelas.kelas'])->get();

        // Laporan AI terbaru per siswa
        $laporans = LaporanAi::whereIn('siswa_id', $siswaIds)
            ->with('siswa')
            ->latest()
            ->limit(5)
            ->get();

        $totalPeringatan = LaporanAi::whereIn('siswa_id', $siswaIds)
            ->whereIn('level_peringatan', ['sedang', 'berat'])
            ->count();

        return view('dashboard.orang_tua', compact('siswa', 'laporans', 'totalPeringatan'));
    }
}
