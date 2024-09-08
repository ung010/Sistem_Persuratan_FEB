<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hashids\Hashids;

class Surat_Izin_Penelitian_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_halaman_surat_izin_penelitian(): void
    {
        $response = $this->get('/srt_izin_plt');

        $response->assertStatus(302);
    }

    public function test_pembuatan_surat_izin_penelitian(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'prd_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->post('/srt_izin_plt/create', [
            'nama_mhw' => $faker->name,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => $faker->date('Y-m-d'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_izin_plt');
    }

    public function test_gagal_buat_surat_magang_baru_karena_data_kurang(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'prd_id' => 1,
        ]);

        $this->actingAs($user);

        try {
            $this->post('/srt_izin_plt/create', [
                'nama_mhw' => $faker->name,
                'semester' => $faker->randomDigitNotNull,
                'almt_lmbg' => $faker->address(),
                'jbt_lmbg' => $faker->jobTitle(),
                'kota_lmbg' => $faker->city(),
                'nama_lmbg' => $faker->company(),
                'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
                'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
                'tanggal_surat' => $faker->date('Y-m-d'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertEquals('Judul/Tema Pengambilan Data Wajib diisi', $e->validator->errors()->first('judul_data'));
            return;
        }
        $response->assertStatus(302);
    }

    public function test_view_halaman_edit_surat_izin_penelitian(): void
    {
        $this->withoutExceptionHandling();

        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('mountain082'),
            'role' => 'mahasiswa',
            'prd_id' => 1,
        ]);

        $this->actingAs($user);
        $hashids = new Hashids('nilai-salt-unik-anda-di-sini', 7);
        $surat = DB::table('srt_izin_plt')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $encodedId = $hashids->encode($surat);
        $response = $this->get("/srt_izin_plt/edit/{$encodedId}");

        $response->assertStatus(200);
    }

    public function test_update_surat_izin_penelitian(): void
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

        $surat = DB::table('srt_izin_plt')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_izin_plt/update/{$surat}", [
            'almt_lmbg' => $faker->address(),
            'nama_lmbg' => $faker->company(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => 'Blitar',
            'lampiran' => '2 Eksemplar',
            'judul_data' => 'Kerja Praktek',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/srt_izin_plt');

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat,
            'kota_lmbg' => 'Blitar',
            'lampiran' => '2 Eksemplar',
            'judul_data' => 'Kerja Praktek',
        ]);
    }

    public function test_view_halaman_surat_izin_penelitian_di_admin(): void
    {
        $response = $this->get('/srt_izin_plt/admin');

        $response->assertStatus(302);
    }

    public function test_cek_surat_srt_izin_plt()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $suratId = DB::table('srt_izin_plt')->insertGetId([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->get("/srt_izin_plt/admin/cek_surat/{$suratId}");

        $response->assertStatus(200);
    }

    public function test_setuju_surat_izin_penelitian()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $surat = \App\Models\srt_izin_penelitian::factory()->create([
            'no_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_izin_plt/admin/cek_surat/setuju/{$surat->id}", [
            'no_surat' => '123456789',
        ]);

        $response->assertRedirect(route('srt_izin_plt.admin'));
        $response->assertSessionHas('success', 'No surat berhasil ditambahkan');

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat->id,
            'no_surat' => '123456789',
            'role_surat' => 'supervisor_akd',
        ]);
    }

    public function test_tolak_surat_izin_penelitian()
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);


        $surat = \App\Models\srt_izin_penelitian::factory()->create([
            'catatan_surat' => null,
            'role_surat' => 'admin',
        ]);

        $response = $this->post("/srt_izin_plt/admin/cek_surat/tolak/{$surat->id}", [
            'catatan_surat' => 'Dokumen tidak lengkap',
        ]);

        $response->assertRedirect(route('srt_izin_plt.admin'));
        $response->assertSessionHas('success', 'Alasan penolakan telah dikirimkan');

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat->id,
            'catatan_surat' => 'Dokumen tidak lengkap',
            'role_surat' => 'tolak',
        ]);
    }

    public function test_download_srt_izin_plt_mahasiswa()
    {
        $id = 6;

        $response = $this->get("/srt_izin_plt/download/{$id}");

        $response->assertStatus(302);
    }

    public function test_download_srt_izin_plt_admin()
    {
        $id = 4;

        $response = $this->get("/srt_izin_plt/admin/download/{$id}");

        $response->assertStatus(302);
    }

    public function test_unggah_surat_izin_penelitian_admin()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $surat = \App\Models\srt_izin_penelitian::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');

        $this->actingAs($user);

        $response = $this->post(route('srt_izin_plt.admin_unggah', $surat->id), [
            'srt_izin_plt' => $file,
        ]);

        $response->assertRedirect()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');

        $tanggal_surat = Carbon::parse($surat->tanggal_surat)->format('d-m-Y');
        $nama_mahasiswa = Str::slug($user->nama);
        $fileName = "surat_izin_penelitian_{$tanggal_surat}_{$nama_mahasiswa}.pdf";

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat->id,
            'file_pdf' => $fileName,
            'role_surat' => 'mahasiswa',
        ]);
    }

    public function test_view_halaman_supervisor_surat_izin_penelitian(): void
    {
        $response = $this->get('/srt_izin_plt/supervisor');

        $response->assertStatus(302);
    }

    public function test_supervisor_setuju_srt_izin_plt()
    {
        $faker = \Faker\Factory::create();
        
        $user = \App\Models\User::factory()->create([
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor_akd',
        ]);

        $this->actingAs($user);

        $surat = \App\Models\srt_izin_penelitian::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_izin_plt/supervisor/setuju/{$surat->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat->id,
            'role_surat' => 'manajer',
        ]);
    }

    public function test_halaman_manajer_surat_izin_penelitian(): void
    {
        $response = $this->get('/srt_izin_plt/manajer');

        $response->assertStatus(302);
    }

    public function test_manajer_setuju_srt_izin_plt()
    {
        $faker = \Faker\Factory::create();

        $user = \App\Models\User::factory()->create([
            'email' => 'manajer@example.com',
            'password' => bcrypt('password'),
            'role' => 'manajer',
        ]);

        $this->actingAs($user);

        $surat = \App\Models\srt_izin_penelitian::factory()->create([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'nama_mhw' => $user->nama,
            'semester' => $faker->randomDigitNotNull,
            'almt_lmbg' => $faker->address(),
            'jbt_lmbg' => $faker->jobTitle(),
            'kota_lmbg' => $faker->city(),
            'nama_lmbg' => $faker->company(),
            'judul_data' => $faker->sentence(),
            'jenis_surat' => $faker->randomElement(['Kerja Praktek', 'Tugas Akhir Penelitian Mahasiswa', 'Ijin Penelitian' , 'Survey' , 'Thesis', 'Disertasi']),
            'lampiran' => $faker->randomElement(['1 Eksemplar', '2 Eksemplar']),
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post("/srt_izin_plt/manajer/setuju/{$surat->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Surat berhasil disetujui');

        $this->assertDatabaseHas('srt_izin_plt', [
            'id' => $surat->id,
            'role_surat' => 'manajer_sukses',
        ]);
    }
}
