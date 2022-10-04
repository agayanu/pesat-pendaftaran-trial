<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmHotlineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotline_types = [
            ['id' => 1, 'name' => 'Whatsapp', 'short' => 'WA', 'created_at' => now()],
            ['id' => 2, 'name' => 'Telpon', 'short' => 'Tel', 'created_at' => now()],
        ];

        DB::table('tm_hotline_types')->insert($hotline_types);
    }
}
