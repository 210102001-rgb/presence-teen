<?php

namespace App\Console\Commands;

use App\Models\LaporanAi;
use App\Models\PengumpulanTugas;
use App\Models\Presensi;
use App\Models\SiswaKelas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('app:analisis-kehadiran')]
#[Description('Analisis pola kehadiran & pengumpulan tugas siswa via AI secara periodik')]
class AnalisisKehadiranCommand extends Command
{
    public function handle()
    {
        $siswaIds = SiswaKelas::distinct()->pluck('siswa_id');
        $periode = now()->startOfWeek()->format('Y-m-d').' - '.now()->endOfWeek()->format('Y-m-d');

        foreach ($siswaIds as $siswaId) {
            $siswa = User::find($siswaId);
            if (! $siswa) {
                continue;
            }

            $presensi = Presensi::where('siswa_id', $siswaId)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->get();

            $tugas = Tugas::whereIn('kelas_id', function ($q) use ($siswaId) {
                $q->select('kelas_id')->from('siswa_kelas')->where('siswa_id', $siswaId);
            })->whereBetween('deadline', [now()->startOfWeek(), now()->endOfWeek()])->get();

            $dikumpulkan = PengumpulanTugas::where('siswa_id', $siswaId)
                ->where('status', 'sudah')
                ->whereBetween('waktu_kumpul', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            $totalHadir = $presensi->where('status', 'hadir')->count();
            $totalTelat = $presensi->where('status', 'telat')->count();
            $totalTugas = $tugas->count();

            $data = "Siswa: {$siswa->name}\nHadir: {$totalHadir}\nTelat: {$totalTelat}\nTotal Tugas: {$totalTugas}\nTugas Dikumpulkan: {$dikumpulkan}";

            try {
                $response = Http::withOptions([
                    'base_uri' => config('services.ai.base_url'),
                    'verify' => false,
                ])
                    ->withHeaders([
                        'x-api-key' => config('services.ai.api_key'),
                        'anthropic-version' => config('services.ai.version'),
                    ])
                    ->post('messages', [
                        'model' => config('services.ai.model'),
                        'max_tokens' => 1000,
                        'messages' => [[
                            'role' => 'user',
                            'content' => "Analisis pola kehadiran dan tugas siswa berikut. Berikan level peringatan (aman/perhatian/kritis) dan rekomendasi:\n\n{$data}",
                        ]],
                    ]);

                $hasil = $response->json('content.0.text') ?? 'Tidak ada analisis.';

                $level = 'aman';
                if ($totalTelat > 2 || ($totalTugas > 0 && $dikumpulkan < $totalTugas / 2)) {
                    $level = 'perhatian';
                }
                if ($totalTelat > 4 || ($totalHadir == 0 && $presensi->count() > 0)) {
                    $level = 'kritis';
                }

                LaporanAi::create([
                    'siswa_id' => $siswaId,
                    'periode' => $periode,
                    'hasil_analisis' => $hasil,
                    'level_peringatan' => $level,
                ]);

                $this->info("Analisis {$siswa->name}: {$level}");
            } catch (\Exception $e) {
                $this->error("Gagal analisis {$siswa->name}: {$e->getMessage()}");
            }
        }

        $this->info('Analisis periodik selesai.');
    }
}
