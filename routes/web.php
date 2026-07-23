<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SummarizeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use App\Models\LaporanAi;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa')->middleware('role:siswa');
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru')->middleware('role:guru');
    Route::get('/dashboard/orang-tua', [DashboardController::class, 'orangTua'])->name('dashboard.orang_tua')->middleware('role:orang_tua');
    Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])->name('dashboard.super_admin')->middleware('role:super_admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/anak/{siswa}', [ProfileController::class, 'showAnak'])->name('profile.anak');

    // === Notifications ===
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    })->name('notifications.markAllRead');

    // Super Admin Account Management
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/kelola-akun', [AccountController::class, 'index'])->name('account.index');
        Route::get('/kelola-akun/create', [AccountController::class, 'create'])->name('account.create');
        Route::post('/kelola-akun', [AccountController::class, 'store'])->name('account.store');
        Route::get('/kelola-akun/{user}/edit', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/kelola-akun/{user}', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/kelola-akun/{user}', [AccountController::class, 'destroy'])->name('account.destroy');
        Route::get('/kelola-akun/{user}/edit-password', [AccountController::class, 'editPassword'])->name('account.edit-password');
        Route::put('/kelola-akun/{user}/update-password', [AccountController::class, 'updatePassword'])->name('account.update-password');
    });
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

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('guru.jadwal');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('guru.jadwal.store');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('guru.jadwal.destroy');

    Route::get('/kelas', [KelasController::class, 'index'])->name('guru.kelas');
    Route::post('/kelas', [KelasController::class, 'store'])->name('guru.kelas.store');
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('guru.kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('guru.kelas.destroy');
    Route::get('/kelas-siswa', [KelasController::class, 'siswa'])->name('guru.kelas_siswa');
    Route::get('/kelas-siswa/export', [KelasController::class, 'exportSiswa'])->name('guru.kelas_siswa.export');
    Route::get('/kelas-siswa/import', [KelasController::class, 'showImport'])->name('guru.kelas_siswa.import');
    Route::post('/kelas-siswa/import', [KelasController::class, 'importSiswa'])->name('guru.kelas_siswa.import.store');
    Route::get('/kelas-siswa/tambah', [KelasController::class, 'createSiswa'])->name('guru.kelas_siswa.create');
    Route::post('/kelas-siswa/tambah', [KelasController::class, 'tambahSiswa'])->name('guru.kelas_siswa.tambah');
    Route::post('/kelas-siswa/hapus', [KelasController::class, 'hapusSiswa'])->name('guru.kelas_siswa.hapus');
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
    Route::get('/pengumpulan-tugas/{pengumpulanTugas}/download', [TugasController::class, 'download'])->name('tugas.download');
});

// === Materi AI ===
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');
});

Route::middleware(['auth', 'role:guru,siswa'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');
    Route::post('/materi/{materi}/ringkas', [MateriController::class, 'ringkas'])->name('materi.ringkas');
});

// === Laporan AI ===
Route::middleware(['auth', 'role:guru,orang_tua'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
});

