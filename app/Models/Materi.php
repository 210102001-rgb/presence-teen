<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = ['siswa_id', 'judul', 'materi_asli', 'ringkasan_ai'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
