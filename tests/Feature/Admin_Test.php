<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Admin_Test extends TestCase
{
    
    public function test_view_halaman_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
    }


    public function test_view_halaman_manajemen_user(): void
    {
        $response = $this->get('/admin/user');

        $response->assertStatus(302);
    }

    public function test_view_halaman_edit_manajemen_user(): void
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $mhw = DB::table('users')->insertGetId([
            'nama' => $faker->name,
            'nmr_unik' => $faker->unique()->numerify('######'),
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('mountain082'),
            'kota' => $faker->city,
            'tanggal_lahir' => $faker->date,
            'status' => 'mahasiswa',
            'nowa' => $faker->phoneNumber,
            'nama_ibu' => $faker->name,
            'almt_asl' => $faker->address,
            'dpt_id' => 4,
            'prd_id' => 5,
            'jnjg_id' => 2,
            'role' => 'mahasiswa',
            'catatan_user' => '-',
        ]);

        $response = $this->get("/admin/user/edit/{$mhw}");

        $response->assertStatus(200);
    }


    public function test_update_manajemen_user(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'admin',
        ]);
        $this->actingAs($user);

        $mhw = DB::table('users')->insertGetId([
            'nama' => $faker->name(),
            'nmr_unik' => $faker->unique()->numerify('##########'),
            'email' => $faker->email,
            'password' => Hash::make('mountain082'),
        ]);

        $newEmail = $faker->unique()->safeEmail;

        $response = $this->post("/admin/user/update/{$mhw}", [
            'email' => $newEmail,
            'password' => Hash::make('12345678'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/user');

        $this->assertDatabaseHas('users', [
            'id' => $mhw,
            'email' => $newEmail,
        ]);
    }

    public function test_view_halaman_manajemen_akun_belum_approve(): void
    {
        $response = $this->get('/admin/verif_user');

        $response->assertStatus(302);
    }

    public function test_cek_verif_user()
    {
        $faker = \Faker\Factory::create();

        $prodi = DB::table('prodi')->insertGetId([
            'nama_prd' => 'Prodi Test',
        ]);

        $departement = DB::table('departement')->insertGetId([
            'nama_dpt' => 'Departemen Test',
        ]);

        $jenjang = DB::table('jenjang_pendidikan')->insertGetId([
            'nama_jnjg' => 'Jenjang Test',
        ]);

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nama' => 'Admin_Uhuy',
        ]);

        $this->actingAs($user);

        $non_mhw = DB::table('users')->insertGetId([
            'nama' => 'Raung Kawijayan',
            'nmr_unik' => $faker->unique()->numerify('##########'),
            'email' => $faker->email,
            'password' => Hash::make('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => $prodi,
            'dpt_id' => $departement,
            'jnjg_id' => $jenjang,
        ]);

        $response = $this->get("/admin/verif_user/cekdata/{$non_mhw}");

        $response->assertStatus(200);
    }


    public function test_approve_non_mahasiswa()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'non_mahasiswa',
        ]);

        $response = $this->post("/admin/verif_user/cekdata/verifikasi/{$non_mhw->id}", [
            'catatan_user' => '-',
        ]);

        $response->assertRedirect(route('admin.verifikasi'));
        $response->assertSessionHas('success', 'Akun telah diverifikasi');

        $this->assertDatabaseHas('users', [
            'id' => $non_mhw->id,
            'role' => 'mahasiswa',
        ]);
    }

    public function test_tolak_non_mahasiswa()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'non_mahasiswa',
        ]);

        $response = $this->post("/admin/verif_user/cekdata/catatan/{$non_mhw->id}", [
            'catatan_user' => 'Data ada yang salah',
        ]);

        $response->assertRedirect(route('admin.verifikasi'));
        $response->assertSessionHas('success', 'Catatan berhasil ditambahkan');

        $this->assertDatabaseHas('users', [
            'id' => $non_mhw->id,
            'catatan_user' => 'Data ada yang salah',
        ]);
    }

    public function test_view_halaman_soft_delete(): void
    {
        $response = $this->get('/admin/soft_delete');

        $response->assertStatus(302);
    }

    public function test_soft_delete_akun()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'mahasiswa',
        ]);

        $response = $this->post("/admin/soft_delete/s_delete/{$non_mhw->id}", [
            'catatan_user' => '-',
        ]);

        $response->assertRedirect(route('admin.user'));
        $response->assertSessionHas('success', 'Akun berhasil dihapus sementara');

        $this->assertDatabaseHas('users', [
            'id' => $non_mhw->id,
            'role' => 'del_mahasiswa',
        ]);
    }

    public function test_restore_akun_soft_delete()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'del_mahasiswa',
        ]);

        $response = $this->post("/admin/soft_delete/restore/{$non_mhw->id}", [
            'catatan_user' => '-',
        ]);

        $response->assertRedirect(route('admin.user'));
        $response->assertSessionHas('success', 'Akun berhasil dipulihkan');

        $this->assertDatabaseHas('users', [
            'id' => $non_mhw->id,
            'role' => 'mahasiswa',
        ]);
    }

    public function test_permanent_delete_akun()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $non_mhw = \App\Models\User::factory()->create([
            'role' => 'del_mahasiswa',
        ]);

        $response = $this->post("/admin/soft_delete/h_delete/{$non_mhw->id}");

        $response->assertRedirect(route('admin.user'));
        $response->assertSessionHas('success', 'Berhasil menghapus permanen akun');

        $this->assertDatabaseMissing('users', [
            'id' => $non_mhw->id,
        ]);
    }
}
