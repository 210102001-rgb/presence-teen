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

        // Autorisasikan agar guru atau orang tua yang bersangkutan bisa melihat
        if ($user->role === 'guru') {
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($siswa->id), 403);
        } elseif ($user->role === 'orang_tua') {
            $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)->pluck('siswa_id');
            abort_if(! $siswaIds->contains($siswa->id), 403);
        } else {
            // Siswa hanya bisa melihat profilnya sendiri
            abort_if($user->id !== $siswa->id, 403);
        }

        // Hitung Kehadiran Bulan Ini
        $kelasIds = SiswaKelas::where('siswa_id', $siswa->id)->pluck('kelas_id');
        $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
        $totalHadir = Presensi::where('siswa_id', $siswa->id)->where('status', 'hadir')->count();
        $tingkatKehadiran = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100) : 100;

        // Hitung tugas selesai
        $tugasIds = Tugas::whereIn('kelas_id', $kelasIds)->pluck('id');
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereIn('tugas_id', $tugasIds)
            ->where('status', 'sudah')
            ->count();

        // Ambil Laporan AI / Peringatan
        $laporanTerbaru = LaporanAi::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Ambil aktivitas terakhir
        $aktivitas = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->take(5)
            ->get();

        return view('profile.anak', compact('siswa', 'tingkatKehadiran', 'tugasSelesai', 'laporanTerbaru', 'aktivitas'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
