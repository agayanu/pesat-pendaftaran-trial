<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class Resign3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $registx = DB::table('registrations as a')->join('tr_pay as b', 'a.id','=','b.id_regist')
                    ->select('a.id','a.grade')
                    ->where('a.period',2022)->whereNotNull('b.amount')->inRandomOrder()->limit(10)->get();
        $user    = 'operator@smapluspgri.sch.id';
        $discount = DB::table('tm_resigns')->select('discount')->first();
        foreach ($registx as $r) {
            $idRegist = $r->id;
            $remark   = $faker->randomElement(['Diterima di SMAN 1','Diterima di SMKN 2','Diterima di SMAN 3','Diterima di SMKN 4']);

            $idResign = DB::table('resigns')
                        ->insertGetId([
                            'id_regist'  => $idRegist,
                            'remark'     => $remark,
                            'user'       => $user,
                            'created_at' => now()
                        ]);

            DB::table('registrations')
            ->where('id',$idRegist)
            ->update([
                'status'     => 4,
                'user'       => $user,
                'updated_at' => now()
            ]);

            $pay           = DB::table('tr_pay')->select('id','bill','amount','balance')->where('id_regist',$idRegist)->first();
            $billDiscountx = ($discount->discount / 100) * $pay->bill;
            if($billDiscountx > $pay->amount) {
                $billDiscountx = $pay->amount;
            }
            $billDiscount = $pay->amount - $billDiscountx;
            $payBalance   = $pay->balance + $billDiscount;
            $billDetail   = DB::table('tr_pay as a')
                            ->join('tr_pay_details as b', 'a.id','=','b.id_pay')
                            ->join('tm_cost_payment_details as c', 'b.id_cost_payment_detail','=','c.id')
                            ->select('b.id','b.id_cost_payment_detail','b.bill','b.amount','b.balance')
                            ->where('a.id',$pay->id)
                            ->whereNotNull('b.amount')
                            ->orderBy('c.myorder','desc')->get();

            DB::table('tr_pay')
            ->where('id',$pay->id)
            ->update([
                'amount'     => $billDiscountx,
                'balance'    => $payBalance,
                'user'       => $user,
                'updated_at' => now()
            ]);

            $idTrResign = DB::table('tr_resigns')
                            ->insertGetId([
                                'id_pay'     => $pay->id,
                                'id_resign'  => $idResign,
                                'amount'     => $billDiscount,
                                'user'       => $user,
                                'created_at' => now()
                            ]);

            foreach ($billDetail as $bd)
            {
                if(empty($billDiscount) || $billDiscount == 0) {
                    //
                }
                if($billDiscount < $bd->amount && $billDiscount != 0) {
                    $billDiscountOld = $billDiscount;
                    $diffbillDiscount = $bd->amount - $billDiscount;
                    $billDiscount = 0;
                    if($bd->balance == 0) {
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $diffbillDiscount,
                            'balance'    => $billDiscountOld,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                    } else {
                        $diffBalancePlus = $bd->balance + $billDiscountOld;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $diffbillDiscount,
                            'balance'    => $diffBalancePlus,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                    }
                    DB::table('tr_resign_details')
                    ->insert([
                        'id_tr_resign'           => $idTrResign,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $billDiscountOld,
                        'user'                   => $user,
                        'created_at'             => now()
                    ]);
                }
                if($billDiscount > $bd->amount) {
                    if($bd->balance == 0) {
                        $billDiscount = $billDiscount - $bd->amount;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => null,
                            'balance'    => $bd->amount,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                    } else {
                        $billDiscount = $billDiscount - $bd->amount;
                        $diffDiscountPlus = $bd->balance + $bd->amount;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => null,
                            'balance'    => $diffDiscountPlus,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                    }
                    DB::table('tr_resign_details')
                    ->insert([
                        'id_tr_resign'           => $idTrResign,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $bd->amount,
                        'user'                   => $user,
                        'created_at'             => now()
                    ]);
                }
                if($billDiscount == $bd->amount) {
                    if($bd->balance == 0) {
                        $billDiscount = 0;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => null,
                            'balance'    => $bd->amount,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_resign_details')
                        ->insert([
                            'id_tr_resign'           => $idTrResign,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $bd->amount,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    } else {
                        $billDiscountOld = $billDiscount;
                        $billDiscount = 0;
                        $diffDiscountPlus = $bd->balance + $billDiscountOld;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => null,
                            'balance'    => $diffDiscountPlus,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_resign_details')
                        ->insert([
                            'id_tr_resign'           => $idTrResign,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $billDiscountOld,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    }
                }
            }
        }
    }
}
