<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'nmr_unik' => $this->faker->unique()->numerify('######'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
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
            'catatan_user' => $this->faker->text,
        ];
    }
}
