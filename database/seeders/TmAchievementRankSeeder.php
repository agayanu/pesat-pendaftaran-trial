<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmAchievementRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievementranks = [
            ['id' => 1, 'name' => 'JUARA 1', 'created_at' => now()],
            ['id' => 2, 'name' => 'JUARA 2', 'created_at' => now()],
            ['id' => 3, 'name' => 'JUARA 3', 'created_at' => now()],
            ['id' => 4, 'name' => 'JUARA HARAPAN 1', 'created_at' => now()],
            ['id' => 5, 'name' => 'JUARA HARAPAN 2', 'created_at' => now()],
            ['id' => 6, 'name' => 'JUARA HARAPAN 3', 'created_at' => now()],
        ];

        DB::table('tm_achievementranks')->insert($achievementranks);
    }
}
