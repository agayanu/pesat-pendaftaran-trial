<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmFamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familymembers = [
            ['id' => 1, 'name' => 'AYAH', 'created_at' => now()],
            ['id' => 2, 'name' => 'IBU', 'created_at' => now()],
            ['id' => 3, 'name' => 'WALI', 'created_at' => now()],
        ];

        DB::table('tm_familymembers')->insert($familymembers);
    }
}
