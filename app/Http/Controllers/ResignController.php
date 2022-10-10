<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ResignController extends Controller
{
    public function index(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodActive = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periodSelect = $r->input('period_select') ?? $periodActive->period;

        return view('operator.resign',['si'=>$si,'period'=>$period,'ps'=>$periodSelect]);
    }

    public function data(Request $r)
    {
        $period = $r->input('period_select') ?? null;

        if ($r->ajax()) {
            $data = DB::table('resigns as a')
                ->join('registrations as b', 'a.id_regist','=','b.id')
                ->join('tm_grades as c', 'b.grade','=','c.id')
                ->join('tm_majors as d', 'b.major','=','d.id')
                ->join('tm_phase_registrations as e', 'b.phase','=','e.id')
                ->join('tm_statuss as f', 'b.status','=','f.id')
                ->select('b.no_regist','b.period','e.name as phase','b.name','c.name as grade','d.name as major',
                    'f.name as status','a.remark','a.user','a.created_at')
                ->where('b.period', $period);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $created_at = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data_fix[] = [ 
                    'no_regist'    => $d->no_regist,
                    'period'       => $d->period,
                    'phase'        => $d->phase,
                    'name'         => $d->name,
                    'grade'        => $d->grade,
                    'major'        => $d->major,
                    'status'       => $d->status,
                    'remark'       => $d->remark,
                    'user'         => $d->user,
                    'update'       => $created_at
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function create()
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $periodActive = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periodSelect = $periodActive->period;

        return view('operator.resign-create',['si'=>$si,'ps'=>$periodSelect]);
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
            'id_regist' => 'required|integer',
            'remark'    => 'required|string',
        ];
    
        $messages = [
            'id_regist.required' => 'Nomor, Nama, Email wajib diisi',
            'id_regist.integer'  => 'Nomor, Nama, Email tidak sesuai pilihan',
            'remark.required'    => 'Keterangan wajib diisi',
            'remark.string'      => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $idRegist     = $r->input('id_regist');
        $remark       = $r->input('remark');
        $tmResign     = DB::table('tm_resigns')->count();

        $idResign = DB::table('resigns')
                    ->insertGetId([
                        'id_regist'  => $idRegist,
                        'remark'     => $remark,
                        'user'       => Auth::user()->email,
                        'created_at' => now()
                    ]);

        DB::table('registrations')
        ->where('id',$idRegist)
        ->update([
            'status'     => 4,
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);

        if(empty($tmResign)){
            $idTrResign = 0;
            return redirect()->route('mundur-pdf',['id'=>$idRegist,'id_tr_resign'=>$idTrResign]);
        }
        $discount = DB::table('tm_resigns')->select('discount')->first();
        if($discount->discount == 0){
            return redirect()->back()->with('success', 'Pembatalan Berhasil - Tanpa Pemotongan');
        }

        $pay          = DB::table('tr_pay')->select('id','bill','amount','balance')->where('id_regist',$idRegist)->first();
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
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);

        $idTrResign = DB::table('tr_resigns')
                        ->insertGetId([
                            'id_pay'     => $pay->id,
                            'id_resign'  => $idResign,
                            'amount'     => $billDiscount,
                            'user'       => Auth::user()->email,
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                } else {
                    $diffBalancePlus = $bd->balance + $billDiscountOld;
                    DB::table('tr_pay_details')
                    ->where('id',$bd->id)
                    ->update([
                        'amount'     => $diffbillDiscount,
                        'balance'    => $diffBalancePlus,
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
                DB::table('tr_resign_details')
                ->insert([
                    'id_tr_resign'           => $idTrResign,
                    'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                    'amount'                 => $billDiscountOld,
                    'user'                   => Auth::user()->email,
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
                        'user'       => Auth::user()->email,
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                }
                DB::table('tr_resign_details')
                ->insert([
                    'id_tr_resign'           => $idTrResign,
                    'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                    'amount'                 => $bd->amount,
                    'user'                   => Auth::user()->email,
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                    DB::table('tr_resign_details')
                    ->insert([
                        'id_tr_resign'           => $idTrResign,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $bd->amount,
                        'user'                   => Auth::user()->email,
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
                        'user'       => Auth::user()->email,
                        'updated_at' => now()
                    ]);
                    DB::table('tr_resign_details')
                    ->insert([
                        'id_tr_resign'           => $idTrResign,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $billDiscountOld,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                }
            }
        }

        // return redirect()->back()->with('success', 'Pembatalan Berhasil - Dengan Pemotongan');
        return redirect()->route('mundur-pdf',['id'=>$idRegist,'id_tr_resign'=>$idTrResign]);
    }

    public function pdf($id,$idTrResign)
    {
        $regist     = DB::table('registrations as a')
                        ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                        ->join('tm_grades as c', 'a.grade','=','c.id')
                        ->join('tm_majors as d', 'a.major','=','d.id')
                        ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                        ->select('a.no_regist','a.status','a.name','a.email_student','a.stay_address','a.remark','a.hp_parent',
                            'a.phase as id_phase','b.name as phase','e.name as school','a.grade as id_grade','c.name as grade',
                            'a.major as id_major','d.name as major')
                        ->where('a.id',$id)->first();
        $schoolInfo = DB::table('school_infos')
                        ->select('name','distric','school_year','letter_head','pay_wa_message')->first();
        $hotline    = DB::table('tm_hotlines as a')
                        ->join('tm_hotline_types as b', 'a.type','=','b.id')
                        ->select('a.name','a.lines','b.name as type')->first();

        if(!empty($idTrResign))
        {
            $dataResign    = DB::table('tr_resign_details as a')
                            ->join('tm_cost_payment_details as b', 'a.id_cost_payment_detail','=','b.id')
                            ->join('tm_cost_payment_detail_masters as c', 'b.id_detail_master','=','c.id')
                            ->select('b.myorder','c.name','a.amount')
                            ->where('a.id_tr_resign', $idTrResign)
                            ->orderBy('b.myorder')->get();
            $dataResignSum = DB::table('tr_resign_details')->where('id_tr_resign', $idTrResign)->sum('amount');
        } 
        else 
        {
            $dataResign    = null;
            $dataResignSum = null;
            $resign        = null;
        }

        $resign = DB::table('resigns')->select('created_at')->where('id_regist', $id)->first();
        $now    = date('Y-m-d', strtotime($resign->created_at));
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $now);
        $tanggal = $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];

        $pdf = PDF::loadView('operator.resign-pdf',['school'=>$schoolInfo,'data_daftar'=>$regist,'hotline'=>$hotline,'dataResign'=>$dataResign,'dataResignSum'=>$dataResignSum,'tgl'=>$tanggal])->setPaper('a5');
        return $pdf->stream('Kwitansi Pembatalan - '.$regist->no_regist.'.pdf');
    }
}
