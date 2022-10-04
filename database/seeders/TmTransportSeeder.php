<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transports = [
            ['id' => 1, 'name' => 'JALAN KAKI', 'created_at' => now()],
            ['id' => 2, 'name' => 'SEPEDA', 'created_at' => now()],
            ['id' => 3, 'name' => 'MOTOR', 'created_at' => now()],
            ['id' => 4, 'name' => 'MOBIL', 'created_at' => now()],
            ['id' => 5, 'name' => 'ANGKUTAN UMUM', 'created_at' => now()],
            ['id' => 6, 'name' => 'KERETA API', 'created_at' => now()],
            ['id' => 7, 'name' => 'MOBIL/BUS ANTAR JEMPUT', 'created_at' => now()],
        ];

        DB::table('tm_transports')->insert($transports);
    }
}
