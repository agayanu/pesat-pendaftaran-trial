<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayBill2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regist = DB::table('registrations')->select('id')->where('period',2021)->inRandomOrder()->limit(590)->get();
        $user   = 'operator@smapluspgri.sch.id';

        foreach ($regist as $r) {
            $regist = DB::table('registrations')->select('phase','grade')->where('id',$r->id)->first();
            $registPay = DB::table('tm_cost_payments')->select('id','amount')->where([['phase',$regist->phase],['grade',$regist->grade]])->first();
            $registPayDetail = DB::table('tm_cost_payment_details')->select('id','amount')->where('id_payment',$registPay->id)->get();
            $idPay = DB::table('tr_pay')
                        ->insertGetId([
                            'id_regist'       => $r->id,
                            'id_cost_payment' => $registPay->id,
                            'bill'            => $registPay->amount,
                            'balance'         => $registPay->amount,
                            'user'            => $user,
                            'created_at'      => now()
                        ]);

            foreach ($registPayDetail as $rpd) {
                DB::table('tr_pay_details')
                    ->insert([
                        'id_pay'                 => $idPay,
                        'id_cost_payment_detail' => $rpd->id,
                        'bill'                   => $rpd->amount,
                        'balance'                => $rpd->amount,
                        'user'                   => $user,
                        'created_at'             => now()
                    ]);
            }
        }
    }
}
