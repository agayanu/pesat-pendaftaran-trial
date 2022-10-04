<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmStaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stays = [
            ['id' => 1, 'name' => 'RUMAH SENDIRI', 'created_at' => now()],
            ['id' => 2, 'name' => 'IKUT ORANG TUA', 'created_at' => now()],
            ['id' => 3, 'name' => 'KONTRAK (KOST)', 'created_at' => now()],
            ['id' => 4, 'name' => 'DINAS', 'created_at' => now()],
            ['id' => 5, 'name' => 'IKUT WALI', 'created_at' => now()],
        ];

        DB::table('tm_stays')->insert($stays);
    }
}
