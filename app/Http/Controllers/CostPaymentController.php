<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CostPaymentController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $phase = DB::table('tm_phase_registrations as a')
            ->join('tm_periods as b', 'a.period','=','b.id')
            ->select('a.id','a.name','b.period as name_period')
            ->get();
        $grade = DB::table('tm_grades')->select('id','name')->get();
        $major = DB::table('tm_majors')->select('id','name')->get();

        return view('master.cost-payment',['si'=>$si,'phase'=>$phase,'grade'=>$grade,'major'=>$major]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_cost_payments as a')
                ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
                ->join('tm_periods as c', 'b.period','=','c.id')
                ->join('tm_grades as d', 'a.grade','=','d.id')
                ->leftJoin('tm_majors as e', 'a.major','=','e.id')
                ->select('a.id','a.phase','b.name as name_phase','c.period as name_period','a.grade','d.name as name_grade','a.major','e.name as name_major','a.amount','a.updated_at','a.created_at');
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

                $data_fix[] = [ 
                    'id'          => $d->id,
                    'phase'       => $d->phase,
                    'name_phase'  => $name_phase,
                    'grade'       => $d->grade,
                    'name_grade'  => $d->name_grade,
                    'major'       => $d->major,
                    'name_major'  => $d->name_major,
                    'amount'      => $d->amount,
                    'updated_at'  => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    if(empty($row['id'])){
                        $actionBtn = '';
                    }else{
                        $actionBtn = '
                            <a href="'.route('biaya-pembayaran-rincian',['id_pay'=>$row['id']]).'" class="btn btn-sm btn-success">Rincian</a>
                            <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name_phase'].'" data-coreui-url="'.url('biaya-pembayaran/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'phase'  => 'required|integer',
            'grade'  => 'required|integer',
            'major'  => 'nullable|integer',
        ];
    
        $messages = [
            'phase.required'  => 'Gelombang wajib diisi',
            'phase.integer'   => 'Gelombang tidak sesuai pilihan',
            'grade.required'  => 'Kelompok wajib diisi',
            'grade.integer'   => 'Kelompok tidak sesuai pilihan',
            'major.integer'   => 'Jurusan tidak sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Biaya gagal di tambah: '.$validator->errors());
        }
        
        $phase = $r->input('phase');
        $grade = $r->input('grade');
        $major = $r->input('major');

        $checkDuplicate = DB::table('tm_cost_payments')->where([['phase',$phase],['grade',$grade],['major',$major]])->count();
        if (!empty($checkDuplicate)) {
            return redirect()->back()->with('error', 'Biaya gagal di tambah: Gelombang, Kelompok dan Jurusan tidak boleh sama');
        }

        DB::table('tm_cost_payments')
        ->insert([
            'phase'      => $phase,
            'grade'      => $grade,
            'major'      => $major,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Biaya berhasil di tambah');
    }

    public function destroy($id)
    {
        $cr = DB::table('tm_cost_payments as a')
            ->join('tm_phase_registrations as b', 'a.phase','=','b.id')
            ->join('tm_periods as c', 'b.period','=','c.id')
            ->join('tm_grades as d', 'a.grade','=','d.id')
            ->leftJoin('tm_majors as e', 'a.major','=','e.id')
            ->select('b.name as name_phase','c.period as name_period','d.name as name_grade','e.name as name_major')
            ->where('a.id', $id)
            ->first();
        $name = $cr->name_phase.' Periode '.$cr->name_period.' '.$cr->name_grade.' '.$cr->name_major;
        DB::table('tm_cost_payments')->where('id', $id)->delete();
        DB::table('tm_cost_payment_details')->where('id_payment', $id)->delete();

        return redirect()->back()->with('success', 'Biaya '.$name.' berhasil di hapus');
    }
}
