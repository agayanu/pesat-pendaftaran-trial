<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BloodController extends Controller
{
    public function index()
    {
        $si    = DB::table('school_infos')->select('name','icon')->first();
        $blood = DB::table('tm_bloods')->get();

        return view('master.blood',['si'=>$si,'blood'=>$blood]);
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
            return redirect()->back()->withErrors($validator);
        }

        $name = $r->input('name');

        DB::table('tm_bloods')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Golongan Darah berhasil di tambah');
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
            return redirect()->back()->withErrors($validator);
        }

        $id   = $r->input('id');
        $name = $r->input('name');

        $bld  = DB::table('tm_bloods')->select('name')->where('id', $id)->first();

        DB::table('tm_bloods')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Golongan Darah '.$bld->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $bld = DB::table('tm_bloods')->select('name')->where('id', $id)->first();
        DB::table('tm_bloods')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Golongan Darah '.$bld->name.' berhasil di hapus');
    }
}
