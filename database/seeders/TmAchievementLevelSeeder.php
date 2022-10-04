<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmAchievementLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievementlevels = [
            ['id' => 1, 'name' => 'INTERNAL SEKOLAH', 'created_at' => now()],
            ['id' => 2, 'name' => 'KELURAHAN', 'created_at' => now()],
            ['id' => 3, 'name' => 'KECAMATAN', 'created_at' => now()],
            ['id' => 4, 'name' => 'KABUPATEN/KOTA', 'created_at' => now()],
            ['id' => 5, 'name' => 'PROVINSI', 'created_at' => now()],
            ['id' => 6, 'name' => 'NASIONAL', 'created_at' => now()],
            ['id' => 7, 'name' => 'INTERNASIONAL', 'created_at' => now()],
        ];

        DB::table('tm_achievementlevels')->insert($achievementlevels);
    }
}
