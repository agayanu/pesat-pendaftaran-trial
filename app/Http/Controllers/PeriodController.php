<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PeriodController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $periodeNow = DB::table('tm_periods')->select('period')->where('status','Y')->first();
        $periode = $periodeNow->period + 1;

        return view('master.period',['si'=>$si,'periode'=>$periode]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_periods')
                ->select('id','period','status','updated_at','created_at')
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

                $data_fix[] = [ 
                    'id'         => $d->id,
                    'period'     => $d->period,
                    'stats'      => $stats,
                    'status'     => $d->status,
                    'updated_at' => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = ' 
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-periode="'.$row['period'].'" data-coreui-status="'.$row['status'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-period="'.$row['period'].'" data-coreui-url="'.url('periode/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'period' => 'required|integer|unique:tm_periods,period',
        ];
    
        $messages = [
            'period.required'     => 'Periode wajib diisi',
            'period.string'       => 'Periode harus berupa bilangan bulat',
            'period.unique'       => 'Periode sudah ada',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Periode gagal di tambah: '.$validator->errors());
        }

        DB::table('tm_periods')
        ->where('status', 'Y')
        ->update([
            'status'     => 'N',
            'updated_at' => now()
        ]);

        $period = $r->input('period');

        DB::table('tm_periods')
        ->insert([
            'period'     => $period,
            'status'     => 'Y',
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Periode berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'     => 'required|integer',
            'period' => 'required|integer',
            'status' => 'required|in:Y,N',
        ];
    
        $messages = [
            'id.required'     => 'ID tidak ditemukan',
            'id.integer'      => 'ID tidak sesuai',
            'period.required' => 'Period wajib diisi',
            'period.integer'  => 'Period harus berupa bilangan bulat',
            'status.required' => 'Aktif wajib diisi',
            'status.in'       => 'Aktif harus sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Periode gagal di update: '.$validator->errors());
        }

        $id     = $r->input('id');
        $period = $r->input('period');
        $status = $r->input('status');

        if($status === 'Y'){
            DB::table('tm_periods')
            ->where('status', 'Y')
            ->update([
                'status'     => 'N',
                'updated_at' => now()
            ]);
        }

        $prd = DB::table('tm_periods')->select('period')->where('id', $id)->first();

        DB::table('tm_periods')
        ->where('id', $id)
        ->update([
            'period'     => $period,
            'status'     => $status,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Periode '.$prd->period.' berhasil di update');
    }

    public function destroy($id)
    {
        $prd = DB::table('tm_periods')->select('period','status')->where('id', $id)->first();
        if($prd->status === 'Y'){
            return redirect()->back()->with('error', 'Gagal menghapus!!! Periode '.$prd->period.' dalam kondisi aktif');
        }
        DB::table('tm_periods')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Periode '.$prd->period.' berhasil di hapus');
    }
}
