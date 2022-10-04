<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educations = [
            ['id' => 1, 'name' => 'TK', 'created_at' => now()],
            ['id' => 2, 'name' => 'SD', 'created_at' => now()],
            ['id' => 3, 'name' => 'MI', 'created_at' => now()],
            ['id' => 4, 'name' => 'SMP', 'created_at' => now()],
            ['id' => 5, 'name' => 'MTS', 'created_at' => now()],
            ['id' => 6, 'name' => 'SMU', 'created_at' => now()],
            ['id' => 7, 'name' => 'SMK', 'created_at' => now()],
            ['id' => 8, 'name' => 'STM', 'created_at' => now()],
            ['id' => 9, 'name' => 'SMEA', 'created_at' => now()],
            ['id' => 10, 'name' => 'SPG', 'created_at' => now()],
            ['id' => 11, 'name' => 'DIPLOMA 1', 'created_at' => now()],
            ['id' => 12, 'name' => 'DIPLOMA 2', 'created_at' => now()],
            ['id' => 13, 'name' => 'DIPLOMA 3', 'created_at' => now()],
            ['id' => 14, 'name' => 'S1', 'created_at' => now()],
            ['id' => 15, 'name' => 'S2', 'created_at' => now()],
            ['id' => 16, 'name' => 'S3', 'created_at' => now()],
        ];

        DB::table('tm_educations')->insert($educations);
    }
}
