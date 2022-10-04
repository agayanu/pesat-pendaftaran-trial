<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('master.province',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_provinces')->get();
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                if($d->active === 'Y') {
                    $active = 'Ya';
                } else {
                    $active = 'Tidak';
                }

                $data_fix[] = [ 
                    'id'         => $d->id,
                    'code'       => $d->code,
                    'name'       => $d->name,
                    'order'      => $d->order,
                    'active'     => $active,
                    'aktif'      => $d->active,
                    'updated_at' => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = ' 
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-kode="'.$row['code'].'" data-coreui-nama="'.$row['name'].'" data-coreui-urutan="'.$row['order'].'" data-coreui-aktif="'.$row['aktif'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('provinsi/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'code'  => 'required|string|max:4',
            'name'  => 'required|string',
            'order' => 'required|integer|max:127',
        ];
    
        $messages = [
            'code.required'  => 'Kode wajib diisi',
            'code.string'    => 'Kode harus berupa string',
            'code.max'       => 'Kode maksimal 4 karakter',
            'name.required'  => 'Nama wajib diisi',
            'name.string'    => 'Nama harus berupa string',
            'order.required' => 'Urutan wajib diisi',
            'order.integer'  => 'Urutan harus berupa bilangan bulat',
            'order.max'      => 'Urutan maksimal 127',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Provinsi gagal di tambah: '.$validator->errors());
        }

        $code  = $r->input('code');
        $name  = $r->input('name');
        $order = $r->input('order');

        DB::table('tm_provinces')
        ->insert([
            'code'       => $code,
            'name'       => $name,
            'order'      => $order,
            'active'     => 'Y',
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Provinsi berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'     => 'required|integer',
            'code'   => 'required|string|max:4',
            'name'   => 'required|string',
            'order'  => 'required|integer|max:127',
            'active' => 'required|in:Y,N',
        ];
    
        $messages = [
            'id.required'     => 'ID tidak ditemukan',
            'id.integer'      => 'ID tidak sesuai',
            'code.required'   => 'Kode wajib diisi',
            'code.string'     => 'Kode harus berupa string',
            'code.max'        => 'Kode maksimal 4 karakter',
            'name.required'   => 'Nama wajib diisi',
            'name.string'     => 'Nama harus berupa string',
            'order.required'  => 'Urutan wajib diisi',
            'order.integer'   => 'Urutan harus berupa bilangan bulat',
            'order.max'       => 'Urutan maksimal 127',
            'active.required' => 'Aktif wajib diisi',
            'active.in'       => 'Aktif harus sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $id     = $r->input('id');
        $code   = $r->input('code');
        $name   = $r->input('name');
        $order  = $r->input('order');
        $active = $r->input('active');

        $pvc  = DB::table('tm_provinces')->select('name')->where('id', $id)->first();

        DB::table('tm_provinces')
        ->where('id', $id)
        ->update([
            'code'       => $code,
            'name'       => $name,
            'order'      => $order,
            'active'     => $active,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Provinsi '.$pvc->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $pvc = DB::table('tm_provinces')->select('name')->where('id', $id)->first();
        DB::table('tm_provinces')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Provinsi '.$pvc->name.' berhasil di hapus');
    }
}
