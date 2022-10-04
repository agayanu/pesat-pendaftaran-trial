<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PhaseController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $period = DB::table('tm_periods')->select('id','period')->where('status','Y')->first();
        $periodList = DB::table('tm_periods')->select('id','period')->get();

        return view('master.phase',['si'=>$si,'period'=>$period,'periodList'=>$periodList]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_phase_registrations as a')
                ->join('tm_periods as b', 'a.period','=','b.id')
                ->select('a.id','a.period','b.period as name_period','a.name','a.status','a.cost','a.updated_at','a.created_at')
                ->get();
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                if($d->status === 'Y') {
                    $stats = 'Ya';
                } else {
                    $stats = 'Tidak';
                }

                if($d->cost === 'Y') {
                    $name_cost = 'Ya';
                } else {
                    $name_cost = 'Tidak';
                }

                $data_fix[] = [ 
                    'id'          => $d->id,
                    'period'      => $d->period,
                    'name_period' => $d->name_period,
                    'name'        => $d->name,
                    'status'      => $d->status,
                    'stats'       => $stats,
                    'cost'        => $d->cost,
                    'name_cost'   => $name_cost,
                    'updated_at'  => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = ' 
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-periode="'.$row['period'].'" data-coreui-namaperiode="'.$row['name_period'].'" data-coreui-nama="'.$row['name'].'" data-coreui-status="'.$row['status'].'" data-coreui-biaya="'.$row['cost'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].' Periode '.$row['period'].'" data-coreui-url="'.url('gelombang/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'period' => 'required|integer',
            'name'   => 'required|string|max:100',
            'cost'   => 'required|string|in:Y,N',
        ];
    
        $messages = [
            'period.required' => 'Periode wajib diisi',
            'period.integer'  => 'Periode tidak sesuai pilihan',
            'name.required'   => 'Nama wajib diisi',
            'name.string'     => 'Nama harus berupa string',
            'name.max'        => 'Nama maksimal 100 karakter',
            'cost.required'   => 'Biaya wajib diisi',
            'cost.string'     => 'Biaya harus berupa string',
            'cost.in'         => 'Biaya tidak sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Gelombang gagal di tambah: '.$validator->errors());
        }

        DB::table('tm_phase_registrations')
        ->where('status', 'Y')
        ->update([
            'status'     => 'N',
            'updated_at' => now()
        ]);

        $period = $r->input('period');
        $name   = $r->input('name');
        $cost   = $r->input('cost');

        DB::table('tm_phase_registrations')
        ->insert([
            'period'     => $period,
            'name'       => $name,
            'cost'       => $cost,
            'status'     => 'Y',
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Gelombang berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'     => 'required|integer',
            'period' => 'required|integer',
            'name'   => 'required|string|max:100',
            'status' => 'required|in:Y,N',
            'cost'   => 'required|in:Y,N',
        ];
    
        $messages = [
            'id.required'     => 'ID tidak ditemukan',
            'id.integer'      => 'ID tidak sesuai',
            'period.required' => 'Periode wajib diisi',
            'period.integer'  => 'Periode tidak sesuai pilihan',
            'name.required'   => 'Nama wajib diisi',
            'name.string'     => 'Nama harus berupa string',
            'name.max'        => 'Nama maksimal 100 karakter',
            'status.required' => 'Aktif wajib diisi',
            'status.in'       => 'Aktif harus sesuai pilihan',
            'cost.required'   => 'Biaya wajib diisi',
            'cost.in'         => 'Biaya harus sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Gelombang gagal di update: '.$validator->errors());
        }
        
        $id     = $r->input('id');
        $period = $r->input('period');
        $name   = $r->input('name');
        $status = $r->input('status');
        $cost   = $r->input('cost');

        if($status === 'Y'){
            DB::table('tm_phase_registrations')
            ->where('status', 'Y')
            ->update([
                'status'     => 'N',
                'updated_at' => now()
            ]);
        }

        $pr = DB::table('tm_phase_registrations')->select('name')->where('id', $id)->first();

        DB::table('tm_phase_registrations')
        ->where('id', $id)
        ->update([
            'period'     => $period,
            'name'       => $name,
            'status'     => $status,
            'cost'       => $cost,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Gelombang '.$pr->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $pr = DB::table('tm_phase_registrations')->select('name','status')->where('id', $id)->first();
        if($pr->status === 'Y'){
            return redirect()->back()->with('error', 'Gagal menghapus!!! '.$pr->name.' dalam kondisi aktif');
        }
        DB::table('tm_phase_registrations')->where('id', $id)->delete();

        return redirect()->back()->with('success', $pr->name.' berhasil di hapus');
    }
}
