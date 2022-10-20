<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmResignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resigns = [
            ['id' => 1, 'discount' => '30', 'created_at' => now()],
        ];

        DB::table('tm_resigns')->insert($resigns);
    }
}
