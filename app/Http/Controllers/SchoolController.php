<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TmSchoolsImport;
use Maatwebsite\Excel\Validators\ValidationException;

class SchoolController extends Controller
{
    public function index(Request $r)
    {
        $c_province    = $r->input('f_province') ?? '02';
        $c_city        = $r->input('f_city') ?? '0205';
        $c_distric     = $r->input('f_distric') ?? '0205017';
        $si            = DB::table('school_infos')->select('name','icon')->first();
        $province      = DB::table('tm_provinces')->select('code','name')->get();
        $name_province = DB::table('tm_provinces')->select('name')->where('code',$c_province)->first();
        $name_city     = DB::table('tm_citys')->select('name')->where('code',$c_city)->first();
        $name_distric  = DB::table('tm_districs')->select('name')->where('code',$c_distric)->first();

        return view('master.school',['si'=>$si,'province'=>$province,'c_province'=>$c_province,'c_city'=>$c_city,'c_distric'=>$c_distric,
            'name_province'=>$name_province,'name_city'=>$name_city,'name_distric'=>$name_distric]);
    }

    public function data(Request $r)
    {
        $province = $r->input('f_province');
        $city     = $r->input('f_city');
        $distric  = $r->input('f_distric');
        
        if ($r->ajax()) {
            $data = DB::table('tm_schools as a')
                ->join('tm_provinces as b', 'a.code_province','=','b.code')
                ->join('tm_citys as c', 'a.code_city','=','c.code')
                ->join('tm_districs as d', 'a.code_distric','=','d.code')
                ->select('a.id','a.code','a.name','a.address','a.status','a.code_province','b.name as province','a.code_city','c.name as city','a.code_distric',
                    'd.name as distric','a.created_at','a.updated_at')
                ->where([['a.code_province', $province],['a.code_city', $city],['a.code_distric', $distric]])
                ->get();
            
            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $data_fix[] = [
                    'id'            => $d->id,
                    'code'          => $d->code,
                    'name'          => $d->name,
                    'address'       => $d->address,
                    'status'        => $d->status,
                    'code_province' => $d->code_province,
                    'province'      => $d->province,
                    'code_city'     => $d->code_city,
                    'city'          => $d->city,
                    'code_distric'  => $d->code_distric,
                    'distric'       => $d->distric,
                    'updated_at'    => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-kode="'.$row['code'].'" data-coreui-nama="'.$row['name'].'" data-coreui-alamat="'.$row['address'].'" data-coreui-status="'.$row['status'].'" data-coreui-provinsi="'.$row['code_province'].'" data-coreui-kabkot="'.$row['code_city'].'" data-coreui-kabkot-des="'.$row['city'].'" data-coreui-kecamatan="'.$row['code_distric'].'" data-coreui-kecamatan-des="'.$row['distric'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('sekolah/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
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
            'name'     => 'required|string',
            'code'     => 'required|string',
            'address'  => 'required|string',
            'status'   => 'required|in:NEGERI,SWASTA',
            'province' => 'required|string',
            'city'     => 'required|string',
            'distric'  => 'required|string',
        ];
    
        $messages = [
            'name.required'     => 'Nama wajib diisi',
            'name.string'       => 'Nama harus berupa string',
            'code.required'     => 'NPSN wajib diisi',
            'code.string'       => 'NPSN harus berupa string',
            'address.required'  => 'Alamat wajib diisi',
            'address.string'    => 'Alamat harus berupa string',
            'status.required'   => 'Status wajib diisi',
            'status.string'     => 'Status tidak sesuai pilihan',
            'province.required' => 'Provinsi wajib diisi',
            'province.string'   => 'Provinsi harus berupa string',
            'city.required'     => 'Kabupaten/Kota wajib diisi',
            'city.string'       => 'Kabupaten/Kota harus berupa string',
            'distric.required'  => 'Kecamatan wajib diisi',
            'distric.string'    => 'Kecamatan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Sekolah gagal di tambah: '.$validator->errors());
        }

        $name     = $r->input('name');
        $code     = $r->input('code');
        $address  = $r->input('address');
        $status   = $r->input('status');
        $province = $r->input('province');
        $city     = $r->input('city');
        $distric  = $r->input('distric');

        DB::table('tm_schools')
        ->insert([
            'name'          => $name,
            'code'          => $code,
            'address'       => $address,
            'status'        => $status,
            'code_province' => $province,
            'code_city'     => $city,
            'code_distric'  => $distric,
            'created_at'    => now()
        ]);
        
        return redirect()->back()->with('success', 'Sekolah berhasil di tambah');
    }

