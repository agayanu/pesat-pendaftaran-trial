<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmDeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deads = [
            ['id' => 1, 'id_job' => 14, 'created_at' => now()],
        ];

        DB::table('tm_deads')->insert($deads);
    }
}
