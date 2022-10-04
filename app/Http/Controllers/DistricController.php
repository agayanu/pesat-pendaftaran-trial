<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DistricController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $province = DB::table('tm_provinces')->select('code','name')->where('active','Y')->orderBy('order','ASC')->get();

        return view('master.distric',['si'=>$si,'province'=>$province]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('tm_districs as a')
                ->join('tm_citys as b', 'a.code_city','=','b.code')
                ->join('tm_provinces as c', 'a.code_province','=','c.code')
                ->select('a.id','a.code','a.name','a.code_city','b.name as name_city','a.code_province','c.name as name_province','a.active','a.updated_at','a.created_at')
                ->get();
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
                    'id'            => $d->id,
                    'code'          => $d->code,
                    'name'          => $d->name,
                    'code_city'     => $d->code_city,
                    'name_city'     => $d->name_city,
                    'code_province' => $d->code_province,
                    'name_province' => $d->name_province,
                    'active'        => $active,
                    'aktif'         => $d->active,
                    'updated_at'    => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = ' 
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-kode="'.$row['code'].'" data-coreui-nama="'.$row['name'].'" data-coreui-kodekabkot="'.$row['code_city'].'" data-coreui-namakabkot="'.$row['name_city'].'" data-coreui-kodeprov="'.$row['code_province'].'" data-coreui-aktif="'.$row['aktif'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('kecamatan/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function json($city)
    {
        $distric = DB::table('tm_districs')
            ->select('code','name')
            ->where('code_city',$city)
            ->orderBy('name','ASC')
            ->get();

        return response()->json($distric);
    }

    public function store(Request $r)
    {
        $rules = [
            'code'     => 'required|string|max:12',
            'name'     => 'required|string',
            'province' => 'required|string|max:4',
            'city'     => 'required|string|max:8',
        ];
    
        $messages = [
            'code.required'     => 'Kode wajib diisi',
            'code.string'       => 'Kode harus berupa string',
            'code.max'          => 'Kode maksimal 12 karakter',
            'name.required'     => 'Nama wajib diisi',
            'name.string'       => 'Nama harus berupa string',
            'province.required' => 'Provinsi wajib diisi',
            'province.string'   => 'Provinsi harus berupa string',
            'province.max'      => 'Provinsi maksimal 4 karakter',
            'city.required'     => 'Kabupaten/Kota wajib diisi',
            'city.string'       => 'Kabupaten/Kota harus berupa string',
            'city.max'          => 'Kabupaten/Kota maksimal 8 karakter',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Kecamatan gagal di tambah: '.$validator->errors());
        }

        $code     = $r->input('code');
        $name     = $r->input('name');
        $province = $r->input('province');
        $city     = $r->input('city');

        DB::table('tm_districs')
        ->insert([
            'code'          => $code,
            'name'          => $name,
            'code_province' => $province,
            'code_city'     => $city,
            'active'        => 'Y',
            'created_at'    => now()
        ]);
        
        return redirect()->back()->with('success', 'Kecamatan berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'       => 'required|integer',
            'code'     => 'required|string|max:12',
            'name'     => 'required|string',
            'province' => 'required|string|max:4',
            'city'     => 'required|string|max:8',
            'active'   => 'required|in:Y,N',
        ];
    
        $messages = [
            'id.required'       => 'ID tidak ditemukan',
            'id.integer'        => 'ID tidak sesuai',
            'code.required'     => 'Kode wajib diisi',
            'code.string'       => 'Kode harus berupa string',
            'code.max'          => 'Kode maksimal 12 karakter',
            'name.required'     => 'Nama wajib diisi',
            'name.string'       => 'Nama harus berupa string',
            'province.required' => 'Provinsi wajib diisi',
            'province.string'   => 'Provinsi harus berupa string',
            'province.max'      => 'Provinsi maksimal 4 karakter',
            'city.required'     => 'Kabupaten/Kota wajib diisi',
            'city.string'       => 'Kabupaten/Kota harus berupa string',
            'city.max'          => 'Kabupaten/Kota maksimal 8 karakter',
            'active.required'   => 'Aktif wajib diisi',
            'active.in'         => 'Aktif harus sesuai pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Kecamatan gagal di update: '.$validator->errors());
        }

        $id       = $r->input('id');
        $code     = $r->input('code');
        $name     = $r->input('name');
        $province = $r->input('province');
        $city     = $r->input('city');
        $active   = $r->input('active');

        $dst  = DB::table('tm_districs')->select('name')->where('id', $id)->first();

        DB::table('tm_districs')
        ->where('id', $id)
        ->update([
            'code'          => $code,
            'name'          => $name,
            'code_province' => $province,
            'code_city'     => $city,
            'active'        => $active,
            'updated_at'    => now()
        ]);
        
        return redirect()->back()->with('success', 'Kecamatan '.$dst->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $dst = DB::table('tm_districs')->select('name')->where('id', $id)->first();
        DB::table('tm_districs')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Kecamatan '.$dst->name.' berhasil di hapus');
    }
}
