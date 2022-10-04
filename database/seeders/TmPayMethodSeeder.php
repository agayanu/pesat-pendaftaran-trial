<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmPayMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['id' => 1, 'name' => 'Cash', 'created_at' => now()],
            ['id' => 2, 'name' => 'Transfer', 'created_at' => now()],
        ];

        DB::table('tm_pay_methods')->insert($methods);
    }
}
