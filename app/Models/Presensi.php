<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'sesi_presensi_id', 'siswa_id', 'waktu_absen', 'status',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    public function sesi()
    {
        return $this->belongsTo(SesiPresensi::class, 'sesi_presensi_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
