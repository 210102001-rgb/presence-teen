<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $kelas = ($this->isAdmin() ? Kelas::query() : Kelas::where('guru_id', $guru->id))->get();
        $today = Carbon::now();

        // Semua jadwal milik guru ini
        $jadwals = JadwalKelas::query()
            ->when(! $this->isAdmin(), fn ($q) => $q->where('guru_id', $guru->id))
            ->with('kelas')
            ->get()
            ->sortBy(fn ($j) => [JadwalKelas::$urutan[$j->hari] ?? 9, $j->jam_mulai]);

        // Jadwal hari ini
        $hariIni = $today->isWeekend()
            ? collect()
            : $jadwals->filter(fn ($j) => $j->hari === $this->hariIniLabel($today));

        $totalJam = $hariIni->reduce(function ($carry, $j) {
            $mulai = Carbon::createFromFormat('H:i:s', $j->jam_mulai);
            $selesai = Carbon::createFromFormat('H:i:s', $j->jam_selesai);

            return $carry + $mulai->diffInMinutes($selesai) / 60;
        }, 0);

        // Hari-hari dalam minggu ini untuk kalender
        $monday = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weekDays = collect(range(0, 4))->map(fn ($i) => $monday->copy()->addDays($i));

        // Susun jadwal per kolom hari untuk kalender
        $hariNama = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $warnaPalet = [
            // Biru muda — seperti "Matematika" di desain
            0 => ['bg' => '#dbeafe', 'text' => '#1e3a5f', 'border' => '#3b82f6'],
            // Krem/tan — seperti "Fisika" & "Seni Budaya" di desain
            1 => ['bg' => '#f5f0e0', 'text' => '#78530a', 'border' => '#c49a2e'],
            // Hijau gelap — seperti "Bahasa Inggris" di desain (primary brand)
            2 => ['bg' => '#005f2d', 'text' => '#ffffff', 'border' => '#003d1c'],
            // Lavender ungu
            3 => ['bg' => '#ede9fe', 'text' => '#4c1d95', 'border' => '#7c3aed'],
            // Biru slate — seperti "Sejarah" di desain
            4 => ['bg' => '#e0e7ef', 'text' => '#1e3a5f', 'border' => '#64748b'],
            // Rose pink
            5 => ['bg' => '#fce7f3', 'text' => '#831843', 'border' => '#db2777'],
        ];
        $colorMap = [];
        foreach ($jadwals as $j) {
            if (! isset($colorMap[$j->kelas_id])) {
                $idx = count($colorMap) % count($warnaPalet);
                $c = $warnaPalet[$idx];
                $colorMap[$j->kelas_id] = [
                    'class' => '',
                    'style' => "background-color:{$c['bg']};color:{$c['text']};border-left:4px solid {$c['border']};",
                    'badge' => "background-color:{$c['border']};",
                ];
            }
        }

        return view('guru.jadwal', compact(
            'kelas', 'jadwals', 'hariIni',
            'today', 'weekDays', 'hariNama',
            'totalJam', 'colorMap'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran' => 'required|string|max:100',
            'ruang' => 'nullable|string|max:50',
            'topik' => 'nullable|string|max:150',
        ]);

        $kelasPemilik = Kelas::findOrFail($request->kelas_id);

        JadwalKelas::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => $kelasPemilik->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai.':00',
            'jam_selesai' => $request->jam_selesai.':00',
            'mata_pelajaran' => $request->mata_pelajaran,
            'ruang' => $request->ruang,
            'topik' => $request->topik,
        ]);

        return redirect()->route('guru.jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function destroy(JadwalKelas $jadwal)
    {
        if (! $this->isAdmin() && $jadwal->guru_id !== auth()->id()) {
            abort(403);
        }
        $jadwal->delete();

        return redirect()->route('guru.jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function updatePertemuan(Request $request, JadwalKelas $jadwal)
    {
        if (! $this->isAdmin() && $jadwal->guru_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'jumlah_pertemuan' => 'required|integer|min:1|max:100',
        ]);

        $jadwal->update(['jumlah_pertemuan' => $request->jumlah_pertemuan]);

        return redirect()->route('guru.jadwal')->with('success', 'Jumlah pertemuan berhasil diperbarui.');
    }

    private function hariIniLabel(Carbon $date): string
    {
        $map = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];

        return $map[$date->dayOfWeekIso] ?? '';
    }
}
