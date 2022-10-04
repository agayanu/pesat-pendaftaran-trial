<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PayFinishController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('operator.pay-finish',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $period = DB::table('tm_periods')->select('period')->where('status','Y')->first();
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->select('a.id','a.no_regist','d.name as phase','a.period','a.name','b.name as grade','c.name as major','e.bill','e.amount','e.balance','e.user','e.created_at','e.updated_at')
                ->where([['e.balance', 0],['a.period', $period->period]]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $phase = $d->phase.' Periode '.$d->period;

                $data_fix[] = [ 
                    'id'           => $d->id,
                    'no_regist'    => $d->no_regist,
                    'phase'        => $phase,
                    'name'         => $d->name,
                    'grade'        => $d->grade,
                    'major'        => $d->major,
                    'bill'         => number_format($d->bill),
                    'amount'       => number_format($d->amount),
                    'balance'      => number_format($d->balance),
                    'user'         => $d->user,
                    'updated_at'   => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="'.route('lunas-hapus-transaksi',['id'=>$row['id']]).'" class="btn btn-sm btn-warning">Hapus Transaksi</a>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['no_regist'].' '.$row['name'].'" data-coreui-url="'.route('lunas-hapus-tagihan',['id'=>$row['id']]).'">Hapus Tagihan</button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function tr_del($id)
    {
        $si        = DB::table('school_infos')->select('name','icon')->first();
        $data      = DB::table('registrations as a')
                    ->join('tm_grades as b', 'a.grade','=','b.id')
                    ->join('tm_majors as c', 'a.major','=','c.id')
                    ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                    ->leftJoin('tr_pay as e', 'a.id','=','e.id_regist')
                    ->select('a.id','a.period','a.no_regist','b.name as grade','c.name as major','d.name as phase','a.name',
                        'e.bill','e.amount','e.balance','e.user')
                    ->where('a.id', $id)->first();
        $payment   = DB::table('tr_pay as a')
                    ->join('tr_payments as b', 'a.id','=','b.id_pay')
                    ->join('tm_pay_methods as c', 'b.method','=','c.id')
                    ->select('b.id','c.name','b.transfer_date','b.transfer_no','b.remark','b.amount','b.tr_at','b.user',
                        'b.created_at','b.updated_at')
                    ->where('a.id_regist',$id)->get();

        return view('operator.pay-tr-del',['si'=>$si,'d'=>$data,'payment'=>$payment]);
    }

    public function destroy($id)
    {
        $rl      = DB::table('tr_payments')->select('id_pay','amount')->where('id', $id)->first();
        $pay     = DB::table('tr_pay')->select('id_regist','amount','balance')->where('id', $rl->id_pay)->first();
        $total   = $pay->amount - $rl->amount;
        if($total <= 0) {
            $total = null;
        }
        $balance = $pay->balance + $rl->amount;
        $detail  = DB::table('tr_pay_details as a')
                    ->join('tm_cost_payment_details as b', 'a.id_cost_payment_detail','=','b.id')
                    ->select('a.id','a.amount','a.balance')
                    ->where('a.id_pay',$rl->id_pay)
                    ->whereNotNull('a.amount')
                    ->orderBy('b.myorder','desc')->get();
        $amount  = $rl->amount;

        foreach ($detail as $d)
        {
            if(empty($amount) || $amount == 0) {
                //
            }
            if($amount < $d->amount && $amount != 0) {
                $amountOld = $amount;
                $diffAmount = $d->amount - $amount;
                $amount = 0;
                if($d->balance == 0) {
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => $diffAmount,
                        'balance'    => $amountOld,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $diffAmountPlus = $d->balance + $amountOld;
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => $diffAmount,
                        'balance'    => $diffAmountPlus,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
            }
            if($amount > $d->amount) {
                $amount = $amount - $d->amount;
                if($d->balance == 0) {
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => null,
                        'balance'    => $d->amount,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $diffAmountPlus = $d->amount + $d->balance;
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => null,
                        'balance'    => $diffAmountPlus,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
            }
            if($amount == $d->amount) {
                if($d->balance == 0) {
                    $amount = 0;
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => null,
                        'balance'    => $d->amount,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $amountOld = $amount;
                    $amount = 0;
                    $diffAmountPlus = $d->amount + $amountOld;
                    DB::table('tr_pay_details')
                    ->where('id',$d->id)
                    ->update([
                        'amount'     => null,
                        'balance'    => $diffAmountPlus,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
            }
        }

        DB::table('tr_pay')
        ->where('id',$rl->id_pay)
        ->update([
            'amount'     => $total,
            'balance'    => $balance,
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);

        if(empty($total)) {
            DB::table('registrations')
            ->where('id',$pay->id_regist)
            ->update([
                'status'     => 2,
                'user'       => Auth::user()->email,
                'updated_at' => now()
            ]);
        }

        DB::table('tr_payment_details')->where('id_payment', $id)->delete();

        DB::table('tr_payments')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Transaksi '.$rl->amount.' berhasil di hapus');
    }

    public function bill_del($id)
    {
        $d = DB::table('registrations as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tr_pay as c', 'a.id','=','c.id_regist')
            ->select('b.name as phase','a.period','a.no_regist','a.name','c.id as id_pay')
            ->where('a.id', $id)->first();
        $idPayment = DB::table('tr_payments')->select('id')->where('id_pay', $d->id_pay)->first();

        DB::table('tr_payment_details')->where('id_payment', $idPayment->id)->delete();
        DB::table('tr_payments')->where('id', $idPayment->id)->delete();
        DB::table('tr_pay_details')->where('id_pay', $d->id_pay)->delete();
        DB::table('tr_pay')->where('id', $d->id_pay)->delete();

        DB::table('registrations')
        ->where('id',$id)
        ->update([
            'status'     => 2,
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Tagihan '.$d->no_regist.' '.$d->name.' '.$d->phase.' Periode '.$d->period.' berhasil di hapus');
    }
}
