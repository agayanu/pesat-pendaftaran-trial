<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmAchievementGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievementgroups = [
            ['id' => 1, 'name' => 'AKADEMIK', 'created_at' => now()],
            ['id' => 2, 'name' => 'KESENIAN', 'created_at' => now()],
            ['id' => 3, 'name' => 'OLAHRAGA', 'created_at' => now()],
            ['id' => 4, 'name' => 'SAINS', 'created_at' => now()],
        ];

        DB::table('tm_achievementgroups')->insert($achievementgroups);
    }
}