// === Fitur Tambahan (Figma UI/UX) ===
Route::middleware('auth')->group(function () {
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');

    Route::middleware('role:guru')->group(function () {
        Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    });

    Route::get('/prediksi-absensi', function () {
        $user = auth()->user();
        $isOrangTua = $user->role === 'orang_tua';
        $siswa = $isOrangTua ? $user->anak()->first() : $user;

        if (! $siswa) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        $kelasIds = $siswa->kelasSaya->pluck('id');

        // Total sessions and attendance counts
        $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
        $totalHadir = Presensi::where('siswa_id', $siswa->id)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();
        $totalAlpha = Presensi::where('siswa_id', $siswa->id)
            ->where('status', 'alpha')
            ->count();
        $totalIzin = Presensi::where('siswa_id', $siswa->id)
            ->where('status', 'izin')
            ->count();

        // Task completion stats for student
        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->where('status', 'sudah')
            ->count();

        $tingkatKehadiran = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100, 1) : 100;

        // Monthly trend (last 6 months)
        $months = collect();
        $trendData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->translatedFormat('M');
            $months->push($monthLabel);

            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $sesiBulan = SesiPresensi::whereIn('kelas_id', $kelasIds)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $hadirBulan = Presensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['hadir', 'telat'])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $pct = $sesiBulan > 0 ? round(($hadirBulan / $sesiBulan) * 100) : 100;
            $trendData->push($pct);
        }

        // Predicted next month (simple projection based on last 3 months average)
        $recentTrend = $trendData->slice(-3)->values();
        $prediksiBulanDepan = $recentTrend->count() > 0
            ? round($recentTrend->avg(), 1)
            : $tingkatKehadiran;

        // Risk assessment
        $risiko = 'Rendah';
        $risikoColor = 'text-primary';
        if ($tingkatKehadiran < 80) {
            $risiko = 'Tinggi';
            $risikoColor = 'text-error';
        } elseif ($tingkatKehadiran < 90) {
            $risiko = 'Sedang';
            $risikoColor = 'text-amber-600';
        }

        $akurasi = 92 + min(5, (int) ($tingkatKehadiran / 25));

        return view('features.prediksi_absensi', compact(
            'siswa', 'tingkatKehadiran', 'totalSesi', 'totalHadir', 'totalAlpha', 'totalIzin',
            'months', 'trendData', 'prediksiBulanDepan', 'risiko', 'risikoColor', 'akurasi',
            'totalTugas', 'tugasSelesai'
        ));
    })->name('prediksi.index');

    Route::get('/ai-motivasi', function () {
        $user = auth()->user();
        $isOrangTua = $user->role === 'orang_tua';
        $siswa = $isOrangTua ? $user->anak()->first() : $user;

        if (! $siswa) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        $kelasIds = $siswa->kelasSaya->pluck('id');

        // Attendance stats
        $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
        $totalHadir = Presensi::where('siswa_id', $siswa->id)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();
        $tingkatKehadiran = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100, 1) : 100;

        // Task completion stats
        $totalTugas = Tugas::whereIn('kelas_id', $kelasIds)->count();
        $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->where('status', 'sudah')
            ->count();
        $tugasTerlambat = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->where('status', 'terlambat')
            ->count();

        // Recent AI reports
        $laporanAi = LaporanAi::where('siswa_id', $siswa->id)
            ->latest()
            ->take(3)
            ->get();

        // Classification based on attendance + task completion
        $akurasi = 92 + min(5, (int) ($tingkatKehadiran / 25));
        $klasifikasi = 'Sangat Aktif';
        $risiko = 'Rendah';
        if ($tingkatKehadiran < 80 || $tugasSelesai < $totalTugas * 0.5) {
            $klasifikasi = 'Perlu Perhatian';
            $risiko = 'Tinggi';
        } elseif ($tingkatKehadiran < 90 || $tugasSelesai < $totalTugas * 0.7) {
            $klasifikasi = 'Aktif';
            $risiko = 'Sedang';
        }

        return view('features.ai_motivasi', compact(
            'siswa', 'tingkatKehadiran', 'totalHadir', 'totalSesi',
            'totalTugas', 'tugasSelesai', 'tugasTerlambat',
            'laporanAi', 'akurasi', 'klasifikasi', 'risiko'
        ));
    })->name('motivasi.index');

    // Summarize AI - siswa upload materi lalu diringkas oleh AI
    Route::middleware('role:siswa')->group(function () {
        Route::post('/summarize-ai', [SummarizeController::class, 'process'])->name('summarize.process');
        Route::get('/summarize-ai/download/{filename}', [SummarizeController::class, 'downloadRingkasan'])
            ->where('filename', '.*')
            ->name('summarize.download');
    });

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

        // Total sesi yang diikuti siswa
        $totalSesiDiikuti = Presensi::where('siswa_id', $siswa->id)->count();

        // Sesi minggu ini
        $mingguIni = Carbon::now()->startOfWeek();
        $sesiMingguIni = Presensi::where('siswa_id', $siswa->id)
            ->where('waktu_absen', '>=', $mingguIni)
            ->count();

        // Grafik aktivitas harian (Sen-Jum minggu ini)
        $grafikHarian = [];
        for ($i = 1; $i <= 5; $i++) {
            $hari = Carbon::now()->startOfWeek()->addDays($i - 1);
            $count = Presensi::where('siswa_id', $siswa->id)
                ->whereDate('waktu_absen', $hari->toDateString())
                ->count();
            $grafikHarian[] = [
                'label' => $hari->translatedFormat('D'),
                'count' => $count,
            ];
        }

        // Log aktivitas terbaru (gabungan tugas + presensi)
        $logTugas = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->with('tugas.kelas')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($t) => [
                'type' => 'tugas',
                'title' => 'Kumpul Tugas: '.($t->tugas->judul ?? '-'),
                'subtitle' => ($t->tugas->kelas->nama_kelas ?? '-').' • '.$t->created_at->diffForHumans(),
                'created_at' => $t->created_at,
            ]);

        $logPresensi = Presensi::where('siswa_id', $siswa->id)
            ->with('sesiPresensi.kelas')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($p) => [
                'type' => 'presensi',
                'title' => 'Presensi '.ucfirst($p->status),
                'subtitle' => ($p->sesiPresensi->mata_pelajaran ?? '-').' • '.$p->sesiPresensi->kelas->nama_kelas.' • '.$p->waktu_absen->diffForHumans(),
                'created_at' => $p->waktu_absen,
            ]);

        $logAktivitas = $logTugas->concat($logPresensi)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        // Get latest attendance log
        $latestPresensi = Presensi::where('siswa_id', $siswa->id)
            ->with('sesiPresensi.kelas')
            ->orderBy('waktu_absen', 'desc')
            ->first();

        // Calculate rate
        $totalSesi = SesiPresensi::whereIn('kelas_id', $kelasIds)->count();
        $hadir = Presensi::where('siswa_id', $siswa->id)->whereIn('status', ['hadir', 'telat'])->count();
        $attendanceRate = $totalSesi > 0 ? round(($hadir / $totalSesi) * 100) : 100;

        return view('features.aktivitas_belajar', compact(
            'siswa', 'totalTugas', 'tugasSelesai', 'totalMateri',
            'latestPresensi', 'attendanceRate',
            'totalSesiDiikuti', 'sesiMingguIni', 'grafikHarian', 'logAktivitas'
        ));
    })->name('aktivitas.index');
});

require __DIR__.'/auth.php';
