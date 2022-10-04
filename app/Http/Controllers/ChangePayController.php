<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChangePayExport;

class ChangePayController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $period = DB::table('tm_periods')->select('period')->where('status','Y')->first();

        return view('operator.change-pay',['si'=>$si,'ps'=>$period->period]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $period = DB::table('tm_periods')->select('period')->where('status','Y')->first();
            $data = DB::table('tr_change_pays as a')
                ->join('tr_pay as b', 'a.id_pay','=','b.id')
                ->join('registrations as c', 'b.id_regist','=','c.id')
                ->join('tm_change_cost_payments as d', 'a.id_change_cost','=','d.id')
                ->join('tm_cost_payments as e', 'd.id_cost_payment_from','=','e.id')
                ->join('tm_cost_payments as f', 'd.id_cost_payment_to','=','f.id')
                ->join('tm_grades as g', 'e.grade','=','g.id')
                ->join('tm_grades as h', 'f.grade','=','h.id')
                ->leftJoin('tm_majors as i', 'e.major','=','i.id')
                ->leftJoin('tm_majors as j', 'f.major','=','j.id')
                ->join('tm_phase_registrations as k', 'd.phase','=','k.id')
                ->select('a.id','c.period','k.name as phase','c.no_regist','c.name','g.name as grade_from','h.name as grade_to',
                'i.name as major_from','j.name as major_to','a.bill_from','a.bill_to','a.amount','a.balance_from','a.balance_to',
                'a.user','a.created_at')
                ->where('c.period', $period->period);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $ca          = date('d-m-Y H:i:s', strtotime($d->created_at));
                $phase       = $d->phase.' Periode '.$d->period;
                $from        = $d->grade_from.' '.$d->major_from;
                $to          = $d->grade_to.' '.$d->major_to;
                $grade_major = $from.' -> '.$to;
                $bill        = number_format($d->bill_from).' -> '.number_format($d->bill_to);
                $balance     = number_format($d->balance_from).' -> '.number_format($d->balance_to);

                $data_fix[] = [ 
                    'id'           => $d->id,
                    'no_regist'    => $d->no_regist,
                    'phase'        => $phase,
                    'name'         => $d->name,
                    'grade_major'  => $grade_major,
                    'bill'         => $bill,
                    'amount'       => number_format($d->amount),
                    'balance'      => $balance,
                    'user'         => $d->user,
                    'created_at'   => $ca
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function create()
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $periodActive = DB::table('tm_periods')->select('id','period')->where('status','Y')->first();
        $periodSelect = $periodActive->period;
        $changeCost   = DB::table('tm_change_cost_payments as a')
                        ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                        ->join('tm_cost_payments as c', 'a.id_cost_payment_from','=','c.id')
                        ->join('tm_cost_payments as d', 'a.id_cost_payment_to','=','d.id')
                        ->join('tm_grades as e', 'c.grade','=','e.id')
                        ->join('tm_grades as f', 'd.grade','=','f.id')
                        ->leftJoin('tm_majors as g', 'c.major','=','g.id')
                        ->leftJoin('tm_majors as h', 'd.major','=','h.id')
                        ->select('a.id','b.name as phase','e.name as grade_from','f.name as grade_to','g.name as major_from','h.name as major_to','c.amount as amount_from','d.amount as amount_to')
                        ->where('b.period',$periodActive->id)->get();

        return view('operator.change-pay-create',['si'=>$si,'ps'=>$periodSelect,'changeCost'=>$changeCost]);
    }

    public function search(Request $r)
    {
        $period = $r->input('period_select') ?? null;

        if($r->ajax())
        {
            $data = DB::table('registrations')
                ->select('id','name','email_student as email')
                ->where([['name','LIKE','%'.$r->term.'%'],['period',$period]])
                ->orWhere('no_regist','LIKE','%'.$r->term.'%')
                ->orWhere('email_student','LIKE','%'.$r->term.'%')
                ->paginate(10, ['*'], 'page', $r->page);

            return response()->json([$data]);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'id_regist'   => 'required|integer',
            'change_cost' => 'required|integer',
        ];
    
        $messages = [
            'id_regist.required'   => 'Nomor, Nama, Email wajib diisi',
            'id_regist.integer'    => 'Nomor, Nama, Email tidak sesuai pilihan',
            'change_cost.required' => 'Perubahan wajib diisi',
            'change_cost.integer'  => 'Perubahan tidak sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $idRegist     = $r->input('id_regist');
        $changeCost   = $r->input('change_cost');
        $regist       = DB::table('registrations')->select('phase')->where('id',$idRegist)->first();
        $changeCostTb = DB::table('tm_change_cost_payments as a')
                        ->join('tm_cost_payments as b', 'a.id_cost_payment_from','=','b.id')
                        ->join('tm_cost_payments as c', 'a.id_cost_payment_to','=','c.id')
                        ->select('a.phase','a.id_cost_payment_to','b.grade as grade_from','b.major as major_from',
                        'c.grade as grade_to','c.major as major_to','b.amount as amount_from','c.amount as amount_to')
                        ->where('a.id',$changeCost)->first();
        if($regist->phase != $changeCostTb->phase) {
            return redirect()->back()->with('error', 'Gelombang Pendaftar dengan Perubahan tidak sama');
        }
        $pay                = DB::table('tr_pay')->select('id','amount','balance')->where('id_regist',$idRegist)->first();
        $changeCostDetailTb = DB::table('tm_change_cost_payment_details')
                                ->select('id_detail_master','myorder','amount_to')
                                ->where('id_change_cost',$changeCost)->orderBy('myorder')->get();

        if(!empty($changeCostTb->major_from) && !empty($changeCostTb->major_to)) {
            DB::table('registrations')
            ->where('id',$idRegist)
            ->update([
                'grade'      => $changeCostTb->grade_to,
                'major'      => $changeCostTb->major_to,
                'user'       => Auth::user()->email,
                'updated_at' => now()
            ]);
        } else {
            DB::table('registrations')
            ->where('id',$idRegist)
            ->update([
                'grade'      => $changeCostTb->grade_to,
                'user'       => Auth::user()->email,
                'updated_at' => now()
            ]);
        }

        $balancePay = $changeCostTb->amount_to - $pay->amount;
        DB::table('tr_pay')
        ->where('id',$pay->id)
        ->update([
            'id_cost_payment' => $changeCostTb->id_cost_payment_to,
            'bill'            => $changeCostTb->amount_to,
            'balance'         => $balancePay,
            'user'            => Auth::user()->email,
            'updated_at'      => now()
        ]);

        foreach ($changeCostDetailTb as $ccd) {
            DB::table('tr_pay_details as a')
            ->join('tm_cost_payment_details as b', 'a.id_cost_payment_detail','=','b.id')
            ->where([['a.id_pay',$pay->id],['b.id_detail_master',$ccd->id_detail_master],['b.myorder',$ccd->myorder]])
            ->update([
                'a.bill'       => $ccd->amount_to,
                'a.amount'     => null,
                'a.balance'    => $ccd->amount_to,
                'a.user'       => Auth::user()->email,
                'a.updated_at' => now()
            ]);
        }

        $billDetail = DB::table('tr_pay as a')
                        ->join('tr_pay_details as b', 'a.id','=','b.id_pay')
                        ->join('tm_cost_payment_details as c', 'b.id_cost_payment_detail','=','c.id')
                        ->select('b.id','b.id_cost_payment_detail','b.amount','b.balance')
                        ->where([['a.id',$pay->id],['b.balance','!=',0]])
                        ->orderBy('c.myorder')->get();

        $amount = $pay->amount;

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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $diffAmountPlus = $bd->amount + $amountOld;
                    DB::table('tr_pay_details')
                    ->where('id',$bd->id)
                    ->update([
                        'amount'     => $diffAmountPlus,
                        'balance'    => $diffAmount,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $amount = $amount - $bd->balance;
                    $diffAmountPlus = $bd->amount + $bd->balance;
                    DB::table('tr_pay_details')
                    ->where('id',$bd->id)
                    ->update([
                        'amount'     => $diffAmountPlus,
                        'balance'    => 0,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
            }
        }

        DB::table('tr_change_pays')
        ->insert([
            'id_pay'         => $pay->id,
            'id_change_cost' => $changeCost,
            'bill_from'      => $changeCostTb->amount_from,
            'bill_to'        => $changeCostTb->amount_to,
            'amount'         => $pay->amount,
            'balance_from'   => $pay->balance,
            'balance_to'     => $balancePay,
            'user'           => Auth::user()->email,
            'created_at'     => now()
        ]);

        return redirect()->route('rubah-bayar')->with('success', 'Perubahan Pembayaran Berhasil');
    }

    public function download(Request $r)
    {
        $period = $r->input('period_select_d');

        $data = DB::table('tr_change_pays as a')
                ->join('tr_pay as b', 'a.id_pay','=','b.id')
                ->join('registrations as c', 'b.id_regist','=','c.id')
                ->join('tm_change_cost_payments as d', 'a.id_change_cost','=','d.id')
                ->join('tm_cost_payments as e', 'd.id_cost_payment_from','=','e.id')
                ->join('tm_cost_payments as f', 'd.id_cost_payment_to','=','f.id')
                ->join('tm_grades as g', 'e.grade','=','g.id')
                ->join('tm_grades as h', 'f.grade','=','h.id')
                ->leftJoin('tm_majors as i', 'e.major','=','i.id')
                ->leftJoin('tm_majors as j', 'f.major','=','j.id')
                ->join('tm_phase_registrations as k', 'd.phase','=','k.id')
                ->select('c.period','k.name as phase','c.no_regist','c.name','g.name as grade_from','h.name as grade_to',
                'i.name as major_from','j.name as major_to','a.bill_from','a.bill_to','a.amount','a.balance_from','a.balance_to',
                'a.user','a.created_at')
                ->where('c.period', $period)->get();

        return Excel::download(new ChangePayExport($data), 'Perubahan.xlsx');
    }
}
