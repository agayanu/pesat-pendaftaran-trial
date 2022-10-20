<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periods = [
            ['id' => 1, 'period' => 2020, 'status' => 'N', 'created_at' => now()],
            ['id' => 2, 'period' => 2021, 'status' => 'N', 'created_at' => now()],
            ['id' => 3, 'period' => 2022, 'status' => 'Y', 'created_at' => now()],
        ];

        DB::table('tm_periods')->insert($periods);
    }
}
