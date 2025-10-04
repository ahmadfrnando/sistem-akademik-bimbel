<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($siswa) {
            $user = User::create([
                'name' => $siswa->nama,
                'username' => strtolower(str_replace(' ', '', $siswa->nama)) . rand(10, 99),
                'password' => Hash::make('123'),
                'role_id' => 3,
            ]);
            $siswa->user_id = $user->id;
        });

        static::updating(function ($siswa) {
            $user = $siswa->user;
            $user->update([
                'name' => $siswa->nama,
            ]);
        });

        static::deleting(function ($siswa) {
            $siswa->user->delete();
        });
    }

    public function kelas()
    {
        return $this->belongsTo(RefKelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Setiap siswa dimiliki oleh satu user
    }

    public function jawaban_pilihan_ganda_siswa()
    {
        return $this->hasMany(JawabanPilihanGandaSiswa::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function tugasSelesai()
    {
        return $this->belongsToMany(Tugas::class, 'nilai', 'siswa_id', 'tugas_id')
            ->withPivot('nilai', 'created_at')
            ->wherePivotNotNull('nilai');
    }

    public function tugasBelumSelesai()
    {   
        $id = $this->id;
        return Tugas::whereDoesntHave('nilai', function ($query) use ($id) {
            $query->where('siswa_id', $id);
        })
        ->whereHas('jadwal', function ($query) {
            $query->where('tanggal', '>=', date('Y-m-d'))
            ->where('jam_selesai', '<=', date('H:i:s'));
        });
    }

    public function pembelajaranAktif()
    {
        return Pembelajaran::whereHas('jadwal', function ($query) {
            $query->where('tanggal', '>=', date('Y-m-d'))
                ->where('jam_selesai', '>=', date('H:i:s'));
        });
    }
}
