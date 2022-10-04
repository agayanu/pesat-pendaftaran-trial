<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmCitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $citizens = [
            ['id' => 1, 'name' => 'WNI', 'created_at' => now()],
            ['id' => 2, 'name' => 'WNA', 'created_at' => now()],
        ];

        DB::table('tm_citizens')->insert($citizens);
    }
}
