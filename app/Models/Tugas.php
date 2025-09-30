<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    protected $guarded = ['id'];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    // public function kategori_tugas()
    // {
    //     return $this->belongsTo(RefKategoriTugas::class);
    // }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function jawabanPilihanGandaSiswa()
    {
        return $this->hasManyThrough(
            JawabanPilihanGandaSiswa::class,     // model tujuan
            Pertanyaan::class,  // model perantara
            'tugas_id',         // foreign key di tabel pertanyaan
            'pertanyaan_id',    // foreign key di tabel jawaban
            'id',               // local key di tabel tugas
            'id'                // local key di tabel pertanyaan
        );
    }
}
