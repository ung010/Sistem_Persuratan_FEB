<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Surat_ASN_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_halaman_surat_mahasiswa_asn(): void
    {
        $response = $this->get('/srt_mhw_asn');

        $response->assertStatus(302);
    }

    public function test_buat_surat_baru(): void
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

        $response = $this->post('/srt_mhw_asn/create', [
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'nama_ortu' => $faker->name,
            'nip_ortu' => $faker->numerify('#######'),
            'ins_ortu' => $faker->company,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_mhw_asn');
    }

    public function test_view_halaman_edit_surat_mahasiswa_asn(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
        ]);

        $this->actingAs($user);

        $surat = DB::table('srt_mhw_asn')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'nim_mhw' => $user->nmr_unik,
            'nowa_mhw' => $user->nowa,
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'nama_ortu' => 'Nama Ortu Lama',
            'nip_ortu' => '1234567890',
            'ins_ortu' => 'Instansi Lama',
            'jenjang_prodi' => 'S1 - Ekonomi',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->get("/srt_mhw_asn/edit/{$surat}");

        $response->assertStatus(200);
    }


    public function test_update_surat_mahasiswa_asn(): void
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

        $surat = DB::table('srt_mhw_asn')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'nim_mhw' => $user->nmr_unik,
            'nowa_mhw' => $user->nowa,
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'nama_ortu' => 'Nama Ortu Lama',
            'nip_ortu' => '1234567890',
            'ins_ortu' => 'Instansi Lama',
            'jenjang_prodi' => 'S1 - Ekonomi',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_mhw_asn/update/{$surat}", [
            'thn_awl' => 2021,
            'thn_akh' => 2025,
            'semester' => 7,
            'nama_ortu' => $faker->name,
            'nip_ortu' => $faker->numerify('##########'),
            'ins_ortu' => $faker->company,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_mhw_asn');

        $this->assertDatabaseHas('srt_mhw_asn', [
            'id' => $surat,
            'thn_awl' => 2021,
            'thn_akh' => 2025,
            'semester' => 7,
        ]);
    }

    public function test_search_surat_mahasiswa_asn(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
        ]);

        $this->actingAs($user);

        $surat = \App\Models\srt_mhw_asn::factory()->create([
            'nama_mhw' => 'John Doe',
            'nama_ortu' => 'Jane Doe',
            'nip_ortu' => '1234567890',
            'ins_ortu' => 'Instansi',
            'thn_awl' => '2020',
            'thn_akh' => '2024',
            'semester' => '6',
        ]);

        $response = $this->get('/srt_mhw_asn/search?search=John+Doe');

        $response->assertStatus(200);
        $response->assertDontSeeText('Jane Smith');
    }

    public function test_Download_Surat_Mahasiswa_ASN()
    {
        $id = 1;

        $response = $this->get("/srt_mhw_asn/download/{$id}");

        $response->assertStatus(302);
    }

    public function test_halaman_surat_mahasiswa_asn_admin(): void
    {
        $response = $this->get('/srt_mhw_asn/admin');

        $response->assertStatus(302);
    }

    public function test_cek_surat_mhw_asn()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $suratId = DB::table('srt_mhw_asn')->insertGetId([
            'users_id' => $admin->id,
            'nama_mhw' => 'Raung Calon Sarjana',
            'nim_mhw' => '123456789',
            'nowa_mhw' => '08123456789',
            'thn_awl' => 2020,
            'thn_akh' => 2024,
            'semester' => 6,
            'nama_ortu' => 'Jane Doe',
            'nip_ortu' => '987654321',
            'ins_ortu' => 'Some Institution',
            'jenjang_prodi' => 'S1 - Ekonomi',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
            'prd_id' => 1,
            'dpt_id' => 1,
            'jnjg_id' => 1,
        ]);

        $response = $this->get("/srt_mhw_asn/admin/cek_surat/{$suratId}");

        $response->assertStatus(200);
        $response->assertSee('Cek Surat keterangan untuk anak ASN');
    }

    public function test_setuju_surat_mhw_asn()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $srtMhwAsn = \App\Models\Srt_Mhw_Asn::factory()->create([
            'no_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_mhw_asn/admin/cek_surat/setuju/{$srtMhwAsn->id}", [
            'no_surat' => '123456789',
        ]);

        $response->assertRedirect(route('srt_mhw_asn.admin'));
        $response->assertSessionHas('success', 'No surat berhasil ditambahkan');

        $this->assertDatabaseHas('srt_mhw_asn', [
            'id' => $srtMhwAsn->id,
            'no_surat' => '123456789',
            'role_surat' => 'supervisor_akd',
        ]);
    }

    public function test_tolak_surat_mhw_asn()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $srtMhwAsn = \App\Models\Srt_Mhw_Asn::factory()->create([
            'catatan_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_mhw_asn/admin/cek_surat/tolak/{$srtMhwAsn->id}", [
            'catatan_surat' => 'Dokumen tidak lengkap',
        ]);

        $response->assertRedirect(route('srt_mhw_asn.admin'));
        $response->assertSessionHas('success', 'Alasan penolakan telah dikirimkan');

        $this->assertDatabaseHas('srt_mhw_asn', [
            'id' => $srtMhwAsn->id,
            'catatan_surat' => 'Dokumen tidak lengkap',
            'role_surat' => 'tolak',
        ]);
    }

    public function test_halaman_surat_mahasiswa_asn_sv(): void
    {
        $response = $this->get('/srt_mhw_asn/supervisor');

        $response->assertStatus(302);
    }

    public function test_supervisor_setuju()
    {
        $supervisor = \App\Models\User::factory()->create([
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor_akd',
        ]);

        $this->actingAs($supervisor);

        $srtMhwAsn = \App\Models\Srt_Mhw_Asn::factory()->create([
            'role_surat' => 'supervisor_akd',
        ]);

        $response = $this->post("/srt_mhw_asn/supervisor/setuju/{$srtMhwAsn->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_mhw_asn', [
            'id' => $srtMhwAsn->id,
            'role_surat' => 'manajer',
        ]);
    }

    public function test_halaman_surat_mahasiswa_asn_manajer(): void
    {
        $response = $this->get('/srt_mhw_asn/manajer');

        $response->assertStatus(302);
    }

    public function test_manajer_setuju()
    {
        $supervisor = \App\Models\User::factory()->create([
            'email' => 'manajer@example.com',
            'password' => bcrypt('password'),
            'role' => 'manajer',
        ]);

        $this->actingAs($supervisor);

        $srtMhwAsn = \App\Models\Srt_Mhw_Asn::factory()->create([
            'role_surat' => 'supervisor_akd',
        ]);

        $response = $this->post("/srt_mhw_asn/manajer/setuju/{$srtMhwAsn->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_mhw_asn', [
            'id' => $srtMhwAsn->id,
            'role_surat' => 'mahasiswa',
        ]);
    }
}
