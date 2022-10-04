<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmCostRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cost_registrations = [
            ['id' => 1, 'phase' => 2, 'amount' => 100000, 'created_at' => now()],
        ];

        DB::table('tm_cost_registrations')->insert($cost_registrations);
    }
}
