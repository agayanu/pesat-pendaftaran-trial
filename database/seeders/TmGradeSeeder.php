<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            ['id' => 1, 'name' => 'REGULER', 'created_at' => now()],
            ['id' => 2, 'name' => 'UNGGULAN', 'created_at' => now()],
        ];

        DB::table('tm_grades')->insert($grades);
    }
}
