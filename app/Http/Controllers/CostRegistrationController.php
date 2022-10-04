<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CostRegistrationController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $phase = DB::table('tm_phase_registrations as a')
            ->join('tm_periods as b', 'a.period','=','b.id')
            ->select('a.id','a.name','b.period as name_period')
            ->where('a.cost','Y')
            ->get();

        return view('master.cost-registration',['si'=>$si,'phase'=>$phase]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_cost_registrations as a')
                ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                ->join('tm_periods as c', 'b.period','=','c.id')
                ->select('a.id','a.phase','b.name as name_phase','c.period as name_period','a.amount','a.updated_at','a.created_at')
                ->get();
            
            if($data->isEmpty()){
                $data_fix[] = [ 
                    'id'          => '',
                    'phase'       => '',
                    'name_phase'  => '',
                    'amount'      => '',
                    'updated_at'  => ''
                ];
            }else{
                foreach ( $data as $d ) {
                    if(empty($d->updated_at)) {
                        $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                    } else {
                        $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                    }
    
                    $name = $d->name_phase.' Periode '.$d->name_period;
    
                    $data_fix[] = [ 
                        'id'          => $d->id,
                        'phase'       => $d->phase,
                        'name_phase'  => $name,
                        'amount'      => $d->amount,
                        'updated_at'  => $updated_at
                    ];
                }
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    if(empty($row['id'])){
                        $actionBtn = '';
                    }else{
                        $actionBtn = '
                            <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-nama="'.$row['name_phase'].'" data-coreui-gelombang="'.$row['phase'].'" data-coreui-biaya="'.$row['amount'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                            <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name_phase'].'" data-coreui-url="'.url('biaya-pendaftaran/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                            ';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'phase'  => 'required|integer|unique:tm_cost_registrations,phase',
            'amount' => 'required|integer',
        ];
    
        $messages = [
            'phase.required'  => 'Nama wajib diisi',
            'phase.integer'   => 'Nama tidak sesuai pilihan',
            'phase.unique'    => 'Nama sudah ada',
            'amount.required' => 'Biaya wajib diisi',
            'amount.integer'  => 'Biaya harus berupa bilangan bulat',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Biaya gagal di tambah: '.$validator->errors());
        }

        $phase  = $r->input('phase');
        $amount = $r->input('amount');

        DB::table('tm_cost_registrations')
        ->insert([
            'phase'      => $phase,
            'amount'     => $amount,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Biaya berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'     => 'required|integer',
            'amount' => 'required|integer',
        ];
    
        $messages = [
            'id.required'     => 'ID tidak ditemukan',
            'id.integer'      => 'ID tidak sesuai',
            'amount.required' => 'Biaya wajib diisi',
            'amount.integer'  => 'Biaya harus berupa bilangan bulat',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Biaya gagal di update: '.$validator->errors());
        }
        
        $id     = $r->input('id');
        $amount = $r->input('amount');

        $cr = DB::table('tm_cost_registrations as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tm_periods as c', 'b.period','=','c.id')
            ->select('b.name as name_phase','c.period as name_period')
            ->where('a.id', $id)
            ->first();

        DB::table('tm_cost_registrations')
        ->where('id', $id)
        ->update([
            'amount'     => $amount,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Biaya '.$cr->name_phase.' Periode '.$cr->name_period.' berhasil di update');
    }

    public function destroy($id)
    {
        $cr = DB::table('tm_cost_registrations as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tm_periods as c', 'b.period','=','c.id')
            ->select('b.name as name_phase','c.period as name_period')
            ->where('a.id', $id)
            ->first();
        DB::table('tm_cost_registrations')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Biaya '.$cr->name_phase.' Periode '.$cr->name_period.' berhasil di hapus');
    }
}
