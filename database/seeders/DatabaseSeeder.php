<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\Dosen::create([

        //     'nama_dosen' => 'Pak Ibra',

        // ]);

        $prodis = [
            [

                'nama_prd' => 'Manajemen'
            ],
            [

                'nama_prd' => 'Digital Bisnis'
            ],
            [

                'nama_prd' => 'Ekonomi'
            ],
            [

                'nama_prd' => 'Ekonomi Islam'
            ],
            [

                'nama_prd' => 'Akuntansi'
            ],
            [

                'nama_prd' => 'Pendidikan Profesi Akuntan'
            ],
            [

                'nama_prd' => 'Doktor Ilmu Ekonomi'
            ],
        ];
        foreach ($prodis as $prodi) {
            prodi::create($prodi);
        }

        $jenjangs = [
            [

                'nama_jnjg' => 'S1'
            ],
            [

                'nama_jnjg' => 'S2'
            ],
            [

                'nama_jnjg' => 'S3'
            ],
        ];
        foreach ($jenjangs as $jenjang) {
            jenjang_pendidikan::create($jenjang);
        }

        $departements = [
            [

                'nama_dpt' => 'Manajemen'
            ],
            [

                'nama_dpt' => 'IESP'
            ],
            [

                'nama_dpt' => 'Akuntansi'
            ],
            [

                'nama_dpt' => 'Doktor Ilmu Ekonomi'
            ],
        ];
        foreach ($departements as  $departement) {
            departemen::create($departement);
        }

        $faker = Faker::create('id_ID');
        $gender = 'female';

        foreach (range(1, 40) as $index) {
            DB::table('users')->insert([
                'nama' => $faker->name,
                'nmr_unik' => '211201' . $faker->unique()->numerify('########'),
                'email' => $faker->unique()->userName . '@gmail.com',
                'password' => Hash::make('mountain082'),
                'role' => $faker->randomElement(['non_mahasiswa', 'non_alumni', 'mahasiswa', 'alumni']),
                'nowa' => $faker->phoneNumber,
                'kota' => $faker->city,
                'nama_ibu' => $faker->firstName($gender) . ' ' . $faker->lastName,
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = '2008-01-01', $min = '1999-01-01',),
                'almt_asl' => $faker->address,
                'catatan_user' => '-',
                'foto' => $faker->imageUrl(400, 400, 'people'),
                'dpt_id' => $faker->numberBetween(1, 4),
                'prd_id' => $faker->numberBetween(1, 7),
                'jnjg_id' => $faker->numberBetween(1, 3),
            ]);
        }

        $users = [
            [

                'nama' => 'Romusha TA',
                'nmr_unik' => '21120120150155',
                'email' => 'mahasiswa@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'mahasiswa',
                'kota' => 'Blitar',
                'tanggal_lahir' => Carbon::createFromFormat('d - m - Y', '5 - 10 - 2010'),
                'nowa' => '081214549624',
                'almt_asl' => 'Jl Kenari No 20 RT 2 RW 3 Tembalang Semarang',
                'dpt_id' => 1,
                'prd_id' => 2,
                'jnjg_id' => 2,
                'catatan_user' => '-',
                'nama_ibu' => 'Rosa0',
            ],
            [

                'nama' => 'Leo',
                'nmr_unik' => '64568775634',
                'email' => 'leo@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'mahasiswa',
                'kota' => 'leo',
                'tanggal_lahir' => Carbon::createFromFormat('d - m - Y', '5 - 11 - 2003'),
                'nowa' => '081214549624',
                'almt_asl' => 'Jl Kenari No 20 RT 2 RW 3 Tembalang Semarang',
                'dpt_id' => 2,
                'prd_id' => 2,
                'jnjg_id' => 3,
                'catatan_user' => '-',
                'nama_ibu' => 'leo',
            ],
            [

                'nama' => 'Raung Calon Sarjana',
                'nmr_unik' => '211201201444444',
                'email' => 'alumni@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'alumni',
                'kota' => 'Blitar',
                'tanggal_lahir' => Carbon::createFromFormat('d - m - Y', '5 - 10 - 2010'),
                'nowa' => '081214549624',
                'almt_asl' => 'Jl Perkutut No 20 RT 2 RW 3 Beru Kendari',
                'dpt_id' => 2,
                'prd_id' => 6,
                'jnjg_id' => 2,
                'catatan_user' => '-',
                'nama_ibu' => 'Rosa1',
            ],
            [

                'nama' => 'admin1',
                'nmr_unik' => '101',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'admin',
            ],
            [

                'nama' => 'admin2',
                'nmr_unik' => '102',
                'email' => 'testingadmin1@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'admin',
            ],
            [

                'nama' => 'Supervisor akademik',
                'nmr_unik' => '201',
                'email' => 'akademik@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'supervisor_akd',
            ],
            [

                'nama' => 'Supervisor Sumber Daya',
                'nmr_unik' => '301',
                'email' => 'sumber@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'supervisor_sd',
            ],
            [

                'nama' => 'Manajer',
                'nmr_unik' => '401',
                'email' => 'manajer@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'manajer',
            ],
        ];
        foreach ($users as  $user) {
            User::create($user);
        }

        $faker_srt_masih_mhw = Faker::create('id_ID');
        $excluded_roles = ['admin', 'supervisor_akd', 'supervisor_sd', 'manajer'];
        $user_ids = DB::table('users')
            ->whereNotIn('role', $excluded_roles)
            ->pluck('id')
            ->toArray();

        $alasan_acak = ['sakit', 'berpegian', 'menjenguk', 'acara keluarga', 'urusan pribadi'];

        foreach (range(1, 10) as $index) {

            $random_user_id = $faker_srt_masih_mhw->randomElement($user_ids);
            $user = DB::table('users')->where('id', $random_user_id)->first();
            $nama_mhw = $user->nama;
            $thn_awl = $faker_srt_masih_mhw->numberBetween(2010, 2020);
            $thn_akh = $thn_awl + 1;
            $tujuan_buat_srt = $faker_srt_masih_mhw->randomElement($alasan_acak);
            $tanggal_surat = Carbon::now()->toDateString();

            DB::table('srt_masih_mhw')->insert([
                'users_id' => $random_user_id,
                'nama_mhw' => $nama_mhw,
                'dpt_id' => $user->dpt_id,
                'prd_id' => $user->prd_id,
                'jnjg_id' => $user->jnjg_id,
                'thn_awl' => $thn_awl,
                'thn_akh' => $thn_akh,
                'tujuan_buat_srt' => $tujuan_buat_srt,
                'tanggal_surat' => $tanggal_surat,
                'almt_smg' => $faker_srt_masih_mhw->address(),
                'tujuan_akhir' => $faker_srt_masih_mhw->randomElement(['manajer', 'wd']),
            ]);
        }
    }
}
