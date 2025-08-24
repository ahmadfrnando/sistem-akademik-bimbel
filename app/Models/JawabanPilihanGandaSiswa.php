<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPilihanGandaSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_pilihan_ganda_siswa';

    protected $guarded = ['id'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function opsi_pertanyaan()
    {
        return $this->belongsTo(OpsiPertanyaan::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
