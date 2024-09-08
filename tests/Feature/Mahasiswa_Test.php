<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Mahasiswa_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_view_halaman_user_role_mahasiswa(): void
    {
        $response = $this->get('/user');

        $response->assertStatus(302);
    }

    public function test_view_halaman_my_account_user_role_mahasiswa(): void
    {
        $response = $this->get('/user/my_account');

        $response->assertStatus(302);
    }

    public function test_edit_user_role_mahasiswa(): void
    {
        $this->withoutExceptionHandling();
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/user/my_account/update', [
            'email' => $faker->unique()->safeEmail,
            'nama' => $faker->name,
            'nmr_unik' => $faker->unique()->numerify('##########'),
            'kota' => $faker->city,
            'tanggal_lahir' => $faker->date('Y-m-d'),
            'nama_ibu' => $faker->name('female'),
            'nowa' => $faker->phoneNumber,
            'almt_asl' => $faker->address,
            'prd_id' => 1,
            'password' => 'mountain082',
        ]);

        $response->assertStatus(302);
    }

    public function test_gagal_mengedit_akun_dengan_email_terduplikat(): void
    {

        $this->withoutExceptionHandling();
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
        ]);

        $this->actingAs($user);

        try {
            $this->post('/user/my_account/update', [
                'email' => 'raung@students.undip.ac.id',
                'nama' => $faker->name,
                'nmr_unik' => $faker->unique()->numerify('##########'),
                'kota' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d'),
                'nama_ibu' => $faker->name('female'),
                'nowa' => $faker->phoneNumber,
                'almt_asl' => $faker->address,
                'prd_id' => 1,
                'password' => 'mountain082',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertEquals('Email sudah digunakan, silakan masukkan Email yang lain', $e->validator->errors()->first('email'));
            return;
        }

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
}
