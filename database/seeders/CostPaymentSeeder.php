<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costPayments = [
            ['id' => 1, 'phase' => 1, 'grade' => 1, 'amount' => 6800000, 'created_at' => now()],
            ['id' => 2, 'phase' => 1, 'grade' => 2, 'amount' => 11050000, 'created_at' => now()],
            ['id' => 3, 'phase' => 3, 'grade' => 1, 'amount' => 6800000, 'created_at' => now()],
            ['id' => 4, 'phase' => 3, 'grade' => 2, 'amount' => 11050000, 'created_at' => now()],
            ['id' => 5, 'phase' => 5, 'grade' => 1, 'amount' => 6800000, 'created_at' => now()],
            ['id' => 6, 'phase' => 5, 'grade' => 2, 'amount' => 11050000, 'created_at' => now()],
        ];

        DB::table('tm_cost_payments')->insert($costPayments);
    }
}
