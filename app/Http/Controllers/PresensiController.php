<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Notifications\PresensiTercatat;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function showScanPage()
    {
        return view('presensi.scan');
    }

    public function guruQr(Request $request, ?Kelas $kelas = null)
    {
        $kelasList = Kelas::where('guru_id', auth()->id())->get();

        $jadwal = null;
        if ($request->jadwal_id) {
            $jadwal = JadwalKelas::where('guru_id', auth()->id())
                ->where('id', $request->jadwal_id)
                ->first();
        }

        return view('presensi.guru-qr', [
            'kelas' => $kelasList,
            'selectedKelas' => $kelas,
            'jadwal' => $jadwal,
        ]);
    }

    public function updateSettings(Request $request, Kelas $kelas)
    {
        if ($kelas->guru_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'batas_terlambat_menit' => 'required|integer|min:0|max:180',
            'durasi_qr_detik' => 'required|integer|min:5|max:3600',
            'email_pengirim_notifikasi' => 'nullable|email|max:255',
            'kirim_notifikasi_otomatis' => 'sometimes|boolean',
        ]);

        $validated['kirim_notifikasi_otomatis'] = $request->has('kirim_notifikasi_otomatis');

        $kelas->update($validated);

        return back()->with('status', 'settings-updated');
    }

    public function validasiToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $token = $request->token;
        if (filter_var($token, FILTER_VALIDATE_URL)) {
            $token = basename(parse_url($token, PHP_URL_PATH));
        }

        $sesi = SesiPresensi::where('qr_token', $token)
            ->where('is_active', true)
            ->first();

        if (! $sesi) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak valid atau sesi sudah berakhir.',
            ]);
        }

        if ($sesi->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'QR sudah expired, tunggu refresh berikutnya.',
            ]);
        }

        $siswaId = auth()->id();

        // cek siswa terdaftar di kelas sesi ini
        $terdaftar = $sesi->kelas->siswa()->where('users.id', $siswaId)->exists();
        if (! $terdaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar di kelas ini.',
            ]);
        }

        // cegah absen dobel (unique constraint juga jaga-jaga di level DB)
        $sudahAbsen = Presensi::where('sesi_presensi_id', $sesi->id)
            ->where('siswa_id', $siswaId)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah tercatat hadir di sesi ini.',
            ]);
        }

        // Cek keterlambatan berdasarkan toleransi menit dari kelas
        $waktuSesiMulai = $sesi->created_at;
        $batasTerlambatMenit = $sesi->kelas->batas_terlambat_menit ?? 15;
        $status = 'hadir';
        if ($waktuSesiMulai && now()->diffInMinutes($waktuSesiMulai) > $batasTerlambatMenit) {
            $status = 'telat';
        }

        $presensi = Presensi::create([
            'sesi_presensi_id' => $sesi->id,
            'siswa_id' => $siswaId,
            'waktu_absen' => now(),
            'status' => $status,
        ]);

        // Trigger notifikasi ke orang tua jika diizinkan di preferensi kelas
        $userSiswa = auth()->user();
        if ($sesi->kelas->kirim_notifikasi_otomatis && $userSiswa->orangTua) {
            $ortu = $userSiswa->orangTua->orangTua;
            if ($ortu) {
                try {
                    // Set email pengirim khusus dari preferensi kelas jika diisi
                    if ($sesi->kelas->email_pengirim_notifikasi) {
                        config(['mail.from.address' => $sesi->kelas->email_pengirim_notifikasi]);
                    }
                    $ortu->notify(new PresensiTercatat($presensi));
                } catch (\Exception $e) {
                    // Fail-safe jika driver mail belum dikonfigurasi sepenuhnya
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat!',
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'siswa') {
            $presensi = Presensi::where('siswa_id', $user->id)
                ->with('sesiPresensi.kelas')
                ->orderBy('waktu_absen', 'desc')
                ->get();
        } elseif ($user->role === 'guru' && $request->siswa_id) {
            // Guru melihat riwayat siswa tertentu
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');
            abort_unless($siswaIds->contains($request->siswa_id), 403);

            $presensi = Presensi::where('siswa_id', $request->siswa_id)
                ->with('sesiPresensi.kelas')
                ->orderBy('waktu_absen', 'desc')
                ->get();
        } else {
            // orang tua
            $siswaIds = $user->anak()->pluck('users.id');
            $presensi = Presensi::whereIn('siswa_id', $siswaIds)
                ->with('siswa', 'sesiPresensi.kelas')
                ->orderBy('waktu_absen', 'desc')
                ->get();
        }

        return view('presensi.riwayat', compact('presensi'));
    }

    public function detail(Presensi $presensi)
    {
        $user = auth()->user();
        if ($user->role === 'siswa') {
            abort_if($presensi->siswa_id !== $user->id, 403);
        } elseif ($user->role === 'orang_tua') {
            $siswaIds = $user->anak()->pluck('users.id');
            abort_if(! $siswaIds->contains($presensi->siswa_id), 403);
        } else {
            // guru
            $kelasIds = Kelas::where('guru_id', $user->id)->pluck('id');
            abort_if(! $kelasIds->contains($presensi->sesiPresensi->kelas_id), 403);
        }

        $presensi->load('siswa', 'sesiPresensi.kelas');

        return view('presensi.detail', compact('presensi'));
    }

    public function manualInput()
    {
        // Load all classes for the guru with their students
        $kelas = Kelas::where('guru_id', auth()->id())
            ->with('siswa')
            ->get();

        return view('guru.manual_presensi', compact('kelas'));
    }

    public function storeManualInput(Request $request)
    {
        $request->validate([
            'sesi_presensi_id' => 'nullable',  // Optional, not used in simplified form
            'siswa_id' => 'required|exists:users,id',
            'status' => 'required|in:hadir,telat,sakit,izin,alpha',
        ]);

        // If sesi_presensi_id is not provided, find the most recent session for this student
        $sesiId = $request->sesi_presensi_id;
        if (!$sesiId) {
            // Get the most recent active session
            $recentSesi = SesiPresensi::where('is_active', true)
                ->latest()
                ->first();
            $sesiId = $recentSesi?->id;
        }

        // If no active session found, use any recent session
        if (!$sesiId) {
            $recentSesi = SesiPresensi::latest()
                ->first();
            $sesiId = $recentSesi?->id;
        }

        // If still no session, create a generic entry or reject
        if (!$sesiId) {
            return back()->with('error', 'Tidak ada sesi presensi yang tersedia. Buat sesi presensi terlebih dahulu.');
        }

        Presensi::updateOrCreate(
            [
                'sesi_presensi_id' => $sesiId,
                'siswa_id' => $request->siswa_id,
            ],
            [
                'waktu_absen' => now(),
                'status' => $request->status,
            ]
        );

        return back()->with('success', 'Kehadiran berhasil dicatat secara manual.');
    }
}
