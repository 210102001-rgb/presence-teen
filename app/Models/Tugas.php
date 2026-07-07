<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = ['kelas_id', 'guru_id', 'judul', 'deskripsi', 'deadline'];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
