<?php

namespace Database\Factories;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nilai>
 */
class NilaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tugas = Tugas::inRandomOrder()->first();
        $siswa = Siswa::inRandomOrder()->first();
        return [
            'siswa_id' => $siswa->id,
            'guru_id' => $tugas->guru_id,
            'tugas_id' => $tugas->id,
            'total_bobot' => 100,
            'total_skor' => $this->faker->randomNumber(2),
            'nilai' => $this->faker->randomNumber(2),
        ];
    }
}
