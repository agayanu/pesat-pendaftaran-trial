<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PayBalanceController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('operator.pay-balance',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->join('tr_pay as e', 'a.id','=','e.id_regist')
                ->select('a.id','a.no_regist','d.name as phase','a.period','a.name','b.name as grade','c.name as major','e.bill','e.amount','e.balance','e.user','e.created_at','e.updated_at')
                ->where([['e.balance','!=',0],['a.status','!=',4]]);
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
                if($d->balance < 0) {
                    $pbalance = $d->balance * -1;
                    $balance = '(+)'.number_format($pbalance).' <a href="'.route('selisih-out',['id'=>$d->id]).'" class="btn btn-sm btn-primary">Keluarkan</a>';
                } else {
                    $balance = number_format($d->balance).' <a href="'.route('bayar-show',['id'=>$d->id]).'" class="btn btn-sm btn-primary">Bayar</a>';
                }
                if(empty($d->amount)) {
                    $amount = null;
                } else {
                    $amount = number_format($d->amount);
                }

                $data_fix[] = [ 
                    'id'           => $d->id,
                    'no_regist'    => $d->no_regist,
                    'phase'        => $phase,
                    'name'         => $d->name,
                    'grade'        => $d->grade,
                    'major'        => $d->major,
                    'bill'         => number_format($d->bill),
                    'amount'       => $amount,
                    'balance'      => $balance,
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
                ->rawColumns(['balance','action'])->make(true);
        }
    }

    public function out($id)
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

        return view('operator.payment-out',['si'=>$si,'d'=>$data]);
    }

    public function out_store(Request $r, $id)
    {
        $rules = [
            'remark' => 'nullable|string',
        ];
    
        $messages = [
            'remark.string' => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Gagal Dikeluarkan: '.$validator->errors());
        }

        $remark = $r->input('remark');
        $d      = DB::table('registrations as a')
                    ->join('tr_pay as b', 'a.id','=','b.id_regist')
                    ->select('b.id','b.balance')
                    ->where('a.id', $id)->first();
        $bp     = $d->balance * -1;
        $b      = '(+)'.number_format($bp);
        
        DB::table('tr_pay')
        ->where('id',$d->id)
        ->update([
            'balance' => 0,
            'updated_at' => now()
        ]);

        DB::table('tr_payment_outs')
        ->insert([
            'id_pay'     => $d->id,
            'amount'     => $bp,
            'remark'     => $remark,
            'user'       => Auth::user()->email,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', $b.' berhasil dikeluarkan');
    }
}
