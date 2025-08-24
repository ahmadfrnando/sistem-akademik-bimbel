<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruKelas extends Model
{
    use HasFactory;

    protected $table = 'guru_kelas';

    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(RefMapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(RefKelas::class);
    }
}
