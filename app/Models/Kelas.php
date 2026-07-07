<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas', 'guru_id', 'mata_pelajaran'];
    public function sesiPresensi()
    {
        return $this->hasMany(SesiPresensi::class);
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'siswa_kelas', 'kelas_id', 'siswa_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
