<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Manajer_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_view_halaman_manajer(): void
    {
        $response = $this->get('/manajer');

        $response->assertStatus(302);
    }

    public function test_update_manajemen_sv_akd(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'manajer@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'manajer',
        ]);
        $this->actingAs($user);

        $sv = DB::table('users')->insertGetId([
            'nama' => $faker->name,
            'nmr_unik' => $faker->unique()->numerify('######'),
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('mountain082'),
            'role' => 'supervisor_akd',
        ]);

        $newEmail = $faker->unique()->safeEmail;

        $response = $this->post("/manajer/manage_spv/edit/{$sv}", [
            'nama' => $faker->unique()->name,
            'nmr_unik' => $faker->unique()->numerify('######'),
            'email' => $newEmail,
            'password' => Hash::make('12345678'),
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $sv,
            'email' => $newEmail,
        ]);
    }
}
