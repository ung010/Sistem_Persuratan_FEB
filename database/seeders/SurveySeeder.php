<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\departemen;
use App\Models\prodi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey')->truncate();

        $faker_survey = Faker::create('id_ID');
        $excluded_roles = ['non_mahasiswa', 'del_mahasiswa', 'admin', 'supervisor_akd', 'supervisor_sd', 'manajer'];
        $user_ids = DB::table('users')
            ->whereNotIn('role', $excluded_roles)
            ->pluck('id')
            ->toArray();

        $ratings = ['sangat_puas', 'puas', 'netral', 'kurang_puas', 'tidak_puas'];

        $feedback = [
            'Tampilan website sangat menarik, tetapi loading halamannya masih terlalu lama.',
            'Navigasi menu di website agak membingungkan, mungkin bisa diperjelas lagi.',
            'Website ini sudah cukup bagus, namun fitur pencarian terkadang tidak memberikan hasil yang relevan.',
            'Desain responsifnya bagus, tetapi ada beberapa elemen yang tidak ditampilkan dengan baik di perangkat mobile.',
            'Saran saya, tambahkan fitur filter untuk mempermudah pencarian produk di website.',
            'Website sangat informatif, tetapi mungkin bisa diperbaiki dari segi kecepatan akses.',
            'Ada beberapa bug yang muncul ketika mengakses halaman login.',
            'Sebaiknya ditambahkan lebih banyak panduan penggunaan agar pengguna baru lebih mudah memahami.',
            'Website ini sangat fungsional, namun tampilannya bisa dibuat lebih modern dan user-friendly.',
            'Konten sudah cukup lengkap, tetapi ada beberapa link yang tidak berfungsi dengan baik.'
        ];

        foreach (range(1, 50) as $index) {
            $id = mt_rand(1000000000000, 9999999999999);
            $random_user_id = $faker_survey->randomElement($user_ids);
            $user = DB::table('users')->where('id', $random_user_id)->first();
            $nama_mhw = $user->nama;

            if ($nama_mhw === 'Raung') {
                continue;
            }

            $rating = $faker_survey->randomElement($ratings);
            $tanggal_surat = Carbon::create(
                rand(2000, 2024),
                rand(1, 12),
                rand(1, 28)
            )->toDateString();

            DB::table('survey')->insert([
                'id' => $id,
                'users_id' => $random_user_id,
                'nama_mhw' => $nama_mhw,
                'rating' => $rating,
                'feedback' => $faker_survey->randomElement($feedback),
                'tanggal_surat' => $tanggal_surat,
                'prd_id' => $user->prd_id,
            ]);
        }
    }
}
