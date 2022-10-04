<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmHotlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotlines = [
            ['id' => 1, 'name' => 'Hotline 1', 'type' => 1, 'lines' => '081388127557', 'created_at' => now()],
            ['id' => 2, 'name' => 'Hotline 2', 'type' => 2, 'lines' => '(021) 8753773', 'created_at' => now()],
        ];

        DB::table('tm_hotlines')->insert($hotlines);
    }
}
