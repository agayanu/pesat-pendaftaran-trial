<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuss = [
            ['id' => 1, 'name' => 'DAFTAR', 'created_at' => now()],
            ['id' => 2, 'name' => 'DITERIMA', 'created_at' => now()],
            ['id' => 3, 'name' => 'DAFTAR ULANG', 'created_at' => now()],
            ['id' => 4, 'name' => 'DIBATALKAN', 'created_at' => now()],
            ['id' => 5, 'name' => 'SISWA', 'created_at' => now()],
        ];

        DB::table('tm_statuss')->insert($statuss);
    }
}
