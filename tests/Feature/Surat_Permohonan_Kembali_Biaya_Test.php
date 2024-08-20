<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Surat_Permohonan_Kembali_Biaya_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_halaman_surat_permohonan_pengembalian_biaya(): void
    {
        $response = $this->get('/srt_pmhn_kmbali_biaya');

        $response->assertStatus(302);
    }

    public function test_pembuatan_surat_pmhn_kmbali_biaya(): void
    {
        $this->withoutExceptionHandling();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'prd_id' => 1,
        ]);

        $this->actingAs($user);

        $skl = UploadedFile::fake()->create('skl.pdf', 100, 'application/pdf');
        $bukti_bayar = UploadedFile::fake()->create('bukti_bayar.pdf', 100, 'application/pdf');
        $buku_tabung = UploadedFile::fake()->create('buku_tabung.pdf', 100, 'application/pdf');

        $response = $this->post('/srt_pmhn_kmbali_biaya/create', [
            'skl' => $skl,
            'buku_tabung' => $buku_tabung,
            'bukti_bayar' => $bukti_bayar,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('srt_pmhn_kmbali_biaya.index'));

        $nama_skl = 'SKL_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';
        $nama_bukti = 'Bukti_Bayar_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';
        $nama_buku = 'Buku_Tabungan_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'users_id' => $user->id,
            'nama_mhw' => $user->nama,
            'skl' => $nama_skl,
            'bukti_bayar' => $nama_bukti,
            'buku_tabung' => $nama_buku,
        ]);
    }

    public function test_error_pembuatan_surat_pmhn_kmbali_biaya_salah_format(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'prd_id' => 1,
        ]);

        $this->actingAs($user);

        $skl = UploadedFile::fake()->create('skl.png', 100, 'image/png');
        $bukti_bayar = UploadedFile::fake()->create('bukti_bayar.png', 100, 'image/png');
        $buku_tabung = UploadedFile::fake()->create('buku_tabung.png', 100, 'image/png');

        try {
            $response = $this->post('/srt_pmhn_kmbali_biaya/create', [
                'skl' => $skl,
                'buku_tabung' => $buku_tabung,
                'bukti_bayar' => $bukti_bayar,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['skl', 'buku_tabung', 'bukti_bayar']);

        $this->assertDatabaseMissing('srt_pmhn_kmbali_biaya', [
            'users_id' => $user->id,
            'nama_mhw' => $user->nama,
        ]);
    }

    public function test_view_halaman_edit_srt_pmhn_kmbali_biaya(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => 1,
            'nama' => 'Raung Calon Sarjana',
        ]);

        $this->actingAs($user);

        $surat = DB::table('srt_pmhn_kmbali_biaya')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->get("/srt_pmhn_kmbali_biaya/edit/{$surat}");


        $response->assertStatus(200);

        $response->assertSee('Raung Calon Sarjana');
    }

    public function test_update_surat_pmhn_kmbali_biaya(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => 1,
            'nama' => 'Raung Calon Sarjana',
        ]);

        $this->actingAs($user);

        $surat = DB::table('srt_pmhn_kmbali_biaya')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $new_skl = UploadedFile::fake()->create('skl_2.pdf', 100, 'application/pdf');
        $new_bukti_bayar = UploadedFile::fake()->create('bukti_bayar_2.pdf', 100, 'application/pdf');
        $new_buku_tabung = UploadedFile::fake()->create('buku_tabung_2.pdf', 100, 'application/pdf');

        $response = $this->post("/srt_pmhn_kmbali_biaya/update/{$surat}", [
            'skl' => $new_skl,
            'buku_tabung' => $new_buku_tabung,
            'bukti_bayar' => $new_bukti_bayar,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_pmhn_kmbali_biaya');

        $formatted_skl = 'SKL_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';
        $formatted_bukti_bayar = 'Bukti_Bayar_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';
        $formatted_buku_tabung = 'Buku_Tabungan_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.pdf';

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat,
            'skl' => $formatted_skl,
            'buku_tabung' => $formatted_buku_tabung,
            'bukti_bayar' => $formatted_bukti_bayar,
        ]);
    }
    public function test_download_srt_pmhn_kmbali_biaya_mahasiswa()
    {
        $id = 6;

        $response = $this->get("/srt_pmhn_kmbali_biaya/download/{$id}");

        $response->assertStatus(302);
    }

    public function test_download_srt_pmhn_kmbali_biaya_admin()
    {
        $id = 4;

        $response = $this->get("/srt_pmhn_kmbali_biaya/admin/download/{$id}");

        $response->assertStatus(302);
    }

    public function test_unggah_srt_pmhn_kmbali_biaya_admin()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');

        $this->actingAs($user);

        $response = $this->post(route('srt_pmhn_kmbali_biaya.admin_unggah', $surat->id), [
            'srt_pmhn_kmbali_biaya' => $file,
        ]);

        $response->assertRedirect()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');

        $tanggal_surat = Carbon::parse($surat->tanggal_surat)->format('d-m-Y');
        $nama_mahasiswa = Str::slug($user->nama);
        $fileName = "Surat_Permohonan_Pengembalian_Biaya_{$tanggal_surat}_{$nama_mahasiswa}.pdf";

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat->id,
            'file_pdf' => $fileName,
            'role_surat' => 'mahasiswa',
        ]);
    }

    public function test_view_halaman_surat_pmhn_kmbali_biaya_di_admin(): void
    {
        $response = $this->get('/srt_pmhn_kmbali_biaya/admin');

        $response->assertStatus(302);
    }

    public function test_search_surat_permohonan_kembali_biaya(): void
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'nama_mhw' => 'John',
        ]);

        $response = $this->get('/srt_pmhn_kmbali_biaya/admin/search?search=John');

        $response->assertStatus(200);
        $response->assertDontSeeText('Kawijayan');
        $response->assertSeeText('John');
    }

    public function test_cek_surat_srt_pmhn_kmbali_biaya()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $suratId = DB::table('srt_pmhn_kmbali_biaya')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->get("/srt_pmhn_kmbali_biaya/admin/cek_surat/{$suratId}");

        $response->assertStatus(200);
    }

    public function test_setuju_surat_permohonan_kembali_biaya()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'no_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_pmhn_kmbali_biaya/admin/cek_surat/setuju/{$surat->id}", [
            'no_surat' => '123456789',
        ]);

        $response->assertRedirect(route('srt_pmhn_kmbali_biaya.admin'));
        $response->assertSessionHas('success', 'No surat berhasil ditambahkan');

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat->id,
            'no_surat' => '123456789',
            'role_surat' => 'supervisor_sd',
        ]);
    }

    public function test_tolak_surat_permohonan_kembali_biaya()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'catatan_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_pmhn_kmbali_biaya/admin/cek_surat/tolak/{$surat->id}", [
            'catatan_surat' => 'Dokumen tidak lengkap',
        ]);

        $response->assertRedirect(route('srt_pmhn_kmbali_biaya.admin'));
        $response->assertSessionHas('success', 'Alasan penolakan telah dikirimkan');

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat->id,
            'catatan_surat' => 'Dokumen tidak lengkap',
            'role_surat' => 'tolak',
        ]);
    }

    public function test_view_halaman_supervisor_surat_permohonan_kembali_biaya(): void
    {
        $response = $this->get('/srt_pmhn_kmbali_biaya/supervisor');

        $response->assertStatus(302);
    }

    public function test_supervisor_setuju_srt_pmhn_kmbali_biaya()
    {
        $faker = \Faker\Factory::create();
        
        $user = \App\Models\User::factory()->create([
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor_sd',
        ]);

        $this->actingAs($user);

        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_pmhn_kmbali_biaya/supervisor/setuju/{$surat->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat->id,
            'role_surat' => 'manajer',
        ]);
    }

    public function test_halaman_manajer_surat_permohonan_kembali_biaya(): void
    {
        $response = $this->get('/srt_pmhn_kmbali_biaya/manajer');

        $response->assertStatus(302);
    }

    public function test_manajer_setuju_srt_pmhn_kmbali_biaya()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'manajer@example.com',
            'password' => bcrypt('password'),
            'role' => 'manajer',
        ]);

        $this->actingAs($user);

        $surat = \App\Models\srt_pmhn_kmbali_biaya::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'skl' => 'skl.pdf',
            'buku_tabung' => 'buku_tabung.pdf',
            'bukti_bayar' => 'bukti_bayar.pdf',
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_pmhn_kmbali_biaya/manajer/setuju/{$surat->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_pmhn_kmbali_biaya', [
            'id' => $surat->id,
            'role_surat' => 'manajer_sukses',
        ]);
    }
}
