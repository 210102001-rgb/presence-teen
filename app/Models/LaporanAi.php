<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAi extends Model
{
    protected $fillable = ['siswa_id', 'periode', 'hasil_analisis', 'level_peringatan'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
