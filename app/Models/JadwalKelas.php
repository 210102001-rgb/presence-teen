<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    protected $table = 'jadwal_kelas';

    protected $fillable = [
        'kelas_id', 'guru_id', 'hari',
        'jam_mulai', 'jam_selesai',
        'mata_pelajaran', 'ruang', 'topik',
        'jumlah_pertemuan',
    ];

    // Urutan hari untuk sorting
    public static array $urutan = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Format "08:00 – 09:30"
    public function getJamLabelAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5).' – '.substr($this->jam_selesai, 0, 5);
    }
}
