<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_jadwal' => 'jadwal'. $this->faker->randomNumber(2),
            'tanggal' => $this->faker->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            'jam_mulai' => $this->faker->dateTimeBetween('08:00:00', '12:00:00'),
            'jam_selesai' => $this->faker->dateTimeBetween('13:00:00', '17:00:00'),
            'guru_id' => Guru::pluck('id')->random(),
            'keterangan' => $this->faker->sentences(3, true),
        ];
    }
}
