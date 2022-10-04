<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class HotlineController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $hotlineType = DB::table('tm_hotline_types')->select('id','name')->get();

        return view('master.hotline',['si'=>$si,'hotlineType'=>$hotlineType]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_hotlines as a')
                ->join('tm_hotline_types as b', 'a.type','=','b.id')
                ->select('a.id','a.name','a.type','b.name as name_type','a.lines','a.created_at','a.updated_at')
                ->get();
            
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $data_fix[] = [ 
                    'id'         => $d->id,
                    'name'       => $d->name,
                    'type'       => $d->type,
                    'name_type'  => $d->name_type,
                    'lines'      => $d->lines,
                    'updated_at' => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-nama="'.$row['name'].'" data-coreui-tipe="'.$row['type'].'" data-coreui-nomor="'.$row['lines'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('hotline/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'name'  => 'required|string',
            'type'  => 'required|integer',
            'lines' => 'required|string',
        ];
    
        $messages = [
            'name.required'  => 'Nama wajib diisi',
            'name.string'    => 'Nama harus berupa string',
            'type.required'  => 'Tipe wajib diisi',
            'type.integer'   => 'Tipe tidak sesuai pilihan',
            'lines.required' => 'Nomor wajib diisi',
            'lines.string'   => 'Nomor harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Hotline gagal di tambah: '.$validator->errors());
        }

        $name = $r->input('name');
        $type = $r->input('type');
        $lines = $r->input('lines');

        DB::table('tm_hotlines')
        ->insert([
            'name'       => $name,
            'type'       => $type,
            'lines'      => $lines,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Hotline berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'    => 'required|integer',
            'name'  => 'required|string',
            'type'  => 'required|integer',
            'lines' => 'required|string',
        ];
    
        $messages = [
            'id.required'    => 'ID tidak ditemukan',
            'id.integer'     => 'ID tidak sesuai',
            'name.required'  => 'Nama wajib diisi',
            'name.string'    => 'Nama harus berupa string',
            'type.required'  => 'Tipe wajib diisi',
            'type.integer'   => 'Tipe tidak sesuai pilihan',
            'lines.required' => 'Nomor wajib diisi',
            'lines.string'   => 'Nomor harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Hotline gagal di update: '.$validator->errors());
        }
        
        $id   = $r->input('id');
        $name = $r->input('name');
        $type = $r->input('type');
        $lines = $r->input('lines');

        $hl = DB::table('tm_hotlines')->select('name')->where('id', $id)->first();

        DB::table('tm_hotlines')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'type'       => $type,
            'lines'      => $lines,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Hotline '.$hl->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $hl = DB::table('tm_hotlines')->select('name')->where('id', $id)->first();
        DB::table('tm_hotlines')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Hotline '.$hl->name.' berhasil di hapus');
    }
}
