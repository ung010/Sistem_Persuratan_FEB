<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Surat_Masih_MHW_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_halaman_surat_masih_kuliah(): void
    {
        $response = $this->get('/srt_masih_mhw');

        $response->assertStatus(302);
    }

    public function test_buat_surat_baru_manajer(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'jnjg_id' => 1,
            'prd_id' => 1,
            'dpt_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->post('/srt_masih_mhw/create', [
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'almt_smg' => $faker->address(),
            'tujuan_buat_srt' => $faker->sentence(),
            'tujuan_akhir' => 'manajer',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_masih_mhw');
    }

    public function test_buat_surat_baru_wd(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'jnjg_id' => 1,
            'prd_id' => 1,
            'dpt_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->post('/srt_masih_mhw/create', [
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'almt_smg' => $faker->address(),
            'tujuan_buat_srt' => $faker->sentence(),
            'tujuan_akhir' => 'wd',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_masih_mhw');
    }

    public function test_view_halaman_edit_surat_masih_mhw(): void
    {

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => 1,
            'dpt_id' => 1,
            'jnjg_id' => 1,
            'nama' => 'Raung Calon Sarjana',
        ]);

        $this->actingAs($user);

        $surat = DB::table('srt_masih_mhw')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'almt_smg' => $faker->address(),
            'tujuan_buat_srt' => $faker->sentence(),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->get("/srt_masih_mhw/edit/{$surat}");


        $response->assertStatus(200);

        $response->assertSee('Raung Calon Sarjana');
    }

    public function test_update_surat_mahasiswa_asn(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => 1,
            'dpt_id' => 1,
            'jnjg_id' => 1,
            'nama' => 'Raung Calon Sarjana',
        ]);
        $this->actingAs($user);

        $surat = DB::table('srt_masih_mhw')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'almt_smg' => $faker->address(),
            'tujuan_buat_srt' => $faker->sentence(),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_masih_mhw/update/{$surat}", [
            'thn_awl' => 2020,
            'thn_akh' => 2021,
            'semester' => 3,
            'almt_smg' => $faker->address(),
            'tujuan_buat_srt' => $faker->sentence(),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_masih_mhw');

        $this->assertDatabaseHas('srt_masih_mhw', [
            'id' => $surat,
            'thn_awl' => 2020,
            'thn_akh' => 2021,
            'semester' => 3,
        ]);
    }

    public function test_halaman_surat_masih_mahasiswa_manajer(): void
    {
        $response = $this->get('/srt_masih_mhw/admin');

        $response->assertStatus(302);
    }

    public function test_search_surat_masih_mahasiswa_manajer(): void
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $surat = \App\Models\srt_masih_mhw::factory()->create([
            'nama_mhw' => 'Raung',
            'tujuan_buat_srt' => 'Berkeluarga',
            'almt_smg' => 'Semarang',
            'thn_awl' => '2020',
            'thn_akh' => '2024',
            'semester' => '6',
        ]);

        $response = $this->get('/srt_masih_mhw/admin/search?search=Raung');

        $response->assertStatus(200);
        $response->assertDontSeeText('Kawijayan');
        $response->assertSeeText('Raung');
    }

    public function test_cek_surat_srt_masih_mhw_manajer()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $suratId = DB::table('srt_masih_mhw')->insertGetId([
            'users_id' => $admin->id,
            'nama_mhw' => 'Raung Calon Sarjana',
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'tujuan_buat_srt' => 'Berkeluarga',
            'almt_smg' => 'Semarang',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
            'prd_id' => 1,
            'dpt_id' => 1,
            'jnjg_id' => 1,
        ]);

        $response = $this->get("/srt_masih_mhw/admin/cek_surat/{$suratId}");

        $response->assertStatus(200);
    }

    public function test_setuju_surat_masih_mhw_manajer()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $srtMhwAsn = \App\Models\srt_masih_mhw::factory()->create([
            'no_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_masih_mhw/admin/cek_surat/setuju/{$srtMhwAsn->id}", [
            'no_surat' => '123456789',
        ]);

        $response->assertRedirect(route('srt_masih_mhw.admin'));
        $response->assertSessionHas('success', 'No surat berhasil ditambahkan');

        $this->assertDatabaseHas('srt_masih_mhw', [
            'id' => $srtMhwAsn->id,
            'no_surat' => '123456789',
            'role_surat' => 'supervisor_akd',
        ]);
    }

    public function test_tolak_surat_masih_mhw_manajer()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $srtMhwAsn = \App\Models\srt_masih_mhw::factory()->create([
            'catatan_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_masih_mhw/admin/cek_surat/tolak/{$srtMhwAsn->id}", [
            'catatan_surat' => 'Dokumen tidak lengkap',
        ]);

        $response->assertRedirect(route('srt_masih_mhw.admin'));
        $response->assertSessionHas('success', 'Alasan penolakan telah dikirimkan');

        $this->assertDatabaseHas('srt_masih_mhw', [
            'id' => $srtMhwAsn->id,
            'catatan_surat' => 'Dokumen tidak lengkap',
            'role_surat' => 'tolak',
        ]);
    }

    public function test_halaman_surat_masih_mahasiswa_wd(): void
    {
        $response = $this->get('/srt_masih_mhw/manajer_wd');

        $response->assertStatus(302);
    }

    public function test_search_surat_masih_mahasiswa_wd(): void
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $surat = \App\Models\srt_masih_mhw::factory()->create([
            'nama_mhw' => 'Raung',
            'tujuan_buat_srt' => 'Bekerja',
            'almt_smg' => 'Semarang',
            'thn_awl' => '2020',
            'thn_akh' => '2024',
            'semester' => '6',
        ]);

        $response = $this->get('/srt_masih_mhw/manajer_wd/search?search=Raung');

        $response->assertStatus(200);
        $response->assertDontSeeText('Smith');
        $response->assertSeeText('Raung');
    }

    public function test_cek_surat_srt_masih_mhw_wd()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $suratId = DB::table('srt_masih_mhw')->insertGetId([
            'users_id' => $admin->id,
            'nama_mhw' => 'Raung Calon Sarjana',
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'tujuan_buat_srt' => 'Berkeluarga',
            'almt_smg' => 'Semarang',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
            'prd_id' => 1,
            'dpt_id' => 1,
            'jnjg_id' => 1,
        ]);

        $response = $this->get("/srt_masih_mhw/manajer_wd/cek_surat/{$suratId}");

        $response->assertStatus(200);
    }

    public function test_setuju_surat_masih_mhw_wd()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $srtMhwAsn = \App\Models\srt_masih_mhw::factory()->create([
            'no_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_masih_mhw/manajer_wd/cek_surat/setuju/{$srtMhwAsn->id}", [
            'no_surat' => '123456789',
        ]);

        $response->assertRedirect(route('srt_masih_mhw.wd'));
        $response->assertSessionHas('success', 'No surat berhasil ditambahkan');

        $this->assertDatabaseHas('srt_masih_mhw', [
            'id' => $srtMhwAsn->id,
            'no_surat' => '123456789',
            'role_surat' => 'supervisor_akd',
        ]);
    }

    public function test_tolak_surat_masih_mhw_wd()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $srtMhwAsn = \App\Models\srt_masih_mhw::factory()->create([
            'catatan_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_masih_mhw/manajer_wd/cek_surat/tolak/{$srtMhwAsn->id}", [
            'catatan_surat' => 'Dokumen tidak lengkap',
        ]);

        $response->assertRedirect(route('srt_masih_mhw.wd'));
        $response->assertSessionHas('success', 'Alasan penolakan telah dikirimkan');

        $this->assertDatabaseHas('srt_masih_mhw', [
            'id' => $srtMhwAsn->id,
            'catatan_surat' => 'Dokumen tidak lengkap',
            'role_surat' => 'tolak',
        ]);
    }
}
