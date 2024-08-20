<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\legalisir>
 */
class legalisirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'users_id' => \App\Models\User::factory(),
            'prd_id' => 1,
            'nama_mhw' => $this->faker->name,
            'jenis_lgl' => $this->faker->randomElement(['ijazah' ,'transkrip', 'ijazah_transkrip']),
            'ambil' => $this->faker->randomElement(['ditempat' ,'dikirim']),
            'file_ijazah' => 'file_ijazah.pdf',
            'file_transkrip' => 'file_transkrip.pdf',
            'keperluan' => $this->faker->sentence(),
            'tgl_lulus' => $this->faker->date('Y-m-d'),
            'tanggal_surat' => $this->faker->date('Y-m-d'),
        ];
    }
}
