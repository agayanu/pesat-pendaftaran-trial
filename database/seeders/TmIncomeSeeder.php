<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $incomes = [
            ['id' => 1, 'name' => 'Tidak Berpenghasilan', 'created_at' => now()],
            ['id' => 2, 'name' => 'Kurang dari Rp. 500,000', 'created_at' => now()],
            ['id' => 3, 'name' => 'Rp. 500,000 - Rp. 999,999', 'created_at' => now()],
            ['id' => 4, 'name' => 'Rp. 1,000,000 - Rp. 1,999,999', 'created_at' => now()],
            ['id' => 5, 'name' => 'Rp. 2,000,000 - Rp. 4,999,999', 'created_at' => now()],
            ['id' => 6, 'name' => 'Rp. 5,000,000 - Rp. 20,000,000', 'created_at' => now()],
            ['id' => 7, 'name' => 'Lebih dari Rp. 20,000,000', 'created_at' => now()],
        ];

        DB::table('tm_incomes')->insert($incomes);
    }
}
