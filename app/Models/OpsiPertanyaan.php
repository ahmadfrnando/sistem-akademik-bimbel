<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'opsi_pertanyaan';

    protected $guarded = ['id'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function jawaban_pilihan_ganda_siswa()
    {
        return $this->hasMany(JawabanPilihanGandaSiswa::class);
    }
}
