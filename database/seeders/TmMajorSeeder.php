<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmMajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $majors = [
            ['id' => 1, 'name' => 'IPA', 'created_at' => now()],
            ['id' => 2, 'name' => 'IPS', 'created_at' => now()],
        ];

        DB::table('tm_majors')->insert($majors);
    }
}
