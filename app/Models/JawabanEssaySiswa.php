<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanEssaySiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_essay_siswa';

    protected $guarded = ['id'];
}
