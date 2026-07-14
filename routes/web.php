<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Pengumuman;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\Tugas;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa')->middleware('role:siswa');
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru')->middleware('role:guru');
    Route::get('/dashboard/orang-tua', [DashboardController::class, 'orangTua'])->name('dashboard.orang_tua')->middleware('role:orang_tua');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/anak/{siswa}', [ProfileController::class, 'showAnak'])->name('profile.anak');
});

// === Presensi QR ===
Route::middleware('auth')->group(function () {
    Route::get('/presensi/riwayat', [PresensiController::class, 'riwayat'])->name('presensi.riwayat');
    Route::get('/presensi/detail/{presensi}', [PresensiController::class, 'detail'])->name('presensi.detail');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/presensi/scan', [PresensiController::class, 'showScanPage'])->name('presensi.scan');
    Route::get('/presensi/scan/{token}', function ($token) {
        return view('presensi.scan', compact('token'));
    })->name('presensi.scan.token');
    Route::post('/presensi/validasi', [PresensiController::class, 'validasiToken'])->name('presensi.validasi');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/presensi/guru', [PresensiController::class, 'guruQr'])->name('presensi.guru');
    Route::get('/presensi/guru/{kelas}', [PresensiController::class, 'guruQr'])->name('presensi.guru.qr');
    Route::post('/presensi/guru/{kelas}/settings', [PresensiController::class, 'updateSettings'])->name('presensi.guru.settings');
    Route::get('/presensi/manual', [PresensiController::class, 'manualInput'])->name('presensi.manual');
    Route::post('/presensi/manual', [PresensiController::class, 'storeManualInput'])->name('presensi.manual.store');

    Route::get('/jadwal', [\App\Http\Controllers\JadwalController::class, 'index'])->name('guru.jadwal');
    Route::post('/jadwal', [\App\Http\Controllers\JadwalController::class, 'store'])->name('guru.jadwal.store');
    Route::delete('/jadwal/{jadwal}', [\App\Http\Controllers\JadwalController::class, 'destroy'])->name('guru.jadwal.destroy');

    Route::get('/kelas', [\App\Http\Controllers\KelasController::class, 'index'])->name('guru.kelas');
    Route::post('/kelas', [\App\Http\Controllers\KelasController::class, 'store'])->name('guru.kelas.store');
    Route::put('/kelas/{kelas}', [\App\Http\Controllers\KelasController::class, 'update'])->name('guru.kelas.update');
    Route::delete('/kelas/{kelas}', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('guru.kelas.destroy');

    Route::get('/kelas-siswa', function () {
        $kelas = Kelas::with('siswa')->where('guru_id', auth()->id())->get();

        // Hitung attendance rate per siswa
        $attendanceMap = [];
        foreach ($kelas as $k) {
            $totalSesiKelas = \App\Models\SesiPresensi::where('kelas_id', $k->id)->count();
            foreach ($k->siswa as $siswa) {
                $hadirCount = \App\Models\Presensi::where('siswa_id', $siswa->id)
                    ->whereIn('status', ['hadir', 'telat'])
                    ->whereHas('sesiPresensi', fn($q) => $q->where('kelas_id', $k->id))
                    ->count();
                $rate = $totalSesiKelas > 0 ? round($hadirCount / $totalSesiKelas * 100) : 0;
                $attendanceMap[$siswa->id . '_' . $k->id] = $rate;
            }
        }

        // Flatten: semua siswa dengan kelas & stats
        $semuaSiswa = collect();
        foreach ($kelas as $k) {
            foreach ($k->siswa as $s) {
                $semuaSiswa->push([
                    'siswa'     => $s,
                    'kelas'     => $k,
                    'rate'      => $attendanceMap[$s->id . '_' . $k->id] ?? 0,
                ]);
            }
        }

        return view('guru.kelas_siswa', compact('kelas', 'semuaSiswa'));
    })->name('guru.kelas_siswa');
});

// === Tugas ===
Route::middleware(['auth'])->group(function () {
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create')->middleware('role:guru');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store')->middleware('role:guru');
    Route::get('/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit')->middleware('role:guru');
    Route::put('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update')->middleware('role:guru');
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy')->middleware('role:guru');
    Route::post('/tugas/{tugas}/kumpul', [TugasController::class, 'kumpul'])->name('tugas.kumpul')->middleware('role:siswa');
});

// === Materi AI ===
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
});

Route::middleware(['auth', 'role:guru,siswa'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
});

Route::middleware(['auth', 'role:guru,siswa'])->group(function () {
    Route::post('/materi/{materi}/ringkas', [MateriController::class, 'ringkas'])->name('materi.ringkas');
});

// === Laporan AI ===
Route::middleware(['auth', 'role:guru,orang_tua'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
});

// === Fitur Tambahan (Figma UI/UX) ===
Route::middleware('auth')->group(function () {
    Route::get('/pengumuman', function () {
        $pengumuman = Pengumuman::latest()->get();

        return view('features.pengumuman', compact('pengumuman'));
    })->name('pengumuman.index');

    Route::get('/prediksi-absensi', function () {
        return view('features.prediksi_absensi');
    })->name('prediksi.index');

    Route::get('/ai-motivasi', function () {
        return view('features.ai_motivasi');
    })->name('motivasi.index');

    Route::get('/aktivitas-belajar', function () {
        $user = auth()->user();
        if ($user->role === 'orang_tua') {
            $siswa = $user->anak()->first();
        } else {
            $siswa = $user;
        }

        if (! $siswa) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        $kelasIds = $siswa->kelasSaya->pluck('id');

        // Count Tugas Selesai vs Total Tugas
        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)->where('status', 'sudah')->count();

        // Count Total Materi (Modules)
        $totalMateri = Materi::count();

        // Get latest attendance log
        $latestPresensi = Presensi::where('siswa_id', $siswa->id)
            ->with('sesiPresensi.kelas')
            ->orderBy('waktu_absen', 'desc')
            ->first();

        // Calculate rate
        $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
        $hadir = Presensi::where('siswa_id', $siswa->id)->whereIn('status', ['hadir', 'telat'])->count();
        $attendanceRate = $totalSesi > 0 ? round(($hadir / $totalSesi) * 100) : 100;

        return view('features.aktivitas_belajar', compact('siswa', 'totalTugas', 'tugasSelesai', 'totalMateri', 'latestPresensi', 'attendanceRate'));
    })->name('aktivitas.index');
});

require __DIR__.'/auth.php';
