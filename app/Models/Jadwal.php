<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function pembelajaran()
    {
        return $this->hasOne(Pembelajaran::class);
    }
    public function tugas()
    {
        return $this->hasOne(Tugas::class);
    }
}
