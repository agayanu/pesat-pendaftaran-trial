<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MajorController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('master.major',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_majors')->get();
            
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
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('jurusan/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            return redirect()->back()->withErrors($validator)->with('error', 'Jurusan gagal di tambah: '.$validator->errors());
        }

        $name = $r->input('name');

        DB::table('tm_majors')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Jurusan berhasil di tambah');
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
            return redirect()->back()->withErrors($validator)->with('error', 'Jurusan gagal di update: '.$validator->errors());
        }
        
        $id   = $r->input('id');
        $name = $r->input('name');

        $mj = DB::table('tm_majors')->select('name')->where('id', $id)->first();

        DB::table('tm_majors')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Jurusan '.$mj->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $mj = DB::table('tm_majors')->select('name')->where('id', $id)->first();
        DB::table('tm_majors')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Jurusan '.$mj->name.' berhasil di hapus');
    }
}
