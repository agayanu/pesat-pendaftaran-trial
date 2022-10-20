<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class Pay3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $registx = DB::table('registrations as a')->join('tr_pay as b', 'a.id','=','b.id_regist')
                    ->select('a.id','a.grade')->where('a.period',2022)->inRandomOrder()->limit(600)->get();
        $user   = 'operator@smapluspgri.sch.id';
        foreach ($registx as $r) {
            $randMethod = DB::table('tm_pay_methods')->select('id')->inRandomOrder()->first();
            
            $id              = $r->id;
            $payMethod       = $randMethod->id;
            $trAt            = now()->format('Y-m-d');
            if($payMethod == 2) {
                $transferDate = now()->format('Y-m-d');
                $transferNo   = mt_rand(1111111111, 9999999999);
            } else {
                $transferDate = null;
                $transferNo   = null;
            }
            if($r->grade == 1) {
                $amount = $faker->randomElement(['4000000','5000000','6800000']);
            }
            if($r->grade == 2) {
                $amount = $faker->randomElement(['6000000','8000000','11050000']);
            }
            $pay       = DB::table('tr_pay')->select('id','bill','amount','balance')->where('id_regist',$id)->first();

            $idPayment = DB::table('tr_payments')
                            ->insertGetId([
                                'id_pay'        => $pay->id,
                                'method'        => $payMethod,
                                'transfer_date' => $transferDate,
                                'transfer_no'   => $transferNo,
                                'amount'        => $amount,
                                'tr_at'         => $trAt,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            $total = $pay->amount + $amount;
            if($total > $pay->bill) {
                $total = $pay->bill;
            }
            $balance = $pay->balance - $amount;
            $regist  = DB::table('registrations as a')
                        ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                        ->join('tm_grades as c', 'a.grade','=','c.id')
                        ->join('tm_majors as d', 'a.major','=','d.id')
                        ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                        ->select('a.no_regist','a.status','a.name','a.email_student','a.stay_address','a.remark','a.hp_parent',
                            'a.phase as id_phase','b.name as phase','e.name as school','a.grade as id_grade','c.name as grade',
                            'a.major as id_major','d.name as major')
                        ->where('a.id',$id)->first();

            if($regist->status == 2) {
                DB::table('registrations')
                ->where('id',$id)
                ->update([
                    'status'     => 3,
                    'user'       => $user,
                    'updated_at' => now()
                ]);
            }

            $billDetail      = DB::table('tr_pay as a')
                                ->join('tr_pay_details as b', 'a.id','=','b.id_pay')
                                ->join('tm_cost_payment_details as c', 'b.id_cost_payment_detail','=','c.id')
                                ->select('b.id','b.id_cost_payment_detail','b.amount','b.balance')
                                ->where([['a.id',$pay->id],['b.balance','!=',0]]);
            $billDetailCount = $billDetail->count();
            $billDetail      = $billDetail->orderBy('c.myorder')->get();
            if($pay->balance == '0' && $billDetailCount == 0) {
                $this->command->error("Pembayaran sudah lunas");
            }
            if($pay->balance == '0' || $billDetailCount == 0) {
                $this->command->error("Terdapat kesalahan. Master dan Detail tidak sinkron!");
            }

            foreach ($billDetail as $bd) 
            {
                if(empty($amount) || $amount == 0) {
                    //
                }
                if($amount < $bd->balance && $amount != 0) {
                    $amountOld = $amount;
                    $diffAmount = $bd->balance - $amount;
                    $amount = 0;
                    if(empty($bd->amount)) {
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $amountOld,
                            'balance'    => $diffAmount,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $amountOld,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    } else {
                        $diffAmountPlus = $bd->amount + $amountOld;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $diffAmountPlus,
                            'balance'    => $diffAmount,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $amountOld,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    }
                }
                if($amount > $bd->balance) {
                    if(empty($bd->amount)) {
                        $amount = $amount - $bd->balance;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $bd->balance,
                            'balance'    => 0,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $bd->balance,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    } else {
                        $amount = $amount - $bd->balance;
                        $diffAmountPlus = $bd->amount + $bd->balance;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $diffAmountPlus,
                            'balance'    => 0,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $bd->balance,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    }
                }
                if($amount == $bd->balance) {
                    if(empty($bd->amount)) {
                        $amount = 0;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $bd->balance,
                            'balance'    => 0,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $bd->balance,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    } else {
                        $amountOld = $amount;
                        $amount = 0;
                        $diffAmountPlus = $bd->amount + $amountOld;
                        DB::table('tr_pay_details')
                        ->where('id',$bd->id)
                        ->update([
                            'amount'     => $diffAmountPlus,
                            'balance'    => 0,
                            'user'       => $user,
                            'updated_at' => now()
                        ]);
                        DB::table('tr_payment_details')
                        ->insert([
                            'id_payment'             => $idPayment,
                            'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                            'amount'                 => $amountOld,
                            'user'                   => $user,
                            'created_at'             => now()
                        ]);
                    }
                }
            }

            DB::table('tr_pay')
            ->where('id_regist',$id)
            ->update([
                'amount'     => $total,
                'balance'    => $balance,
                'user'       => $user,
                'updated_at' => now()
            ]);
        }
    }
}
