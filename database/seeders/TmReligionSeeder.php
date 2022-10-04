<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $religions = [
            ['id' => 1, 'name' => 'Islam', 'created_at' => now()],
            ['id' => 2, 'name' => 'Katholik', 'created_at' => now()],
            ['id' => 3, 'name' => 'Protestan', 'created_at' => now()],
            ['id' => 4, 'name' => 'Hindu', 'created_at' => now()],
            ['id' => 5, 'name' => 'Budha', 'created_at' => now()],
            ['id' => 6, 'name' => 'Konghucu', 'created_at' => now()],
            ['id' => 7, 'name' => 'Kepercayaan kpd Tuhan Yang Maha Esa', 'created_at' => now()],
            ['id' => 8, 'name' => 'Lainnya', 'created_at' => now()],
        ];

        DB::table('tm_religions')->insert($religions);
    }
}