    public function upload(Request $r)
    {
        $rules = [
            'upload'      => 'required|mimes:xlsx',
            'fu_province' => 'required|string',
            'fu_city'     => 'required|string',
            'fu_distric'  => 'required|string',
        ];
    
        $messages = [
            'upload.required'      => 'Upload wajib diisi',
            'upload.mimes'         => 'Upload harus berformat XLSX',
            'fu_province.required' => 'Provinsi wajib diisi',
            'fu_province.string'   => 'Provinsi harus berupa string',
            'fu_city.required'     => 'Kabupaten/Kota wajib diisi',
            'fu_city.string'       => 'Kabupaten/Kota harus berupa string',
            'fu_distric.required'  => 'Kecamatan wajib diisi',
            'fu_distric.string'    => 'Kecamatan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Sekolah gagal di upload: '.$validator->errors());
        }

        $file     = $r->file('upload');
        $province = $r->input('fu_province');
        $city     = $r->input('fu_city');
        $distric  = $r->input('fu_distric');

        try {
            Excel::import(new TmSchoolsImport($province, $city, $distric), $file);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $f) {
                $fail_fix[] = [
                    'row'       => $f->row(),
                    'attribute' => $f->attribute(),
                    'error'     => $f->errors(),
                    'value'     => $f->values(),
                ];
            }
            return redirect()->back()->with('error', 'Sekolah gagal di upload: '.$fail_fix[0]['error']);
        }
        
        return redirect()->back()->with('success', 'Sekolah berhasil di upload');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'       => 'required|integer',
            'name'     => 'required|string',
            'code'     => 'required|string',
            'address'  => 'required|string',
            'status'   => 'required|in:NEGERI,SWASTA',
            'province' => 'required|string',
            'city'     => 'required|string',
            'distric'  => 'required|string',
        ];
    
        $messages = [
            'id.required'       => 'ID tidak ditemukan',
            'id.integer'        => 'ID tidak sesuai',
            'name.required'     => 'Nama wajib diisi',
            'name.string'       => 'Nama harus berupa string',
            'code.required'     => 'NPSN wajib diisi',
            'code.string'       => 'NPSN harus berupa string',
            'address.required'  => 'Alamat wajib diisi',
            'address.string'    => 'Alamat harus berupa string',
            'status.required'   => 'Status wajib diisi',
            'status.string'     => 'Status tidak sesuai pilihan',
            'province.required' => 'Provinsi wajib diisi',
            'province.string'   => 'Provinsi harus berupa string',
            'city.required'     => 'Kabupaten/Kota wajib diisi',
            'city.string'       => 'Kabupaten/Kota harus berupa string',
            'distric.required'  => 'Kecamatan wajib diisi',
            'distric.string'    => 'Kecamatan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Sekolah gagal di update: '.$validator->errors());
        }
        
        $id       = $r->input('id');
        $name     = $r->input('name');
        $code     = $r->input('code');
        $address  = $r->input('address');
        $status   = $r->input('status');
        $province = $r->input('province');
        $city     = $r->input('city');
        $distric  = $r->input('distric');

        $sch = DB::table('tm_schools')->select('name')->where('id', $id)->first();

        DB::table('tm_schools')
        ->where('id', $id)
        ->update([
            'name'          => $name,
            'code'          => $code,
            'address'       => $address,
            'status'        => $status,
            'code_province' => $province,
            'code_city'     => $city,
            'code_distric'  => $distric,
            'updated_at'    => now()
        ]);
        
        return redirect()->back()->with('success', 'Sekolah '.$sch->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $sch = DB::table('tm_schools')->select('name')->where('id', $id)->first();
        DB::table('tm_schools')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Sekolah '.$sch->name.' berhasil di hapus');
    }
}
