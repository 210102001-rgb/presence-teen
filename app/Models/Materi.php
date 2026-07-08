<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = ['guru_id', 'judul', 'materi_asli', 'ringkasan_ai', 'file_path'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
