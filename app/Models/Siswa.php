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
}
