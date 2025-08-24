<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $guarded = ['id'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function opsi()
    {
        return $this->hasMany(OpsiPertanyaan::class);
    }

    public function jawaban_pilihan_ganda_siswa()
    {
        return $this->hasMany(JawabanPilihanGandaSiswa::class);
    }

    public function jawaban_essay_siswa()
    {
        return $this->hasMany(JawabanEssaySiswa::class);
    }
}
