<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\departemen;
use App\Models\prodi;
use App\Models\User;
use Illuminate\Database\Seeder;

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

                'nama_prd' => 'S2 - Manajemen'
            ],
            [

                'nama_prd' => 'S1 - Ekonomi'
            ],
            [

                'nama_prd' => 'S2 - Ekonomi'
            ],
            [

                'nama_prd' => 'S1 - Ekonomi Islam'
            ],
            [

                'nama_prd' => 'S1 - Akuntansi'
            ],
            [

                'nama_prd' => 'S2 - Akuntansi'
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

        $users = [
            [

                'nama' => 'sayatest',
                'nim' => '21120120150155',
                'email' => 'testing@gmail.com',
                'password' => bcrypt('mountain082'),
                'role' => 'mahasiswa',
            ],
            [

                'nama' => 'admin1',
                'nim' => '101',
                'email' => 'testingadmin@gmail.com',
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
