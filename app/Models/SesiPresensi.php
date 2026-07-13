<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';

    protected $fillable = [
        'kelas_id', 'guru_id', 'mata_pelajaran', 'topik',
        'qr_token', 'qr_expired_at', 'is_active',
    ];

    protected $casts = [
        'qr_expired_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->qr_expired_at);
    }
}
