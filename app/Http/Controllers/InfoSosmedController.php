<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InfoSosmedController extends Controller
{
    public function index()
    {
        $si               = DB::table('school_infos')->select('name','icon')->first();
        $schoolInfoSosmed = DB::table('school_info_sosmeds')->get();

        return view('master.info-sosmed',['si'=>$si,'sinfo'=>$schoolInfoSosmed]);
    }

    public function store(Request $r)
    {
        $rules = [
            'name' => 'required|string',
            'url'  => 'required|string',
            'icon' => 'required|string',
        ];
    
        $messages = [
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
            'url.required'  => 'URL wajib diisi',
            'url.string'    => 'URL harus berupa string',
            'icon.required' => 'Icon wajib diisi',
            'icon.string'   => 'Icon harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $name = $r->input('name');
        $url  = $r->input('url');
        $icon = $r->input('icon');

        DB::table('school_info_sosmeds')
        ->insert([
            'name'       => $name,
            'url'        => $url,
            'icon'       => $icon,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Info Sosmed berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'   => 'required|integer',
            'name' => 'required|string',
            'url'  => 'required|string',
            'icon' => 'required|string',
        ];
    
        $messages = [
            'id.required'   => 'ID tidak ditemukan',
            'id.integer'    => 'ID tidak sesuai',
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
            'url.required'  => 'URL wajib diisi',
            'url.string'    => 'URL harus berupa string',
            'icon.required' => 'Icon wajib diisi',
            'icon.string'   => 'Icon harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $id   = $r->input('id');
        $name = $r->input('name');
        $url  = $r->input('url');
        $icon = $r->input('icon');

        $info = DB::table('school_info_sosmeds')->select('name')->where('id', $id)->first();

        DB::table('school_info_sosmeds')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'url'        => $url,
            'icon'       => $icon,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Info Sosmed '.$info->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $info = DB::table('school_info_sosmeds')->select('name')->where('id', $id)->first();
        DB::table('school_info_sosmeds')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Info Sosmed '.$info->name.' berhasil di hapus');
    }
}
