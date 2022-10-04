<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmPhaseRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phase_registrations = [
            ['id' => 1, 'period' => 1, 'name' => 'Gelombang 1', 'status' => 'Y', 'cost' => 'N', 'created_at' => now()],
            ['id' => 2, 'period' => 1, 'name' => 'Gelombang 2', 'status' => 'N', 'cost' => 'Y', 'created_at' => now()],
        ];

        DB::table('tm_phase_registrations')->insert($phase_registrations);
    }
}
