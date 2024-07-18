<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\departemen;
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

                'nama_prd' => '-'
            ],
            [

                'nama_prd' => 'S1 - Digital Bisnis'
            ],
            [

                'nama_prd' => 'S1 - Manajemen'
            ],
            [

                'nama_prd' => 'S1 - Ekonomi'
            ],            
            [

                'nama_prd' => 'S1 - Ekonomi Islam'
            ],            
            [

                'nama_prd' => 'S1 - Akuntansi'
            ],
            [

                'nama_prd' => 'S2 - Manajemen'
            ],
            [

                'nama_prd' => 'S2 - Ekonomi'
            ],
            [

                'nama_prd' => 'S2 - Akuntansi'
            ],
            [

                'nama_prd' => 'S3 - Ilmu Ekonomi'
            ],
        ];
        foreach($prodis as $prodi) {
            prodi::create($prodi);
        }

        $departements = [
            [

                'nama_dpt' => '-'
            ],
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
        foreach($departements as  $departement) {
            departemen::create($departement);
        }

        $faker = Faker::create('id_ID');

        foreach (range(1, 5) as $index) {
            DB::table('users')->insert([
                'nama' => $faker->name,
                'nim' => '211201' . $faker->unique()->numerify('########'),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('mountain082'),
                'role' => '-',
                'nowa' => $faker->phoneNumber,
                'kota' => $faker->city,
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = '2008-01-01', $min = '1999-01-01', ),
                'almt_asl' => $faker->address,
                'almt_smg' => $faker->streetAddress . ', ' . $faker->citySuffix . ', Semarang',
                'dpt_id' => $faker->numberBetween(1, 4),
                'prd_id' => $faker->numberBetween(1, 10),
            ]);
        }

        $users = [
            [

                'nama' => 'sayatest',
                'nim' => '21120120150155',
                'email' => 'testing@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'mahasiswa',
                'kota' => 'Blitar',
                'tanggal_lahir' => Carbon::createFromFormat('d - m - Y', '5 - 10 - 2010'),
                'nowa' => '081214549624',
                'almt_asl' => 'Jl Kenari No 20 RT 2 RW 3 Tembalang Semarang',
                'almt_smg' => '-',
                'dpt_id' => 2,
                'prd_id' => 3,
            ],
            [

                'nama' => 'non mahasiswa',
                'nim' => '211201201444444',
                'email' => 'non@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => '-',
                'nowa' => '081214549624',
                'almt_asl' => 'Jl Perkutut No 20 RT 2 RW 3 Beru Kendari',
                'almt_smg' => 'Jl Kenari No 25 RT 2 RW 3 Tembalang Semarang',
                'dpt_id' => 1,
                'prd_id' => 10,
            ],
            [

                'nama' => 'admin1',
                'nim' => '101',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'admin',
            ],
            [

                'nama' => 'admin2',
                'nim' => '102',
                'email' => 'testingadmin1@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'admin',
            ],
            [

                'nama' => 'supervisor',
                'nim' => '201',
                'email' => 'supervisor@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'supervisor',
            ],
            [

                'nama' => 'wakil dekan',
                'nim' => '301',
                'email' => 'wakildekan@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'wakildekan',
            ],
        ];
        foreach($users as  $user) {
            User::create($user);
        }
    }
}
