<?php

namespace App\Http\Controllers;

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

        return view('presensi.guru-qr', [
            'kelas' => $kelasList,
            'selectedKelas' => $kelas,
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

        $sesi = SesiPresensi::where('qr_token', $request->token)
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
}
