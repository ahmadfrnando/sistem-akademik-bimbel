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
}
