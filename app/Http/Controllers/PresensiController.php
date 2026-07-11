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

        $presensi = Presensi::create([
            'sesi_presensi_id' => $sesi->id,
            'siswa_id' => $siswaId,
            'waktu_absen' => now(),
            'status' => 'hadir', // logic telat bisa ditambah kalau ada jam mulai kelas
        ]);

        // Trigger notifikasi ke orang tua jika ada
        $userSiswa = auth()->user();
        if ($userSiswa->orangTua) {
            $ortu = $userSiswa->orangTua->orangTua;
            if ($ortu) {
                try {
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
