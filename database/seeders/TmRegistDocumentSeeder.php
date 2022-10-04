<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmRegistDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registdocuments = [
            ['id' => 1, 'name' => 'FOTOCOPY AKTE KELAHIRAN', 'created_at' => now()],
            ['id' => 2, 'name' => 'FOTOCOPY KARTU KELUARGA', 'created_at' => now()],
            ['id' => 3, 'name' => 'FOTOCOPY RAPOR KELAS 7-9 SEMESTER 1&2', 'created_at' => now()],
        ];

        DB::table('tm_regist_documents')->insert($registdocuments);
    }
}
