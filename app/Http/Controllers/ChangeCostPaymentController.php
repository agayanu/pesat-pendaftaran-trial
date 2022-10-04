<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ChangeCostPaymentController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $phase = DB::table('tm_phase_registrations as a')
            ->join('tm_periods as b', 'a.period','=','b.id')
            ->select('a.id','a.name','b.period as name_period')
            ->get();
        $payment = DB::table('tm_cost_payments as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tm_periods as c', 'b.period','=','c.id')
            ->join('tm_grades as d', 'a.grade','=','d.id')
            ->leftJoin('tm_majors as e', 'a.major','=','e.id')
            ->select('a.id','b.name as name_phase','c.period as name_period','d.name as grade','e.name as major','a.amount')
            ->get();

        return view('master.change-cost-payment',['si'=>$si,'phase'=>$phase,'payment'=>$payment]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_change_cost_payments as a')
                ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                ->join('tm_periods as c', 'b.period','=','c.id')
                ->join('tm_cost_payments as d', 'a.id_cost_payment_from','=','d.id')
                ->join('tm_cost_payments as e', 'a.id_cost_payment_to','=','e.id')
                ->join('tm_grades as f', 'd.grade','=','f.id')
                ->leftJoin('tm_majors as g', 'd.major','=','g.id')
                ->join('tm_grades as h', 'e.grade','=','h.id')
                ->leftJoin('tm_majors as i', 'e.major','=','i.id')
                ->select('a.id','b.name as name_phase','c.period as name_period',
                'f.name as name_grade_from','g.name as name_major_from',
                'h.name as name_grade_to','i.name as name_major_to',
                'd.amount as amount_from','e.amount as amount_to',
                'a.change_amount','a.updated_at','a.created_at');
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

                $name_phase = $d->name_phase.' Periode '.$d->name_period;
                $from       = $d->name_grade_from.' '.$d->name_major_from;
                $to         = $d->name_grade_to.' '.$d->name_major_to;

                $data_fix[] = [ 
                    'id'              => $d->id,
                    'name_phase'      => $name_phase,
                    'from'            => $from,
                    'to'              => $to,
                    'amount_from'     => $d->amount_from,
                    'amount_to'       => $d->amount_to,
                    'change_amount'   => $d->change_amount,
                    'updated_at'      => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="'.route('rubah-biaya-pembayaran-rincian',['id'=>$row['id']]).'" class="btn btn-sm btn-success">Rincian</a>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name_phase'].' '.$row['from'].' ke '.$row['to'].'" data-coreui-url="'.url('rubah-biaya-pembayaran/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $si         = DB::table('school_infos')->select('name','icon')->first();
        $data       = DB::table('tm_change_cost_payments as a')
                        ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                        ->join('tm_periods as c', 'b.period','=','c.id')
                        ->join('tm_cost_payments as d', 'a.id_cost_payment_from','=','d.id')
                        ->join('tm_cost_payments as e', 'a.id_cost_payment_to','=','e.id')
                        ->join('tm_grades as f', 'd.grade','=','f.id')
                        ->leftJoin('tm_majors as g', 'd.major','=','g.id')
                        ->join('tm_grades as h', 'e.grade','=','h.id')
                        ->leftJoin('tm_majors as i', 'e.major','=','i.id')
                        ->select('b.name as name_phase','c.period as name_period',
                        'f.name as name_grade_from','g.name as name_major_from',
                        'h.name as name_grade_to','i.name as name_major_to',
                        'd.amount as amount_from','e.amount as amount_to',
                        'a.change_amount','a.updated_at','a.created_at')
                        ->where('a.id', $id)->first();
        $dataDetail = DB::table('tm_change_cost_payment_details as a')
                        ->join('tm_cost_payment_detail_masters as b', 'a.id_detail_master','=','b.id')
                        ->select('a.myorder','b.name','a.amount_from','a.amount_to','a.change_amount','a.created_at')
                        ->where('a.id_change_cost', $id)->orderBy('a.myorder')->get();

        return view('master.change-cost-payment-detail',['si'=>$si,'d'=>$data,'dataDetail'=>$dataDetail]);
    }

    public function store(Request $r)
    {
        $rules = [
            'phase' => 'required|integer',
            'from'  => 'required|integer',
            'to'    => 'required|integer',
        ];
    
        $messages = [
            'phase.required' => 'Gelombang wajib diisi',
            'phase.integer'  => 'Gelombang tidak sesuai pilihan',
            'from.required'  => 'Dari wajib diisi',
            'from.integer'   => 'Dari tidak sesuai pilihan',
            'to.required'    => 'Menjadi wajib diisi',
            'to.integer'     => 'Menjadi tidak sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Rubah Biaya Pembayaran gagal di tambah: '.$validator->errors());
        }

        $phase = $r->input('phase');
        $from  = $r->input('from');
        $to    = $r->input('to');

        $fromPhase = DB::table('tm_cost_payments')->select('phase','amount')->where('id',$from)->first();
        $toPhase = DB::table('tm_cost_payments')->select('phase','amount')->where('id',$to)->first();

        if($phase != $fromPhase->phase) {
            return redirect()->back()->with('error', 'Gelombang tidak sama dengan Dari');
        }
        if($phase != $toPhase->phase) {
            return redirect()->back()->with('error', 'Gelombang tidak sama dengan Menjadi');
        }

        $changeAmount = $toPhase->amount - $fromPhase->amount;

        $idChangeCost = DB::table('tm_change_cost_payments')
                        ->insertGetId([
                            'phase'                => $phase,
                            'id_cost_payment_from' => $from,
                            'id_cost_payment_to'   => $to,
                            'change_amount'        => $changeAmount,
                            'created_at'           => now()
                        ]);

        $fromData = DB::table('tm_cost_payment_details')
                    ->select('id_detail_master','myorder','amount')
                    ->where('id_payment', $from)
                    ->orderBy('myorder')->get();
        $toData   = DB::table('tm_cost_payment_details')
                    ->select('id_detail_master','myorder','amount')
                    ->where('id_payment', $to)
                    ->orderBy('myorder')->get();

        foreach($fromData as $fd)
        {
            DB::table('tm_change_cost_payment_details')
            ->insert([
                'id_change_cost'   => $idChangeCost,
                'id_detail_master' => $fd->id_detail_master,
                'myorder'          => $fd->myorder,
                'amount_from'      => $fd->amount,
                'created_at'       => now(),
            ]);
        }

        foreach($toData as $td)
        {
            $amountFrom         = DB::table('tm_change_cost_payment_details')->select('amount_from')
                                    ->where([
                                        ['id_change_cost', $idChangeCost],
                                        ['id_detail_master', $td->id_detail_master],
                                        ['myorder', $td->myorder]
                                    ])->first();
            $changeAmountDetail = $td->amount - $amountFrom->amount_from;
            DB::table('tm_change_cost_payment_details')
            ->where([['id_change_cost', $idChangeCost],['id_detail_master', $td->id_detail_master],['myorder', $td->myorder]])
            ->update([
                'amount_to'     => $td->amount,
                'change_amount' => $changeAmountDetail,
                'updated_at'    => now(),
            ]);
        }
        
        return redirect()->back()->with('success', 'Perubahan Pembayaran Berhasil ditambahkan. Silahkan cek rincian');
    }

    public function destroy($id)
    {
        $cr = DB::table('tm_change_cost_payments as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tm_periods as c', 'b.period','=','c.id')
            ->join('tm_cost_payments as d', 'a.id_cost_payment_from','=','d.id')
            ->join('tm_cost_payments as e', 'a.id_cost_payment_to','=','e.id')
            ->join('tm_grades as f', 'd.grade','=','f.id')
            ->leftJoin('tm_majors as g', 'd.major','=','g.id')
            ->join('tm_grades as h', 'e.grade','=','h.id')
            ->leftJoin('tm_majors as i', 'e.major','=','i.id')
            ->select('b.name as name_phase','c.period as name_period',
                'f.name as name_grade_from','g.name as name_major_from',
                'h.name as name_grade_to','i.name as name_major_to')
            ->where('a.id', $id)
            ->first();
        $name = $cr->name_phase.' Periode '.$cr->name_period.' '.$cr->name_grade_from.' '.$cr->name_major_from.' ke '.$cr->name_grade_to.' '.$cr->name_major_to;
        DB::table('tm_change_cost_payments')->where('id', $id)->delete();
        DB::table('tm_change_cost_payment_details')->where('id_change_cost', $id)->delete();

        return redirect()->back()->with('success', 'Perubahan Biaya '.$name.' berhasil di hapus');
    }
}
