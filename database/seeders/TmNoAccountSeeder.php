<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmNoAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noaccounts = [
            [
                'id' => 1,
                'account' => '1111111',
                'account_digit' => 9,
                'account_min' => '100000000',
                'account_max' => '999999999',
                'account2' => '2222222',
                'account2_digit' => 9,
                'account2_min' => '100000000',
                'account2_max' => '999999999',
                'created_at' => now()
            ],
        ];

        DB::table('tm_noaccounts')->insert($noaccounts);
    }
}
