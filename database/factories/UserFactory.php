<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'nmr_unik' => $this->faker->unique()->numerify('######'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('mountain082'),
            'kota' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'status' => 'mahasiswa',
            'nowa' => $this->faker->phoneNumber,
            'nama_ibu' => $this->faker->name,
            'almt_asl' => $this->faker->address,
            'dpt_id' => 4,
            'prd_id' => 5,
            'jnjg_id' => 2,
            'role' => 'mahasiswa',
            // 'role' => $this->faker->randomElement(['mahasiswa', 'non_mahasiswa', 'del_mahasiswa']),
            'catatan_user' => '-',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
