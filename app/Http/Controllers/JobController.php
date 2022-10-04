<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    public function index()
    {
        $si      = DB::table('school_infos')->select('name','icon')->first();
        $job     = DB::table('tm_jobs')->select('id','name')->get();
        $jobDead = DB::table('tm_deads')->select('id_job')->first();

        return view('master.job',['si'=>$si,'job'=>$job,'jd'=>$jobDead]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_jobs')->get();
            
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $data_fix[] = [ 
                    'id'         => $d->id,
                    'name'       => $d->name,
                    'updated_at' => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-nama="'.$row['name'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('pekerjaan/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'name' => 'required|string',
        ];
    
        $messages = [
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Pekerjaan gagal di tambah: '.$validator->errors());
        }

        $name  = $r->input('name');

        DB::table('tm_jobs')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Pekerjaan berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'   => 'required|integer',
            'name' => 'required|string',
        ];
    
        $messages = [
            'id.required'   => 'ID tidak ditemukan',
            'id.integer'    => 'ID tidak sesuai',
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Pekerjaan gagal di update: '.$validator->errors());
        }
        
        $id   = $r->input('id');
        $name = $r->input('name');

        $jb = DB::table('tm_jobs')->select('name')->where('id', $id)->first();

        DB::table('tm_jobs')
        ->where('id', $id)
        ->update([
            'name'     => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Pekerjaan '.$jb->name.' berhasil di update');
    }

    public function dead(Request $r)
    {
        $rules = [
            'job' => 'required|integer',
        ];
    
        $messages = [
            'job.required' => 'Pekerjaan wajib diisi',
            'job.integer'  => 'Pekerjaan tidak sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Pekerjaan gagal di update: '.$validator->errors());
        }
        
        $job = $r->input('job');

        DB::table('tm_deads')
        ->where('id', 1)
        ->update([
            'id_job'     => $job,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Meninggal berhasil di update');
    }

    public function destroy($id)
    {
        $jb = DB::table('tm_jobs')->select('name')->where('id', $id)->first();
        DB::table('tm_jobs')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Pekerjaan '.$jb->name.' berhasil di hapus');
    }
}
