<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            ['id' => 1, 'name' => 'Laki-Laki', 'created_at' => now()],
            ['id' => 2, 'name' => 'Perempuan', 'created_at' => now()],
        ];

        DB::table('tm_genders')->insert($genders);
    }
}
