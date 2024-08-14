<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\srt_pmhn_kmbali_biaya>
 */
class srt_pmhn_kmbali_biayaFactory extends Factory
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
            'dpt_id' => 1,
            'jnjg_id' => 1,
            'nama_mhw' => $this->faker->name,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => $this->faker->date('Y-m-d'),
        ];
    }
}
