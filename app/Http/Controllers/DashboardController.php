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
            'super_admin' => redirect()->route('dashboard.super_admin'),
            default => abort(403),
        };
    }

    public function guru()
    {
        $user = Auth::user();
        $isAdmin = $this->isAdmin();

        $kelas = $isAdmin ? Kelas::all() : Kelas::where('guru_id', $user->id)->get();
        $kelasIds = $kelas->pluck('id');

        $totalKelas = $kelas->count();
        $totalSiswa = SiswaKelas::whereIn('kelas_id', $kelasIds)->count();
        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $totalMateri = $isAdmin
            ? Materi::count()
            : Materi::where('guru_id', $user->id)->count();

        $sesiQuery = fn () => $isAdmin
            ? SesiPresensi::query()
            : SesiPresensi::where('guru_id', $user->id);
        $presensiQuery = fn () => $isAdmin
            ? Presensi::query()
            : Presensi::whereHas('sesiPresensi', fn ($s) => $s->where('guru_id', $user->id));

        // Total sesi presensi keseluruhan (semua waktu)
        $totalSesi = $sesiQuery()->count();

        // Avg attendance rate keseluruhan
        $totalPresensiAll = $presensiQuery()->count();
        $hadirAll = $presensiQuery()->whereIn('status', ['hadir', 'telat'])->count();
        $avgAttendance = $totalPresensiAll > 0
            ? round($hadirAll / $totalPresensiAll * 100)
            : 0;

        // Data chart kehadiran per hari (Mon-Sun minggu ini)
        $chartData = [];
        $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $monday = now()->startOfWeek(Carbon::MONDAY);
        for ($i = 0; $i < 7; $i++) {
            $day = $monday->copy()->addDays($i);
            $sesiHari = $sesiQuery()->whereDate('created_at', $day)->get();
            $totalSiswaHari = $sesiHari->sum(fn ($s) => $s->kelas?->siswa()->count() ?? 0);
            $hadirHari = $presensiQuery()
                ->whereHas('sesiPresensi', fn ($q) => $q->whereDate('created_at', $day))
                ->whereIn('status', ['hadir', 'telat'])->count();
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
        $jadwalHariIni = ($isAdmin ? JadwalKelas::query() : JadwalKelas::where('guru_id', $user->id))
            ->where('hari', $todayHari)
            ->with('kelas')
            ->orderBy('jam_mulai')
            ->get();

        // Recent Activity (5 presensi terakhir dari sesi guru)
        $recentActivity = $presensiQuery()
            ->with(['siswa', 'sesiPresensi'])
            ->latest('created_at')
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
        $kelas = Kelas::whereIn('id', $kelasIds)->with('waliKelas')->get();

        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $guruIds = $kelas->pluck('guru_id')->unique();
        $totalMateri = Materi::whereIn('guru_id', $guruIds)->count();

        $kehadiranBulanIni = Presensi::where('siswa_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->count();

        $tugasBelum = Tugas::whereIn('kelas_id', $kelasIds)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $user->id)->where('status', 'sudah'))
            ->where('deadline', '>=', now())
            ->with('kelas')
            ->latest()
            ->limit(5)
            ->get();

        $tugasSelesai = PengumpulanTugas::where('siswa_id', $user->id)
            ->where('status', 'sudah')
            ->whereMonth('created_at', now()->month)
            ->count();

        $todayHari = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'][now()->englishDayOfWeek] ?? '';
        $jadwalHariIni = JadwalKelas::whereIn('kelas_id', $kelasIds)
            ->where('hari', $todayHari)
            ->with(['kelas', 'guru'])
            ->orderBy('jam_mulai')
            ->get();

        $jadwalOngoing = $jadwalHariIni->first(function ($j) {
            $now = now()->format('H:i:s');

            return $now >= $j->jam_mulai && $now <= $j->jam_selesai;
        });

        $totalSesiPresensi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();

        return view('dashboard.siswa', compact(
            'totalTugas', 'totalMateri', 'kehadiranBulanIni',
            'tugasBelum', 'tugasSelesai', 'kelas',
            'jadwalHariIni', 'jadwalOngoing', 'totalSesiPresensi'
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

    public function superAdmin()
    {
        // Super Admin Dashboard with system statistics
        $totalUsers = User::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalOrangTua = User::where('role', 'orang_tua')->count();

        $totalKelas = Kelas::count();
        $totalMateri = Materi::count();
        $totalTugas = Tugas::count();
        $totalPresensi = Presensi::count();

        // Recent activity
        $recentUsers = User::latest()->limit(10)->get();
        $recentKelas = Kelas::with('waliKelas')->latest()->limit(5)->get();

        return view('dashboard.super_admin', compact(
            'totalUsers', 'totalGuru', 'totalSiswa', 'totalOrangTua',
            'totalKelas', 'totalMateri', 'totalTugas', 'totalPresensi',
            'recentUsers', 'recentKelas'
        ));
    }
}
