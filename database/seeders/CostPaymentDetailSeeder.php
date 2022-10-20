<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostPaymentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costPaymentDetails = [
            ['id' => 1, 'id_payment' => 1, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 375000, 'created_at' => now()],
            ['id' => 2, 'id_payment' => 1, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 3, 'id_payment' => 1, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 4, 'id_payment' => 1, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 5, 'id_payment' => 1, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 6, 'id_payment' => 1, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 7, 'id_payment' => 1, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 8, 'id_payment' => 1, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 5500000, 'created_at' => now()],
            ['id' => 9, 'id_payment' => 1, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 10, 'id_payment' => 1, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 11, 'id_payment' => 1, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 12, 'id_payment' => 1, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
            ['id' => 13, 'id_payment' => 2, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 625000, 'created_at' => now()],
            ['id' => 14, 'id_payment' => 2, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 15, 'id_payment' => 2, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 16, 'id_payment' => 2, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 17, 'id_payment' => 2, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 18, 'id_payment' => 2, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 19, 'id_payment' => 2, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 20, 'id_payment' => 2, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 9500000, 'created_at' => now()],
            ['id' => 21, 'id_payment' => 2, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 22, 'id_payment' => 2, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 23, 'id_payment' => 2, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 24, 'id_payment' => 2, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
            ['id' => 25, 'id_payment' => 3, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 375000, 'created_at' => now()],
            ['id' => 26, 'id_payment' => 3, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 27, 'id_payment' => 3, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 28, 'id_payment' => 3, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 29, 'id_payment' => 3, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 30, 'id_payment' => 3, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 31, 'id_payment' => 3, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 32, 'id_payment' => 3, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 5500000, 'created_at' => now()],
            ['id' => 33, 'id_payment' => 3, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 34, 'id_payment' => 3, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 35, 'id_payment' => 3, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 36, 'id_payment' => 3, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
            ['id' => 37, 'id_payment' => 4, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 625000, 'created_at' => now()],
            ['id' => 38, 'id_payment' => 4, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 39, 'id_payment' => 4, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 40, 'id_payment' => 4, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 41, 'id_payment' => 4, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 42, 'id_payment' => 4, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 43, 'id_payment' => 4, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 44, 'id_payment' => 4, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 9500000, 'created_at' => now()],
            ['id' => 45, 'id_payment' => 4, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 46, 'id_payment' => 4, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 47, 'id_payment' => 4, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 48, 'id_payment' => 4, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
            ['id' => 49, 'id_payment' => 5, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 375000, 'created_at' => now()],
            ['id' => 50, 'id_payment' => 5, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 51, 'id_payment' => 5, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 52, 'id_payment' => 5, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 53, 'id_payment' => 5, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 54, 'id_payment' => 5, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 55, 'id_payment' => 5, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 56, 'id_payment' => 5, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 5500000, 'created_at' => now()],
            ['id' => 57, 'id_payment' => 5, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 58, 'id_payment' => 5, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 59, 'id_payment' => 5, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 60, 'id_payment' => 5, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
            ['id' => 61, 'id_payment' => 6, 'id_detail_master' => 1, 'myorder' => 1, 'amount' => 625000, 'created_at' => now()],
            ['id' => 62, 'id_payment' => 6, 'id_detail_master' => 2, 'myorder' => 2, 'amount' => 40000, 'created_at' => now()],
            ['id' => 63, 'id_payment' => 6, 'id_detail_master' => 3, 'myorder' => 3, 'amount' => 30000, 'created_at' => now()],
            ['id' => 64, 'id_payment' => 6, 'id_detail_master' => 4, 'myorder' => 4, 'amount' => 8000, 'created_at' => now()],
            ['id' => 65, 'id_payment' => 6, 'id_detail_master' => 5, 'myorder' => 5, 'amount' => 2000, 'created_at' => now()],
            ['id' => 66, 'id_payment' => 6, 'id_detail_master' => 6, 'myorder' => 6, 'amount' => 25000, 'created_at' => now()],
            ['id' => 67, 'id_payment' => 6, 'id_detail_master' => 7, 'myorder' => 7, 'amount' => 20000, 'created_at' => now()],
            ['id' => 68, 'id_payment' => 6, 'id_detail_master' => 8, 'myorder' => 8, 'amount' => 9500000, 'created_at' => now()],
            ['id' => 69, 'id_payment' => 6, 'id_detail_master' => 9, 'myorder' => 9, 'amount' => 100000, 'created_at' => now()],
            ['id' => 70, 'id_payment' => 6, 'id_detail_master' => 10, 'myorder' => 10, 'amount' => 100000, 'created_at' => now()],
            ['id' => 71, 'id_payment' => 6, 'id_detail_master' => 11, 'myorder' => 11, 'amount' => 100000, 'created_at' => now()],
            ['id' => 72, 'id_payment' => 6, 'id_detail_master' => 12, 'myorder' => 12, 'amount' => 500000, 'created_at' => now()],
        ];

        DB::table('tm_cost_payment_details')->insert($costPaymentDetails);
    }
}
