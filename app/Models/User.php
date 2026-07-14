<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'nis'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelasSaya()
    {
        return $this->belongsToMany(Kelas::class, 'siswa_kelas', 'siswa_id', 'kelas_id');
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTuaSiswa::class, 'siswa_id');
    }

    public function sesiPresensiGuru()
    {
        return $this->hasMany(SesiPresensi::class, 'guru_id');
    }

    public function presensiSaya()
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }

    public function anak()
    {
        return $this->belongsToMany(User::class, 'orang_tua_siswas', 'orang_tua_id', 'siswa_id');
    }

    public function orangTuaDari()
    {
        return $this->hasMany(OrangTuaSiswa::class, 'siswa_id');
    }

    public function materiSaya()
    {
        return $this->hasMany(Materi::class, 'siswa_id');
    }

    public function laporanSaya()
    {
        return $this->hasMany(LaporanAi::class, 'siswa_id');
    }
}
