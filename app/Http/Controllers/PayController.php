<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PayMail;
use Swift_TransportException;
use Exception;

class PayController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('operator.pay',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $period = DB::table('tm_periods')->select('period')->where('status','Y')->first();
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('regist_receives as e', 'a.id','=','e.id_regist')
                ->select('a.id','a.period','a.no_regist','b.name as grade','c.name as major','d.name as phase','a.name','e.created_at as receive_date')
                ->where([['a.status', 2],['a.period', $period->period]]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                if(empty($d->receive_date)) {
                    $receive_date = null;
                } else {
                    $receive_date = date('d-m-Y H:i:s', strtotime($d->receive_date));
                }

                $data_fix[] = [ 
                    'id'           => $d->id,
                    'period'       => $d->period,
                    'no_regist'    => $d->no_regist,
                    'grade'        => $d->grade,
                    'major'        => $d->major,
                    'phase'        => $d->phase,
                    'name'         => $d->name,
                    'receive_date' => $receive_date
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="'.route('bayar-show',['id'=>$row['id']]).'" class="btn btn-sm btn-success"><i class="cil-dollar" style="font-weight:bold"></i></a> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $si        = DB::table('school_infos')->select('name','icon')->first();
        $payMethod = DB::table('tm_pay_methods')->select('id','name')->get();
        $data      = DB::table('registrations as a')
                    ->join('tm_grades as b', 'a.grade','=','b.id')
                    ->join('tm_majors as c', 'a.major','=','c.id')
                    ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                    ->leftJoin('tr_pay as e', 'a.id','=','e.id_regist')
                    ->select('a.id','a.period','a.no_regist','b.name as grade','c.name as major','d.name as phase','a.name',
                        'e.bill','e.amount','e.balance','e.user')
                    ->where('a.id', $id)->first();

        return view('operator.payment',['si'=>$si,'payMethod'=>$payMethod,'d'=>$data]);
    }

    public function bill(Request $r)
    {
        $id = $r->input('id');
        $cekPay = DB::table('tr_pay')->where('id_regist',$id)->count();
        if(!empty($cekPay))
        {
            return redirect()->back()->with('error', 'Tagihan Sudah Ada');
        }
        $regist = DB::table('registrations')->select('phase','grade','major')->where('id',$id)->first();
        $registPayMajor = DB::table('tm_cost_payments')->where([['phase',$regist->phase],['grade',$regist->grade],['major',$regist->major]])->count();
        if(!empty($registPayMajor))
        {
            $registPay = DB::table('tm_cost_payments')->select('id','amount')->where([['phase',$regist->phase],['grade',$regist->grade],['major',$regist->major]])->first();
        }
        else 
        {
            $registPay = DB::table('tm_cost_payments')->select('id','amount')->where([['phase',$regist->phase],['grade',$regist->grade]])->first();
        }
        if(empty($registPay)) {
            return redirect()->back()->with('error', 'Tagihan belum dibuat!!! Silahkan hubungi Administrator');
        }
        $registPayDetail = DB::table('tm_cost_payment_details')->select('id','amount')->where('id_payment',$registPay->id)->get();
        DB::table('tr_pay')
            ->insert([
                'id_regist'       => $id,
                'id_cost_payment' => $registPay->id,
                'bill'            => $registPay->amount,
                'balance'         => $registPay->amount,
                'user'            => Auth::user()->email,
                'created_at'      => now()
            ]);
        
        $trPay = DB::table('tr_pay')->select('id')->where('id_regist',$id)->first();
        foreach ($registPayDetail as $rpd) {
            DB::table('tr_pay_details')
                ->insert([
                    'id_pay'       => $trPay->id,
                    'id_cost_payment_detail' => $rpd->id,
                    'bill'            => $rpd->amount,
                    'balance'         => $rpd->amount,
                    'user'            => Auth::user()->email,
                    'created_at'      => now()
                ]);
        }

        return redirect()->back()->with('success', 'Tagihan berhasil di buat');
    }

    public function store(Request $r)
    {
        $rules = [
            'id'            => 'required|integer',
            'pay_method'    => 'required|integer',
            'tr_at'         => 'nullable|string',
            'transfer_date' => 'nullable|string',
            'transfer_no'   => 'nullable|string',
            'amount'        => 'required|integer',
            'remark'        => 'nullable|string',
        ];
    
        $messages = [
            'id.required'          => 'ID wajib diisi',
            'id.integer'           => 'ID tidak ditemukan',
            'pay_method.required'  => 'Metode wajib diisi',
            'pay_method.integer'   => 'Metode tidak ditemukan',
            'tr_at.string'         => 'Tanggal harus berupa string',
            'transfer_date.string' => 'Tanggal Transfer harus berupa string',
            'transfer_no.string'   => 'Nomor Transfer harus berupa string',
            'amount.required'      => 'Jumlah wajib diisi',
            'amount.integer'       => 'Jumlah harus berupa angka',
            'remark.string'        => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }

        $id              = $r->input('id');
        $payMethod       = $r->input('pay_method');
        $trAt            = $r->input('tr_at');
        if(empty($trAt)) {
            $trAt = now()->format('Y-m-d');
        }
        $transferDate    = $r->input('transfer_date');
        $transferNo      = $r->input('transfer_no');
        $amount          = $r->input('amount');
        $remark          = $r->input('remark');
        $pay             = DB::table('tr_pay')->select('id','bill','amount','balance')->where('id_regist',$id)->first();

        $idPayment       = DB::table('tr_payments')
                            ->insertGetId([
                                'id_pay'        => $pay->id,
                                'method'        => $payMethod,
                                'transfer_date' => $transferDate,
                                'transfer_no'   => $transferNo,
                                'remark'        => $remark,
                                'amount'        => $amount,
                                'tr_at'         => $trAt,
                                'user'          => Auth::user()->email,
                                'created_at'    => now()
                            ]);

        $total           = $pay->amount + $amount;
        if($total > $pay->bill) {
            $total = $pay->bill;
        }
        $balance         = $pay->balance - $amount;
        $regist          = DB::table('registrations as a')
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
                'user'       => Auth::user()->email,
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
            return redirect()->back()->with('error', 'Pembayaran sudah lunas');
        }
        if($pay->balance == '0' || $billDetailCount == 0) {
            return redirect()->back()->with('error', 'Terdapat kesalahan. Master dan Detail tidak sinkron!');
        }
        
        foreach ($billDetail as $bd) 
        {
            if(empty($amount) || $amount == 0) {
                //
                // echo 'empty($amount) || $amount == 0 '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $amountOld,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount < $bd->balance , empty($bd->amount) '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $amountOld,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount < $bd->balance , empty($bd->amount) else '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $bd->balance,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount > $bd->balance, empty($bd->amount) '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $bd->balance,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount > $bd->balance, empty($bd->amount) else '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $bd->balance,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount == $bd->balance , empty($bd->amount) '.$bd->id.'<br>';
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
                    DB::table('tr_payment_details')
                    ->insert([
                        'id_payment'             => $idPayment,
                        'id_cost_payment_detail' => $bd->id_cost_payment_detail,
                        'amount'                 => $amountOld,
                        'user'                   => Auth::user()->email,
                        'created_at'             => now()
                    ]);
                    // echo '$amount == $bd->balance , empty($bd->amount) else '.$bd->id.'<br>';
                }
            }
        }

        DB::table('tr_pay')
        ->where('id_regist',$id)
        ->update([
            'amount'     => $total,
            'balance'    => $balance,
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);
        
        return redirect()->route('bayar-pdf',['id'=>$id,'id_payment'=>$idPayment]);
    }

    public function pdf($id,$idPayment)
    {
        $regist     = DB::table('registrations as a')
                        ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                        ->join('tm_grades as c', 'a.grade','=','c.id')
                        ->join('tm_majors as d', 'a.major','=','d.id')
                        ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                        ->select('a.id','a.no_regist','a.status','a.name','a.email_student','a.stay_address','a.remark','a.hp_parent',
                            'a.phase as id_phase','b.name as phase','e.name as school','a.grade as id_grade','c.name as grade',
                            'a.major as id_major','d.name as major')
                        ->where('a.id',$id)->first();
        $schoolInfo = DB::table('school_infos')
                        ->select('name','distric','school_year','letter_head','wa_api','wa_api_key','pay_wa_message')->first();
        $mail_hotline = DB::table('tm_hotlines as a')
                        ->join('tm_hotline_types as b', 'a.type','=','b.id')
                        ->select('a.name','a.lines','b.name as type')
                        ->get();
        $hotline    = DB::table('tm_hotlines as a')
                        ->join('tm_hotline_types as b', 'a.type','=','b.id')
                        ->select('a.name','a.lines','b.name as type')->first();

        $dataPay    = DB::table('tr_payment_details as a')
                        ->join('tm_cost_payment_details as b', 'a.id_cost_payment_detail','=','b.id')
                        ->join('tm_cost_payment_detail_masters as c', 'b.id_detail_master','=','c.id')
                        ->select('b.myorder','c.name','a.amount')
                        ->where('a.id_payment', $idPayment)->get();
        $dataPaySum = DB::table('tr_payment_details')->where('id_payment', $idPayment)->sum('amount');
        $payment    = DB::table('tr_payments')->select('created_at')->where('id', $idPayment)->first();
        $pay        = DB::table('tr_pay')->select('bill')->where('id_regist', $regist->id)->first();
        $payBalance = $pay->bill - $dataPaySum;

        $now = date('Y-m-d', strtotime($payment->created_at));
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

        $op = Auth::user()->name;

        try{
            Mail::to($regist->email_student)->send(new PayMail($regist, $schoolInfo, $mail_hotline));
        } catch (Swift_TransportException $e) {
            $res = $e->getMessage();
            DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'Pay', 'response' => $res, 'created_at' => now()]);
        } catch (Exception $e) {
            $res = $e->getMessage();
            DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'Pay', 'response' => $res, 'created_at' => now()]);
        }

        if(!empty($schoolInfo->wa_api)) {
            $smp               = $regist->school ?? $regist->remark;
            $hotline1          = $hotline->name.' : '.$hotline->lines.' ('.$hotline->type.')';
            $regist_wa_message = $schoolInfo->pay_wa_message;
            $regist_wa_message = preg_replace("/%email%/i", $regist->email_student, $regist_wa_message);
            $regist_wa_message = preg_replace("/%gelombang%/i", $regist->phase, $regist_wa_message);
            $regist_wa_message = preg_replace("/%no_daftar%/i", $regist->no_regist, $regist_wa_message);
            $regist_wa_message = preg_replace("/%nama%/i", $regist->name, $regist_wa_message);
            $regist_wa_message = preg_replace("/%alamat%/i", $regist->stay_address, $regist_wa_message);
            $regist_wa_message = preg_replace("/%smp%/i", $smp, $regist_wa_message);
            $regist_wa_message = preg_replace("/%kelompok%/i", $regist->grade, $regist_wa_message);
            $regist_wa_message = preg_replace("/%jurusan%/i", $regist->major, $regist_wa_message);
            $regist_wa_message = preg_replace("/%bayar%/i", number_format($dataPaySum), $regist_wa_message);
            $regist_wa_message = preg_replace("/%tagihan%/i", number_format($pay->bill), $regist_wa_message);
            $regist_wa_message = preg_replace("/%kurang%/i", number_format($payBalance), $regist_wa_message);
            $regist_wa_message = preg_replace("/%hotline1%/i", $hotline1, $regist_wa_message);
            $url = $schoolInfo->wa_api;
            $key = $schoolInfo->wa_api_key;
            $data = array(
            "phone_no" => $regist->hp_parent,
            "key"      => $key,
            "message"  => $regist_wa_message,
            );
            $data_string = json_encode($data);
    
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 360);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
            );
            echo $res=curl_exec($ch);
            DB::table('whatsapps')->insert(['id_regist' => $id, 'type' => 'Pay', 'response' => $res, 'created_at' => now()]);
            curl_close($ch);
        }

        $pdf = PDF::loadView('operator.pay-pdf',['school'=>$schoolInfo,'data_daftar'=>$regist,'hotline'=>$hotline,'dataPay'=>$dataPay,'dataPaySum'=>$dataPaySum,'tgl'=>$tanggal,'op'=>$op])->setPaper('a5');
        return $pdf->stream('Kwitansi Bayar - '.$regist->no_regist.'.pdf');
    }

    public function detail($id)
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
        $dataPay   = DB::table('tr_pay as a')
                    ->join('tr_pay_details as b', 'a.id','=','b.id_pay')
                    ->join('tm_cost_payment_details as c', 'b.id_cost_payment_detail','=','c.id')
                    ->join('tm_cost_payment_detail_masters as d', 'c.id_detail_master','=','d.id')
                    ->select('c.myorder','d.name','b.bill','b.amount','b.balance')
                    ->where('a.id_regist',$id)
                    ->orderBy('c.myorder')->get();

        return view('operator.payment-detail',['si'=>$si,'d'=>$data,'dataPay'=>$dataPay]);
    }
}
