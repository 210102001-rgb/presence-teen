<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
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
});

// === Presensi QR ===
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

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::post('/materi/{materi}/ringkas', [MateriController::class, 'ringkas'])->name('materi.ringkas');
});

// === Laporan AI ===
Route::middleware(['auth', 'role:guru,orang_tua'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
});

require __DIR__.'/auth.php';
