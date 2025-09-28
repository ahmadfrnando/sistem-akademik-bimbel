<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'tgl_lahir',
        'alamat',
        'mapel_id',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($guru) {
            $user = User::create([
                'name' => $guru->nama,
                'username' => strtolower(str_replace(' ', '', $guru->nama)) . rand(10, 99),
                'password' => Hash::make('123'),
                'role_id' => 2,
            ]);
            $guru->user_id = $user->id;
        });

        static::updating(function ($guru) {
            $user = $guru->user;
            $user->update([
                'name' => $guru->nama,
            ]);
        });

        static::deleting(function ($guru) {
            $guru->user->delete();
        });
    }

    public function mapel()
    {
        return $this->belongsTo(RefMapel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function getJadwalBerjalan()
    {
        return $this->jadwal()
            ->where(function ($q) {
                $q->where('tanggal', '>', now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->where('tanggal', now()->toDateString())
                            ->where('jam_selesai', '>=', now()->format('H:i'));
                    });
            })
            ->get();
    }

    public function getCountJadwalTersedia()
    {
        $jadwalAvailId = $this->getJadwalBerjalan()->pluck('id');
        return Pembelajaran::whereNotIn('jadwal_id', $jadwalAvailId)->count() + Tugas::whereNotIn('jadwal_id', $jadwalAvailId)->count();
    }
    
    public function getPembelajaranBerjalan()
    {
        return Pembelajaran::whereIn('jadwal_id', $this->getJadwalBerjalan()->pluck('id'))->get();
    }

    public function getTugasBerjalan()
    {
        return Tugas::whereIn('jadwal_id', $this->getJadwalBerjalan()->pluck('id'))->get();
    }

    public function getSiswaPalingAktif()
    {
        return Siswa::withCount('jawaban_essay_siswa as jawaban_essay_siswa_count', 'jawaban_pilihan_ganda_siswa as jawaban_pilihan_ganda_siswa_count')
            ->orderBy('jawaban_essay_siswa_count', 'desc')
            ->orderBy('jawaban_pilihan_ganda_siswa_count', 'desc')
            ->limit(5)
            ->get();
    }
}
