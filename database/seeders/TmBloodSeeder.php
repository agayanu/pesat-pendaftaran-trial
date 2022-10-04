<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmBloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bloods = [
            ['id' => 1, 'name' => 'A', 'created_at' => now()],
            ['id' => 2, 'name' => 'AB', 'created_at' => now()],
            ['id' => 3, 'name' => 'B', 'created_at' => now()],
            ['id' => 4, 'name' => 'O', 'created_at' => now()],
        ];

        DB::table('tm_bloods')->insert($bloods);
    }
}
