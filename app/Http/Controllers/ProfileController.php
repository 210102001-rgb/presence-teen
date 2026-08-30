<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Kelas;
use App\Models\LaporanAi;
use App\Models\OrangTuaSiswa;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display a specific student profile.
     */
    public function showAnak(User $siswa): View
    {
        $user = auth()->user();

        // Autorisasikan agar guru atau orang tua yang bersangkutan bisa melihat (admin boleh semua)
        if ($this->isAdmin()) {
            // super admin bisa melihat profil siswa mana pun
        } elseif ($user->role === 'guru') {
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($siswa->id), 403);
        } elseif ($user->role === 'orang_tua') {
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($siswa->id), 403);
        } else {
            abort_if($user->id !== $siswa->id, 403);
        }

        // Kelas IDs milik siswa
        $userKelasIds = SiswaKelas::where('siswa_id', $siswa->id)->pluck('kelas_id');

        // Hitung Kehadiran
        $totalSesi = SesiPresensi::whereIn('kelas_id', $userKelasIds)->count();
        $presensiAll = Presensi::where('siswa_id', $siswa->id)->get();
        $totalHadir = $presensiAll->where('status', 'hadir')->count();
        $totalTelat = $presensiAll->where('status', 'telat')->count();
        $totalAlpha = max(0, $totalSesi - $presensiAll->count());
        $tingkatKehadiran = $totalSesi > 0 ? round(($totalHadir + $totalTelat) / $totalSesi * 100) : 100;

        // Hitung tugas selesai
        $tugasIds = Tugas::whereIn('kelas_id', $userKelasIds)->pluck('id');
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereIn('tugas_id', $tugasIds)
            ->where('status', 'sudah')
            ->count();

        // Kalender: presensi bulan ini
        $year = now()->year;
        $month = now()->month;
        $presensiBulanIni = Presensi::where('siswa_id', $siswa->id)
            ->whereMonth('waktu_absen', $month)
            ->whereYear('waktu_absen', $year)
            ->get()
            ->keyBy(fn ($p) => Carbon::parse($p->waktu_absen)->day);

        // Kalender: sesi bulan ini (scoped ke kelas siswa)
        $sesiBulanIni = SesiPresensi::whereIn('kelas_id', $userKelasIds)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get()
            ->keyBy(fn ($s) => $s->created_at->day);

        // Chart trend: 5 bulan terakhir
        $trendLabels = [];
        $trendData = [];
        for ($i = 4; $i >= 0; $i--) {
            $bulannya = Carbon::now()->subMonths($i);
            $trendLabels[] = $bulannya->translatedFormat('M');
            $mSesi = SesiPresensi::whereIn('kelas_id', $userKelasIds)
                ->whereMonth('created_at', $bulannya->month)
                ->whereYear('created_at', $bulannya->year)
                ->count();
            $mHadir = Presensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['hadir', 'telat'])
                ->whereMonth('waktu_absen', $bulannya->month)
                ->whereYear('waktu_absen', $bulannya->year)
                ->count();
            $trendData[] = $mSesi > 0 ? round($mHadir / $mSesi * 100) : 0;
        }

        $attendanceRate = $tingkatKehadiran;

        // Laporan AI
        $laporanTerbaru = LaporanAi::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Aktivitas terakhir
        $aktivitas = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->take(5)
            ->get();

        return view('profile.anak', compact(
            'siswa', 'tingkatKehadiran', 'tugasSelesai', 'laporanTerbaru', 'aktivitas',
            'presensiBulanIni', 'sesiBulanIni', 'trendLabels', 'trendData',
            'totalHadir', 'totalTelat', 'totalAlpha', 'attendanceRate'
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // NIS hanya untuk siswa
        if ($user->role === 'siswa') {
            $user->nis = $request->nis;
        }

        // Mata pelajaran hanya untuk guru
        if ($user->role === 'guru') {
            $user->mata_pelajaran = $request->mata_pelajaran;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
