<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostPaymentDetailMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costPaymentDetailMasters = [
            ['id' => 1, 'name' => 'Dana SPP', 'created_at' => now()],
            ['id' => 2, 'name' => 'Dana Kursus Komputer', 'created_at' => now()],
            ['id' => 3, 'name' => 'Dana Kursus Bahasa Inggris', 'created_at' => now()],
            ['id' => 4, 'name' => 'Dana Osis', 'created_at' => now()],
            ['id' => 5, 'name' => 'Dana Simp. Wajib Koperasi', 'created_at' => now()],
            ['id' => 6, 'name' => 'Olahraga Out Door dan Indoor', 'created_at' => now()],
            ['id' => 7, 'name' => 'Pelayanan Kesehatan', 'created_at' => now()],
            ['id' => 8, 'name' => 'Dana Pembangunan Pendidikan', 'created_at' => now()],
            ['id' => 9, 'name' => 'Tabungan Wajib Sekolah', 'created_at' => now()],
            ['id' => 10, 'name' => 'Simpanan Pokok Koperasi', 'created_at' => now()],
            ['id' => 11, 'name' => 'Pas Foto', 'created_at' => now()],
            ['id' => 12, 'name' => 'Pelatihan Learning Skill & Pend. Karakter', 'created_at' => now()],
        ];

        DB::table('tm_cost_payment_detail_masters')->insert($costPaymentDetailMasters);
    }
}
