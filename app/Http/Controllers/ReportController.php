<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayRegistExport;
use App\Exports\PayExport;
use App\Exports\PayTrExport;
use App\Exports\WaExport;
use App\Exports\MailExport;
use App\Exports\ResignExport;
use App\Exports\PayDetailExport;

class ReportController extends Controller
{
    public function pay_regist(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodActive = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periodSelect = $r->input('period_select') ?? $periodActive->period;
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->format('d-m-Y');

        return view('operator.report-pay-regist',['si'=>$si,'period'=>$period,'ps'=>$periodSelect,'cf'=>$createdFrom,'ct'=>$createdTo]);
    }

    public function pay_regist_data(Request $r)
    {
        $period         = $r->input('period_select') ?? null;
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) {
            $data = DB::table('tr_registrations as a')
                    ->join('registrations as b', 'a.id_regist','=','b.id')
                    ->join('tm_grades as c', 'b.grade','=','c.id')
                    ->join('tm_majors as d', 'b.major','=','d.id')
                    ->join('tm_phase_registrations as e', 'b.phase','=','e.id')
                    ->select('b.period','e.name as phase','b.no_regist','b.name','c.name as grade','d.name as major','a.amount')
                    ->where('b.period', $period)
                    ->whereBetween('a.created_at', [$createdFormFix, $createdToFix]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $data_fix[] = [ 
                    'period'     => $d->period,
                    'phase'      => $d->phase,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'amount'     => $d->amount
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function pay_regist_download(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('tr_registrations as a')
                    ->join('registrations as b', 'a.id_regist','=','b.id')
                    ->join('tm_grades as c', 'b.grade','=','c.id')
                    ->join('tm_majors as d', 'b.major','=','d.id')
                    ->join('tm_phase_registrations as e', 'b.phase','=','e.id')
                    ->select('b.period','e.name as phase','b.no_regist','b.name','c.name as grade','d.name as major','a.amount')
                    ->where('b.period', $period)
                    ->whereBetween('a.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new PayRegistExport($data), 'Bayar_Pendaftaran.xlsx');
    }

    public function pay(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodActive = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periodSelect = $r->input('period_select') ?? $periodActive->period;
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->format('d-m-Y');

        return view('operator.report-pay',['si'=>$si,'period'=>$period,'ps'=>$periodSelect,'cf'=>$createdFrom,'ct'=>$createdTo]);
    }

    public function pay_data(Request $r)
    {
        $period         = $r->input('period_select') ?? null;
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major','e.bill','e.amount','e.balance')
                ->where('a.period', $period)
                ->whereBetween('e.updated_at', [$createdFormFix, $createdToFix])
                ->orWhereRaw('e.created_at BETWEEN '.$createdFormFix.' AND '.$createdToFix);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $data_fix[] = [ 
                    'period'     => $d->period,
                    'phase'      => $d->phase,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'bill'       => $d->bill,
                    'amount'     => $d->amount,
                    'balance'    => $d->balance
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function pay_download(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major','e.bill','e.amount','e.balance')
                ->where('a.period', $period)
                ->whereBetween('e.updated_at', [$createdFormFix, $createdToFix])
                ->orWhereRaw('e.created_at BETWEEN '.$createdFormFix.' AND '.$createdToFix)->get();

        return Excel::download(new PayExport($data), 'Pembayaran.xlsx');
    }

    public function pay_detail_download(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $dataHeader = DB::table('registrations as a')
                ->join('tr_pay as b', 'a.id','=','b.id_regist')
                ->join('tr_pay_details as c', 'b.id','=','c.id_pay')
                ->join('tm_cost_payment_details as d', 'c.id_cost_payment_detail','=','d.id')
                ->join('tm_cost_payment_detail_masters as e', 'd.id_detail_master','=','e.id')
                ->distinct()
                ->where('a.period', $period)
                ->whereBetween('b.updated_at', [$createdFormFix, $createdToFix])
                ->orWhereRaw('b.created_at BETWEEN '.$createdFormFix.' AND '.$createdToFix)
                ->get('e.name');

        $data = DB::select('CALL report_pay_detail(?)',array($period));

        return Excel::download(new PayDetailExport($data,$dataHeader), 'Pembayaran Detail.xlsx');
    }

    public function pay_tr(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodActive = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periodSelect = $r->input('period_select') ?? $periodActive->period;
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->format('d-m-Y');

        return view('operator.report-pay-tr',['si'=>$si,'period'=>$period,'ps'=>$periodSelect,'cf'=>$createdFrom,'ct'=>$createdTo]);
    }

    public function pay_tr_data(Request $r)
    {
        $period         = $r->input('period_select') ?? null;
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->join('tr_payments as f', 'e.id','=','f.id_pay')
                ->join('tm_pay_methods as g', 'f.method','=','g.id')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'g.name as method','f.transfer_date','f.transfer_no','f.remark','f.amount','f.tr_at','f.created_at')
                ->where('a.period', $period)
                ->whereBetween('f.created_at', [$createdFormFix, $createdToFix]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                if($d->transfer_date){
                    $td = date('d-m-Y', strtotime($d->transfer_date));
                }else{
                    $td = null;
                }
                $ta = date('d-m-Y', strtotime($d->tr_at));
                $ca = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data_fix[] = [ 
                    'period'        => $d->period,
                    'phase'         => $d->phase,
                    'no_regist'     => $d->no_regist,
                    'name'          => $d->name,
                    'grade'         => $d->grade,
                    'major'         => $d->major,
                    'method'        => $d->method,
                    'transfer_date' => $td,
                    'transfer_no'   => $d->transfer_no,
                    'remark'        => $d->remark,
                    'amount'        => $d->amount,
                    'tr_at'         => $ta,
                    'created_at'    => $ca,
                ];
            }

            return DataTables::of($data_fix)
            ->addColumn('action', function($row){
                $amount = 'Rp '.number_format($row['amount']);
                $actionBtn = '
                    <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#show" data-coreui-periode="'.$row['period'].'" data-coreui-gelombang="'.$row['phase'].'" data-coreui-nodaftar="'.$row['no_regist'].'" data-coreui-nama="'.$row['name'].'" data-coreui-kelompok="'.$row['grade'].'" data-coreui-jurusan="'.$row['major'].'" data-coreui-metode="'.$row['method'].'" data-coreui-tgltransfer="'.$row['transfer_date'].'" data-coreui-notransfer="'.$row['transfer_no'].'" data-coreui-keterangan="'.$row['remark'].'" data-coreui-jumlah="'.$amount.'" data-coreui-tgltransaksi="'.$row['tr_at'].'" data-coreui-update="'.$row['created_at'].'"><i class="cil-book" style="font-weight:bold"></i></button>
                    ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function pay_tr_download(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->join('tr_payments as f', 'e.id','=','f.id_pay')
                ->join('tm_pay_methods as g', 'f.method','=','g.id')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'g.name as method','f.transfer_date','f.transfer_no','f.remark','f.amount','f.tr_at','f.created_at')
                ->where('a.period', $period)
                ->whereBetween('f.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new PayTrExport($data), 'Transaksi_Pembayaran.xlsx');
    }

    public function wa(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->addDay()->format('d-m-Y');

        return view('operator.report-wa',['si'=>$si,'cf'=>$createdFrom,'ct'=>$createdTo]);
    }

    public function wa_data(Request $r)
    {
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('whatsapps as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'e.type','e.response','e.created_at')
                ->whereBetween('e.created_at', [$createdFormFix, $createdToFix]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $ca = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data_fix[] = [ 
                    'period'     => $d->period,
                    'phase'      => $d->phase,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'type'       => $d->type,
                    'response'   => $d->response,
                    'created_at' => $ca,
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function wa_download(Request $r)
    {
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('whatsapps as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'e.type','e.response','e.created_at')
                ->whereBetween('e.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new WaExport($data), 'Whatsapp.xlsx');
    }

    public function mail(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->addDay()->format('d-m-Y');

        return view('operator.report-mail',['si'=>$si,'cf'=>$createdFrom,'ct'=>$createdTo]);
    }

    public function mail_data(Request $r)
    {
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('emails as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'e.type','e.response','e.created_at')
                ->whereBetween('e.created_at', [$createdFormFix, $createdToFix]);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $ca = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data_fix[] = [ 
                    'period'     => $d->period,
                    'phase'      => $d->phase,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'type'       => $d->type,
                    'response'   => $d->response,
                    'created_at' => $ca,
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function mail_download(Request $r)
    {
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('emails as e', 'a.id','=','e.id_regist')
                ->select('a.period','d.name as phase','a.no_regist','a.name','b.name as grade','c.name as major',
                    'e.type','e.response','e.created_at')
                ->whereBetween('e.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new MailExport($data), 'Email.xlsx');
    }

    public function resign()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $p  = DB::table('tm_periods')->select('period')->where('status','Y')->first();

        return view('operator.report-resign',['si'=>$si,'ps'=>$p->period]);
    }

    public function resign_data(Request $r)
    {
        $period = $r->input('period') ?? null;

        if ($r->ajax()) {
            $data = DB::table('resigns as a')
                    ->join('registrations as b', 'a.id_regist','=','b.id')
                    ->join('tm_phase_registrations as c', 'b.phase','=','c.id')
                    ->join('tm_grades as d', 'b.grade','=','d.id')
                    ->join('tm_majors as e', 'b.major','=','e.id')
                    ->join('tr_resigns as f', 'a.id','=','f.id_resign')
                    ->select('b.period','c.name as phase','b.no_regist','b.name','d.name as grade','e.name as major',
                    'f.amount','a.remark','a.user','a.created_at')
                    ->where('b.period', $period);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $ca = date('d-m-Y H:i:s', strtotime($d->created_at));
                $phase = $d->phase.' Periode '.$d->period;

                $data_fix[] = [ 
                    'no_regist'  => $d->no_regist,
                    'phase'      => $phase,
                    'name'       => $d->name,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'amount'     => number_format($d->amount),
                    'remark'     => $d->remark,
                    'user'       => $d->user,
                    'created_at' => $ca
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function resign_download(Request $r)
    {
        $period = $r->input('period_select_d');

        $data = DB::table('resigns as a')
                    ->join('registrations as b', 'a.id_regist','=','b.id')
                    ->join('tm_phase_registrations as c', 'b.phase','=','c.id')
                    ->join('tm_grades as d', 'b.grade','=','d.id')
                    ->join('tm_majors as e', 'b.major','=','e.id')
                    ->join('tr_resigns as f', 'a.id','=','f.id_resign')
                    ->select('b.period','c.name as phase','b.no_regist','b.name','d.name as grade','e.name as major',
                    'f.amount','a.remark','a.user','a.created_at')
                    ->where('b.period', $period)->get();

        return Excel::download(new ResignExport($data), 'Mundur.xlsx');
    }
}
