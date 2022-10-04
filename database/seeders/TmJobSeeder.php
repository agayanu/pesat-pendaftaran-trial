<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
            ['id' => 1, 'name' => 'PELAJAR', 'created_at' => now()],
            ['id' => 2, 'name' => 'IBU RUMAH TANGGA', 'created_at' => now()],
            ['id' => 3, 'name' => 'WIRASWASTA', 'created_at' => now()],
            ['id' => 4, 'name' => 'PEGAWAI SWASTA', 'created_at' => now()],
            ['id' => 5, 'name' => 'PEGAWAI NEGERI', 'created_at' => now()],
            ['id' => 6, 'name' => 'SIPIL', 'created_at' => now()],
            ['id' => 7, 'name' => 'ABRI/POLRI', 'created_at' => now()],
            ['id' => 8, 'name' => 'BUMN', 'created_at' => now()],
            ['id' => 9, 'name' => 'GURU / DOSEN', 'created_at' => now()],
            ['id' => 10, 'name' => 'DOKTER', 'created_at' => now()],
            ['id' => 11, 'name' => 'PENGACARA', 'created_at' => now()],
            ['id' => 12, 'name' => 'PENSIUN', 'created_at' => now()],
            ['id' => 13, 'name' => 'SENIMAN', 'created_at' => now()],
            ['id' => 14, 'name' => 'SUDAH MENINGGAL', 'created_at' => now()],
        ];

        DB::table('tm_jobs')->insert($jobs);
    }
}
