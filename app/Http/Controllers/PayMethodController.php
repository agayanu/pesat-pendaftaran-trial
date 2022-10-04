<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PayMethodController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('master.pay-method',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_pay_methods')->get();
            
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
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('metode-bayar/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            return redirect()->back()->withErrors($validator)->with('error', 'Metode Bayar gagal di tambah: '.$validator->errors());
        }

        $name = $r->input('name');

        DB::table('tm_pay_methods')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Metode Bayar berhasil di tambah');
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
            return redirect()->back()->withErrors($validator)->with('error', 'Metode Bayar gagal di update: '.$validator->errors());
        }
        
        $id   = $r->input('id');
        $name = $r->input('name');

        $rl = DB::table('tm_pay_methods')->select('name')->where('id', $id)->first();

        DB::table('tm_pay_methods')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Metode Bayar '.$rl->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $rl = DB::table('tm_pay_methods')->select('name')->where('id', $id)->first();
        DB::table('tm_pay_methods')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Metode Bayar '.$rl->name.' berhasil di hapus');
    }
}
