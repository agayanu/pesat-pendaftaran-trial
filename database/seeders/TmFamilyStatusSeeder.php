<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmFamilyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familystats = [
            ['id' => 1, 'name' => 'Anak Kandung', 'created_at' => now()],
            ['id' => 2, 'name' => 'Anak Tiri', 'created_at' => now()],
        ];

        DB::table('tm_familystatuss')->insert($familystats);
    }
}
