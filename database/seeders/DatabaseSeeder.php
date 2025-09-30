<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
            'role_id' => 1
        ]);

        \App\Models\Guru::factory()->create([
            'nama' => 'SIR SOFIANTO',
            'tgl_lahir' => '1990-01-01',
            'alamat' => 'Medan',
        ]);
        
        \App\Models\Guru::factory()->create([
            'nama' => 'MISS NAMIRA',
            'tgl_lahir' => '1990-01-01',
            'alamat' => 'Medan',
        ]);

        \App\Models\Guru::factory()->create([
            'nama' => 'SIR DODI',
            'tgl_lahir' => '1990-01-01',
            'alamat' => 'Medan',
        ]);

        $this->call([
            SiswaSeeder::class,
            JadwalSeeder::class,
            PembelajaranSeeder::class,
            TugasSeeder::class,
            NilaiSeeder::class
        ]);
    }
}
