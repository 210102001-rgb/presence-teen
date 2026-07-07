<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTuaSiswa extends Model
{
    protected $fillable = ['orang_tua_id', 'siswa_id'];

    public function orangTua()
    {
        return $this->belongsTo(User::class, 'orang_tua_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
