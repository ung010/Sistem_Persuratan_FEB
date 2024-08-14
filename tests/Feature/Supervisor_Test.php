<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Supervisor_Test extends TestCase
{
    public function test_view_halaman_sv_akd(): void
    {
        $response = $this->get('/supervisor_akd');

        $response->assertStatus(302);
    }

    public function test_view_halaman_admin_sv_akademik(): void
    {
        $response = $this->get('/supervisor_akd/manage_admin');

        $response->assertStatus(302);
    }

    public function test_buat_admin_sv_akademik(): void
    {
        $this->withoutExceptionHandling();
        $faker = \Faker\Factory::create();

        $sv = \App\Models\User::factory()->create([
            'email' => 'akd@example.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor_akd',
        ]);

        $this->actingAs($sv);

        $response = $this->post('/supervisor_akd/manage_admin/create', [
            'email' => $faker->unique()->safeEmail,
            'nama' => $faker->name,
            'nmr_unik' => $faker->unique()->numerify('##########'),
            'role' => 'admin',
            'password' => 'mountain082',
        ]);

        $response->assertStatus(302);
    }

    public function test_update_manajemen_admin(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'akd@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'supervisor_akd',
        ]);
        $this->actingAs($user);

        $sv = DB::table('users')->insertGetId([
            'nama' => $faker->name,
            'nmr_unik' => $faker->unique()->numerify('######'),
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('mountain082'),
            'role' => 'admin',
        ]);

        $newEmail = $faker->unique()->safeEmail;

        $response = $this->post("/supervisor_akd/manage_admin/edit/{$sv}", [
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

    public function test_permanent_delete_admin()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'akd@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'supervisor_akd',
        ]);
        $this->actingAs($user);

        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->post("/supervisor_akd/manage_admin/delete/{$non_mhw->id}");

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Data admin berhasil dihapuskan');

        $this->assertDatabaseMissing('users', [
            'id' => $non_mhw->id,
        ]);
    }
}
