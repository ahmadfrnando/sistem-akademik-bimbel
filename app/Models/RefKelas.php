<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKelas extends Model
{
    use HasFactory;

    protected $table = 'ref_kelas';

    protected $fillable = [
        'id',
        'nama_kelas',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function guru_kelas()
    {
        return $this->hasMany(GuruKelas::class, 'kelas_id');
    }
}
