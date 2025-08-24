<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelajaran>
 */
class PembelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $jadwal = Jadwal::findOrFail(1);
        return [
            'judul' => fake()->sentence(),
            'file' => 'example/test.pdf',
            'guru_id' => $jadwal->guru_id,
            'jadwal_id' => $jadwal->id,
            'keterangan' => fake()->sentence(),
        ];
    }
}
