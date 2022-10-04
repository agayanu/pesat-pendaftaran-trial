<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            ['id' => 1, 'code' => '01', 'name' => 'DKI JAKARTA', 'order' => '9', 'active' => 'Y', 'created_at' => now()],
            ['id' => 2, 'code' => '02', 'name' => 'JAWA BARAT', 'order' => '10', 'active' => 'Y', 'created_at' => now()],
            ['id' => 3, 'code' => '03', 'name' => 'JAWA TENGAH', 'order' => '12', 'active' => 'Y', 'created_at' => now()],
            ['id' => 4, 'code' => '04', 'name' => 'DI. YOGYAKARTA', 'order' => '11', 'active' => 'Y', 'created_at' => now()],
            ['id' => 5, 'code' => '05', 'name' => 'JAWA TIMUR', 'order' => '13', 'active' => 'Y', 'created_at' => now()],
            ['id' => 6, 'code' => '06', 'name' => 'ACEH', 'order' => '1', 'active' => 'Y', 'created_at' => now()],
            ['id' => 7, 'code' => '07', 'name' => 'SUMATERA UTARA', 'order' => '2', 'active' => 'Y', 'created_at' => now()],
            ['id' => 8, 'code' => '08', 'name' => 'SUMATERA BARAT', 'order' => '3', 'active' => 'Y', 'created_at' => now()],
            ['id' => 9, 'code' => '09', 'name' => 'R I A U', 'order' => '4', 'active' => 'Y', 'created_at' => now()],
            ['id' => 10, 'code' => '10', 'name' => 'J A M B I', 'order' => '5', 'active' => 'Y', 'created_at' => now()],
            ['id' => 11, 'code' => '11', 'name' => 'SUMATERA SELATAN', 'order' => '6', 'active' => 'Y', 'created_at' => now()],
            ['id' => 12, 'code' => '12', 'name' => 'LAMPUNG', 'order' => '8', 'active' => 'Y', 'created_at' => now()],
            ['id' => 13, 'code' => '13', 'name' => 'KALIMANTAN BARAT', 'order' => '14', 'active' => 'Y', 'created_at' => now()],
            ['id' => 14, 'code' => '14', 'name' => 'KALIMANTAN TENGAH', 'order' => '15', 'active' => 'Y', 'created_at' => now()],
            ['id' => 15, 'code' => '15', 'name' => 'KALIMANTAN SELATAN', 'order' => '16', 'active' => 'Y', 'created_at' => now()],
            ['id' => 16, 'code' => '16', 'name' => 'KALIMANTAN TIMUR', 'order' => '17', 'active' => 'Y', 'created_at' => now()],
            ['id' => 17, 'code' => '17', 'name' => 'SULAWESI UTARA', 'order' => '18', 'active' => 'Y', 'created_at' => now()],
            ['id' => 18, 'code' => '18', 'name' => 'SULAWESI TENGAH', 'order' => '19', 'active' => 'Y', 'created_at' => now()],
            ['id' => 19, 'code' => '19', 'name' => 'SULAWESI SELATAN', 'order' => '20', 'active' => 'Y', 'created_at' => now()],
            ['id' => 20, 'code' => '20', 'name' => 'SULAWESI TENGGARA', 'order' => '21', 'active' => 'Y', 'created_at' => now()],
            ['id' => 21, 'code' => '21', 'name' => 'MALUKU', 'order' => '25', 'active' => 'Y', 'created_at' => now()],
            ['id' => 22, 'code' => '22', 'name' => 'BALI', 'order' => '22', 'active' => 'Y', 'created_at' => now()],
            ['id' => 23, 'code' => '23', 'name' => 'NUSA TENGGARA BARAT', 'order' => '23', 'active' => 'Y', 'created_at' => now()],
            ['id' => 24, 'code' => '24', 'name' => 'NUSA TENGGARA TIMUR', 'order' => '24', 'active' => 'Y', 'created_at' => now()],
            ['id' => 25, 'code' => '25', 'name' => 'PAPUA', 'order' => '26', 'active' => 'Y', 'created_at' => now()],
            ['id' => 26, 'code' => '26', 'name' => 'BENGKULU', 'order' => '7', 'active' => 'Y', 'created_at' => now()],
            ['id' => 27, 'code' => '27', 'name' => 'MALUKU UTARA', 'order' => '28', 'active' => 'Y', 'created_at' => now()],
            ['id' => 28, 'code' => '28', 'name' => 'BANTEN', 'order' => '27', 'active' => 'Y', 'created_at' => now()],
            ['id' => 29, 'code' => '29', 'name' => 'KEPULAUAN BANGKA BELITUNG', 'order' => '30', 'active' => 'Y', 'created_at' => now()],
            ['id' => 30, 'code' => '30', 'name' => 'GORONTALO', 'order' => '29', 'active' => 'Y', 'created_at' => now()],
            ['id' => 31, 'code' => '31', 'name' => 'KEPULAUAN RIAU', 'order' => '31', 'active' => 'Y', 'created_at' => now()],
            ['id' => 32, 'code' => '32', 'name' => 'PAPUA BARAT', 'order' => '33', 'active' => 'Y', 'created_at' => now()],
            ['id' => 33, 'code' => '33', 'name' => 'SULAWESI BARAT', 'order' => '32', 'active' => 'Y', 'created_at' => now()],
            ['id' => 34, 'code' => '34', 'name' => 'KALIMANTAN UTARA', 'order' => '34', 'active' => 'Y', 'created_at' => now()],
        ];

        DB::table('tm_provinces')->insert($provinces);
    }
}
